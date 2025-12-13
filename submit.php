<?php
session_start();
include "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_SESSION['answers'])) {
    $_SESSION['answers'] = [];
}

// Load active questions
$q = $conn->query("SELECT * FROM questions WHERE is_active = 1 ORDER BY id ASC");
$questions = $q->fetch_all(MYSQLI_ASSOC);

$total = count($questions);
$score = 0;
$correct_col = "answer";

// Revised: DO NOT force unanswered to 0
$final_answers = [];

foreach ($questions as $que) {

    $qid = $que['id'];
    $correct = intval($que[$correct_col]);

    if (isset($_SESSION['answers'][$qid])) {
        $user_ans = intval($_SESSION['answers'][$qid]);
        $final_answers[$qid] = $user_ans;
    } else {
        $user_ans = null;  // unanswered stays null
        $final_answers[$qid] = null;
    }

    if ($user_ans !== null && $user_ans == $correct) {
        $score++;
    }
}

$answers_json = json_encode($final_answers);

// Insert result
$stmt = $conn->prepare("
    INSERT INTO results (user_id, score, total, answers)
    VALUES (?, ?, ?, ?)
");

$stmt->bind_param("siis", $_SESSION['user_id'], $score, $total, $answers_json);
$stmt->execute();

$rid = $conn->insert_id;

if ($rid < 1) {
    die("ERROR: result insert failed.");
}

// Clear answers
unset($_SESSION['answers']);

header("Location: preview.php?id=$rid");
exit();

?>
