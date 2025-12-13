<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "quiz_app");

/* ---------- ADD QUESTION ---------- */
if (isset($_POST['add'])) {

    // Escape values
    $q = $conn->real_escape_string($_POST['question']);
    $a = $conn->real_escape_string($_POST['option1']);
    $b = $conn->real_escape_string($_POST['option2']);
    $c = $conn->real_escape_string($_POST['option3']);
    $d = $conn->real_escape_string($_POST['option4']);

    $correct = intval($_POST['answer']);
    $active = intval($_POST['active']);

    // Insert into DB
    $sql = "INSERT INTO questions (question, option1, option2, option3, option4, answer, is_active)
            VALUES ('$q', '$a', '$b', '$c', '$d', '$correct', '$active')";

    if ($conn->query($sql)) {
        header("Location: start.php?added=1");
        exit();
    } else {
        echo "<h3 style='color:red;text-align:center;'>Error: " . $conn->error . "</h3>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Add Question</title>

<style>
body {
    background: linear-gradient(135deg, #00111d, #00334d);
    font-family: Poppins, sans-serif;
    color: white;
    animation: fadeIn 1s ease-in-out;
    padding: 20px;
}

.back-btn {
    display: inline-block;
    padding: 10px 18px;
    background: #00eaff;
    color: black;
    text-decoration: none;
    font-weight: bold;
    border-radius: 8px;
    box-shadow: 0 0 10px cyan;
    transition: 0.3s;
    margin-bottom: 20px;
}

.back-btn:hover {
    transform: scale(1.05);
    background: #11f5ff;
}

.container {
    width: 60%;
    margin: auto;
    background: rgba(0,0,0,0.4);
    padding: 25px;
    border-radius: 15px;
    border: 1px solid cyan;
    box-shadow: 0 0 20px cyan;
    animation: slideDown 0.7s ease-in-out;
}

h2 {
    text-align: center;
    color: #00eaff;
    text-shadow: 0 0 12px cyan;
}

input, textarea, select {
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    border-radius: 8px;
    border: none;
    outline: none;
    font-size: 16px;
    background: rgba(255,255,255,0.1);
    color: white;
}

button {
    width: 100%;
    padding: 12px;
    background: #00eaff;
    color: black;
    border: none;
    font-size: 18px;
    border-radius: 10px;
    cursor: pointer;
    font-weight: bold;
    box-shadow: 0 0 10px cyan;
    transition: 0.3s;
}

button:hover {
    background: #11f5ff;
    transform: scale(1.05);
}

@keyframes fadeIn {
    from { opacity: 0; } to { opacity: 1; }
}
@keyframes slideDown {
    from { transform: translateY(-20px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}
</style>
</head>

<body>

<!-- 🔙 BACK BUTTON (Redirects to manage_questions.php) -->
<a href="manage_questions.php" class="back-btn">⬅ Back</a>

<div class="container">
    <h2>Add New Question</h2>

    <form method="POST">

        <textarea name="question" placeholder="Enter Question" required></textarea>

        <input type="text" name="option1" placeholder="Option 1" required>
        <input type="text" name="option2" placeholder="Option 2" required>
        <input type="text" name="option3" placeholder="Option 3" required>
        <input type="text" name="option4" placeholder="Option 4" required>

        <label>Correct Answer:</label>
        <select name="answer" required>
            <option value="1">Option 1</option>
            <option value="2">Option 2</option>
            <option value="3">Option 3</option>
            <option value="4">Option 4</option>
        </select>

        <label>Status:</label>
        <select name="active">
            <option value="1">Active</option>
            <option value="0">Inactive</option>
        </select>

        <button name="add">Add Question</button>

    </form>
</div>

</body>
</html>
