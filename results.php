<?php
session_start();
include "db.php";

// Safety check
if (!isset($_SESSION['answers'])) {
    $_SESSION['answers'] = [];
}

// Fetch all active questions
$q = $conn->query("SELECT * FROM questions WHERE is_active = 1 ORDER BY id ASC");
$questions = $q->fetch_all(MYSQLI_ASSOC);

$total = count($questions);
$score = 0;
$review_html = "";

// Process each question
foreach ($questions as $que) {

    $qid = $que['id'];
    $correct = $que['answer'];   // <-- using 'answer' column
    $user_ans = isset($_SESSION['answers'][$qid]) ? $_SESSION['answers'][$qid] : "Not Answered";

    if ($user_ans == $correct) {
        $score++;
    }

    // Build review section
    $review_html .= "
        <h3>Q{$qid}. {$que['question']}</h3>
        <p><b>Your answer:</b> " . 
            ($user_ans === "Not Answered" ? "Not Answered" : $que['option'.$user_ans]) . 
        "</p>
        <p><b>Correct answer:</b> {$que['option'.$correct]}</p>
        <hr>
    ";
}

// Save result in DB
$answers_json = json_encode($_SESSION['answers']);

$sql = "INSERT INTO results (user_id, score, total, answers) 
        VALUES ('{$_SESSION['user_id']}', '$score', '$total', '$answers_json')";
mysqli_query($conn, $sql);

?>
<!DOCTYPE html>
<html>
<head>
<title>Quiz Results</title>
<style>
body { 
    background:#111; 
    color:white; 
    font-family: Poppins;
    padding: 30px;
}
.box {
    background:#222;
    padding:25px;
    border-radius:10px;
    width:70%;
    margin:auto;
}
h2 { color:#00eaff; }
</style>
</head>

<body>
<div class="box">

<h2>Your Quiz Results</h2>

<p><b>User ID:</b> <?php echo $_SESSION['user_id']; ?></p>
<p><b>Score:</b> <?php echo $score; ?> / <?php echo $total; ?></p>
<p><b>Date:</b> <?php echo date("Y-m-d H:i:s"); ?></p>

<h2>Questions Review</h2>
<?php echo $review_html; ?>

</div>
</body>
</html>
