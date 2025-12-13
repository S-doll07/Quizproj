<?php
// preview.php
session_start();
include __DIR__ . "/db.php"; // your DB connection; $conn expected

// Require login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Validate result id
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid Result ID");
}
$result_id = intval($_GET['id']);

// Fetch the result row using prepared statement
$stmt = $conn->prepare("SELECT * FROM results WHERE id = ? LIMIT 1");
$stmt->bind_param("i", $result_id);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows === 0) {
    die("Result not found!");
}
$result_data = $res->fetch_assoc();
$stmt->close();

// Try to read commonly-used columns from results table (safe)
$user_id    = $result_data['user_id'] ?? ($result_data['userid'] ?? 'unknown');
$username   = $result_data['username'] ?? ($result_data['name'] ?? ($result_data['user_id'] ?? ''));
$score      = isset($result_data['score']) ? intval($result_data['score']) : 0;
$total      = isset($result_data['total']) ? intval($result_data['total']) : 0;

// date column candidates: date_taken, date_time, created_at, created
$date_taken = $result_data['date_taken'] ?? $result_data['date_time'] ?? $result_data['created_at'] ?? $result_data['created'] ?? date('Y-m-d H:i:s');

// decode saved answers (stored as JSON string) — guard against invalid JSON
$saved_answers = [];
if (!empty($result_data['answers'])) {
    $tmp = json_decode($result_data['answers'], true);
    if (is_array($tmp)) $saved_answers = $tmp;
}

// Ensure $saved_answers keys are ints (question IDs)
$saved_answers_normalized = [];
foreach ($saved_answers as $k => $v) {
    $qid = intval($k);
    if ($qid > 0) $saved_answers_normalized[$qid] = $v;
}

