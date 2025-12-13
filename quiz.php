<?php
session_start();
include "db.php";

/* Block access if not logged in */
if (!isset($_SESSION['uid'])) {
    header("Location: login.php");
    exit;
}

/* RESET QUIZ */
if (isset($_GET['start']) && $_GET['start'] == 1) {
    unset($_SESSION['answers']);
    unset($_SESSION['current_q']);
    echo "<script>localStorage.removeItem('quiz_timer');</script>";
}

/* Load Active Questions */
$q = $conn->query("SELECT * FROM questions WHERE is_active = 1 ORDER BY id ASC");
$questions = $q->fetch_all(MYSQLI_ASSOC);
$total = count($questions);

if ($total == 0) {
    die("<h2 style='color:white;text-align:center;margin-top:40px;'>No active questions available.</h2>");
}

/* Current Question */
$current = isset($_SESSION['current_q']) ? $_SESSION['current_q'] : 1;
if (isset($_GET['q'])) $current = intval($_GET['q']);

if ($current < 1) $current = 1;
if ($current > $total) $current = $total;

$_SESSION['current_q'] = $current;

$question = $questions[$current - 1];
$qid = $question['id'];

/* Save Answer */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['answer'])) {
        $qid_post = key($_POST['answer']);
        $ans = $_POST['answer'][$qid_post];
        $_SESSION['answers'][$qid_post] = $ans;
    }

    if (isset($_POST["next"])) {
        $_SESSION['current_q']++;
        header("Location: quiz.php");
        exit;
    }

    if (isset($_POST["prev"])) {
        $_SESSION['current_q']--;
        header("Location: quiz.php");
        exit;
    }

    /* ✔ SUBMIT QUIZ */
    if (isset($_POST["submit_quiz"])) {
        header("Location: submit.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Quiz – Question <?php echo $current; ?></title>

<style>
body {
    font-family: Poppins, sans-serif;
    background: #0a0f24;
    margin: 0;
    padding: 0;
    color: white;
}

.container {
    width: 60%;
    margin: 40px auto;
    padding: 30px;
    background: rgba(0,0,0,0.55);
    border-radius: 18px;
    border: 1px solid rgba(0,255,255,0.3);
    box-shadow: 0 0 15px #00eaff;
}

.user-info {
    font-size: 18px;
    margin-bottom: 15px;
    color: #00eaff;
}

h2 {
    color: #00eaff;
    text-shadow: 0 0 8px #00eaff;
}

/* Neon Options */
.options label {
    display: block;
    margin: 12px 0;
    padding: 14px;
    background: rgba(0, 255, 255, 0.08);
    border: 1px solid rgba(0,255,255,0.3);
    border-radius: 10px;
    cursor: pointer;
    transition: 0.3s;
}
.options label:hover {
    background: rgba(0,255,255,0.22);
}

/* Neon Buttons */
button {
    padding: 12px 28px;
    margin: 5px;
    border: none;
    background: #00eaff;
    color: #000;
    font-size: 16px;
    border-radius: 8px;
    cursor: pointer;
    font-weight: bold;
    transition: 0.3s;
}
button:hover {
    background: #11f5ff;
}

/* Timer */
.timer {
    float: right;
    font-size: 22px;
    padding: 10px 20px;
    background: rgba(0,255,255,0.1);
    border: 1px solid #00eaff;
    border-radius: 10px;
    text-shadow: 0 0 6px cyan;
}
</style>
</head>

<body>

<div class="container">

<div class="user-info">
    Logged in as <b><?php echo $_SESSION['name']; ?></b>
    (ID: <b><?php echo $_SESSION['user_id']; ?></b>)
</div>

<div class="timer" id="timer">⏳ 10:00</div>

<h2>Question <?php echo $current; ?> / <?php echo $total; ?></h2>

<form method="POST">

    <h3><?php echo $question['question']; ?></h3>

    <?php
    $selected = $_SESSION['answers'][$qid] ?? "";
    ?>

    <div class="options">

        <label>
            <input type="radio" name="answer[<?php echo $qid; ?>]" value="1"
                <?php if ($selected == 1) echo "checked"; ?>>
            <?php echo $question['option1']; ?>
        </label>

        <label>
            <input type="radio" name="answer[<?php echo $qid; ?>]" value="2"
                <?php if ($selected == 2) echo "checked"; ?>>
            <?php echo $question['option2']; ?>
        </label>

        <label>
            <input type="radio" name="answer[<?php echo $qid; ?>]" value="3"
                <?php if ($selected == 3) echo "checked"; ?>>
            <?php echo $question['option3']; ?>
        </label>

        <label>
            <input type="radio" name="answer[<?php echo $qid; ?>]" value="4"
                <?php if ($selected == 4) echo "checked"; ?>>
            <?php echo $question['option4']; ?>
        </label>

    </div>

    <br>

    <?php if ($current > 1): ?>
        <button name="prev">Previous</button>
    <?php endif; ?>

    <?php if ($current < $total): ?>
        <button name="next">Next</button>
    <?php endif; ?>

    <?php if ($current == $total): ?>
        <button name="submit_quiz">Submit Quiz</button>
    <?php endif; ?>

</form>

</div>

<script>
let minutes = 10;
let seconds = 0;

let saved = localStorage.getItem("quiz_timer");
if (saved) [minutes, seconds] = saved.split(":").map(Number);

let t = setInterval(() => {

    if (minutes === 0 && seconds === 0) {
        clearInterval(t);
        localStorage.removeItem("quiz_timer");
        window.location.href = "submit.php?auto=1";
        return;
    }

    if (seconds === 0) { minutes--; seconds = 59; }
    else seconds--;

    let m = minutes.toString().padStart(2, "0");
    let s = seconds.toString().padStart(2, "0");

    document.getElementById("timer").innerText = "⏳ " + m + ":" + s;

    localStorage.setItem("quiz_timer", m + ":" + s);

}, 1000);
</script>

</body>
</html>
