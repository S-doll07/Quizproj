<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "quiz_app");

/* ---------------- FETCH QUESTION ---------------- */
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid Question ID");
}

$id = intval($_GET['id']);

$q = $conn->prepare("SELECT * FROM questions WHERE id = ? LIMIT 1");
$q->bind_param("i", $id);
$q->execute();
$res = $q->get_result();

if ($res->num_rows == 0) {
    die("Question not found!");
}

$row = $res->fetch_assoc();

/* ---------------- UPDATE QUESTION ---------------- */
if (isset($_POST['update'])) {

    $question = trim($_POST['question']);
    $o1 = trim($_POST['option1']);
    $o2 = trim($_POST['option2']);
    $o3 = trim($_POST['option3']);
    $o4 = trim($_POST['option4']);

    // 🔥 FIX: ensure answer is always 1–4
    $answer = intval($_POST['answer']);
    if ($answer < 1 || $answer > 4) {
        $answer = $row['answer']; // fallback to old value
    }

    // 🔥 CORRECT BINDING: 5 strings + 2 integers
    $update = $conn->prepare("
        UPDATE questions 
        SET question=?, option1=?, option2=?, option3=?, option4=?, answer=? 
        WHERE id=?
    ");

    $update->bind_param(
        "sssssii",
        $question,
        $o1,
        $o2,
        $o3,
        $o4,
        $answer,
        $id
    );

    if ($update->execute()) {
        header("Location: manage_questions.php?updated=1");
        exit();
    } else {
        echo "<h3 style='color:red;'>Error: " . $conn->error . "</h3>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Edit Question</title>

<style>
body {
    background: linear-gradient(135deg, #6a11cb, #2575fc);
    font-family: Poppins, sans-serif;
    padding: 30px;
    color: white;
}
.container {
    width: 60%;
    margin: auto;
    background: rgba(255,255,255,0.15);
    padding: 25px;
    border-radius: 15px;
    backdrop-filter: blur(10px);
}
input, textarea, select {
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    border-radius: 8px;
    border: none;
    outline: none;
    font-size: 16px;
}
button {
    width: 100%;
    padding: 12px;
    background: #fff;
    color: #2575fc;
    border: none;
    border-radius: 8px;
    font-size: 18px;
    cursor: pointer;
    font-weight: bold;
}
button:hover {
    background: #e5e5e5;
}
a {
    color: white;
}
</style>

</head>
<body>

<div class="container">

<h2>Edit Question</h2>

<form method="POST">

<label>Question:</label>
<textarea name="question" required><?= $row['question'] ?></textarea>

<label>Option 1:</label>
<input type="text" name="option1" value="<?= $row['option1'] ?>" required>

<label>Option 2:</label>
<input type="text" name="option2" value="<?= $row['option2'] ?>" required>

<label>Option 3:</label>
<input type="text" name="option3" value="<?= $row['option3'] ?>" required>

<label>Option 4:</label>
<input type="text" name="option4" value="<?= $row['option4'] ?>" required>

<label>Correct Answer:</label>
<select name="answer" required>
    <option value="1" <?= ($row['answer']==1?"selected":"") ?>>Option 1</option>
    <option value="2" <?= ($row['answer']==2?"selected":"") ?>>Option 2</option>
    <option value="3" <?= ($row['answer']==3?"selected":"") ?>>Option 3</option>
    <option value="4" <?= ($row['answer']==4?"selected":"") ?>>Option 4</option>
</select>

<button name="update">Update Question</button>

</form>

<br>
<a href="manage_questions.php">← Back to Manage Questions</a>

</div>

</body>
</html>