// If there are no saved answers, show friendly message
if (empty($saved_answers_normalized)) {
    // still show header + message
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <title>Quiz Preview</title>
        <style>
            body{ background: linear-gradient(135deg,#00111d,#002f4b); color:#fff; font-family: Poppins, sans-serif; padding:24px; }
            .box{ background: rgba(0,0,0,0.45); padding:16px; border-radius:10px; border:1px solid rgba(0,255,255,0.08); max-width:900px; margin:auto; }
            .btn{ display:inline-block; margin-top:14px; padding:10px 16px; background:#00eaff; color:#000; border-radius:8px; text-decoration:none; font-weight:700; }
        </style>
    </head>
    <body>
    <div class="box">
        <h2>Quiz Preview</h2>
        <p><strong>User ID:</strong> <?php echo htmlspecialchars($user_id); ?></p>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($username); ?></p>
        <p><strong>Score:</strong> <?php echo $score . " / " . $total; ?></p>
        <p><strong>Date:</strong> <?php echo htmlspecialchars($date_taken); ?></p>

        <p style="color:#ffd7a8"><strong>No saved answers were found for this result, so there is nothing to preview.</strong></p>

        <a class="btn" href="quiz.php?start=1">🔄 Restart Quiz</a>
        <a class="btn" href="start.php" style="margin-left:8px">🏠 Back to Start</a>
    </div>
    </body>
    </html>
    <?php
    exit();
}

// --- Load only the questions that were part of this result (by id) ---
$questions = [];
// We'll prepare statement once and reuse
$qstmt = $conn->prepare("SELECT * FROM questions WHERE id = ? LIMIT 1");
foreach ($saved_answers_normalized as $qid => $uans) {
    $qstmt->bind_param("i", $qid);
    $qstmt->execute();
    $qres = $qstmt->get_result();
    if ($qres && $qres->num_rows > 0) {
        $questions[$qid] = $qres->fetch_assoc(); // store keyed by qid
    }
}
$qstmt->close();

// If no matching question rows found, show message
if (empty($questions)) {
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <title>Quiz Preview</title>
        <style>body{background:#00111d;color:#fff;font-family:Poppins;padding:24px}</style>
    </head>
    <body>
        <h2>No matching questions found for this result.</h2>
        <p>This can happen if the questions were deleted from the database after the attempt.</p>
        <a href="start.php">Back to Start</a>
    </body>
    </html>
    <?php
    exit();
}

// --- Prepare to render ---
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Quiz Preview</title>
<style>
    body {
        background: linear-gradient(135deg, #00111d, #002f4b);
        color: #fff;
        font-family: Poppins, sans-serif;
        padding: 20px;
    }
    .main-box {
        width: 90%;
        max-width: 980px;
        margin: auto;
        padding: 26px;
        background: rgba(0,0,0,0.35);
        border-radius: 12px;
        border: 1px solid rgba(0,255,255,0.12);
        box-shadow: 0 10px 30px rgba(0,0,0,0.5);
    }
    .summary { background: rgba(255,255,255,0.03); padding:14px; border-radius:8px; margin-bottom:16px; }
    .qcard { background: rgba(0,255,255,0.03); padding:14px; margin:14px 0; border-radius:8px; border-left:4px solid rgba(0,255,255,0.08); }
    .correct{ color:#7ef1b0; font-weight:700; }
    .wrong{ color:#ff9aa2; font-weight:700; }
    .meta { color:#cde9ff; font-size:13px; margin-bottom:6px; }
    .btn { display:inline-block; padding:10px 16px; background:#00eaff; color:#000; border-radius:8px; text-decoration:none; font-weight:700; margin-right:8px; }
</style>
</head>
<body>
<div class="main-box">
    <h1 style="color:#00eaff; text-align:center">📝 Quiz Preview</h1>

    <div class="summary">
        <div class="meta"><strong>User ID:</strong> <?php echo htmlspecialchars($user_id); ?> &nbsp; &nbsp; <strong>Name:</strong> <?php echo htmlspecialchars($username); ?></div>
        <div class="meta"><strong>Score:</strong> <?php echo $score . " / " . $total; ?> &nbsp; &nbsp; <strong>Date:</strong> <?php echo htmlspecialchars($date_taken); ?></div>
    </div>

    <h3 style="color:#cde9ff">Reviewed Questions (only answered questions appear)</h3>

    <?php
    // Iterate in the same order as saved answers so preview matches attempt order
    foreach ($saved_answers_normalized as $qid => $user_answer_raw) {
        // If question was deleted after the attempt, skip but show notice
        if (!isset($questions[$qid])) {
            echo "<div class='qcard'><strong>Q{$qid}.</strong> <em>Question no longer exists in database.</em></div>";
            continue;
        }

        $q = $questions[$qid];

        // user answer normalized (1..4) if valid; else null
        $user_idx = (is_numeric($user_answer_raw) && intval($user_answer_raw) >= 1 && intval($user_answer_raw) <= 4)
                    ? intval($user_answer_raw) : null;

        // correct index from DB (ensure 1..4 or null)
        $correct_idx = (isset($q['answer']) && is_numeric($q['answer']) && intval($q['answer']) >=1 && intval($q['answer']) <=4)
                       ? intval($q['answer']) : null;

        // option texts (safe)
        $opts = [
            1 => $q['option1'] ?? '',
            2 => $q['option2'] ?? '',
            3 => $q['option3'] ?? '',
            4 => $q['option4'] ?? '',
        ];
        ?>
        <div class="qcard">
            <div><strong>Q<?php echo $qid; ?>.</strong> <?php echo htmlspecialchars($q['question']); ?></div>
            <div style="margin-top:8px">
                <strong>Your answer:</strong>
                <?php if ($user_idx === null): ?>
                    <span class="wrong">Not Answered</span>
                <?php else: ?>
                    <span class="<?php echo ($correct_idx !== null && $user_idx == $correct_idx) ? 'correct' : 'wrong'; ?>">
                        <?php echo htmlspecialchars($opts[$user_idx] ?? $user_idx); ?>
                    </span>
                <?php endif; ?>
            </div>

            <div style="margin-top:6px">
                <strong>Correct answer:</strong>
                <?php if ($correct_idx === null): ?>
                    <span class="wrong">Not Set</span>
                <?php else: ?>
                    <span class="correct"><?php echo htmlspecialchars($opts[$correct_idx]); ?></span>
                <?php endif; ?>
            </div>
        </div>
        <?php
    } // end foreach saved answers
    ?>

    <div style="text-align:center; margin-top:18px">
        <a class="btn" href="quiz.php?start=1">🔄 Restart Quiz</a>
        <a class="btn" href="start.php">🏠 Back to Start</a>
    </div>
</div>
</body>
</html>
