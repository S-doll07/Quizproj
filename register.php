<?php
session_start();
include "db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $user_id = $_POST['user_id'];
    $name = $_POST['name'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (user_id, name, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $user_id, $name, $password);

    if ($stmt->execute()) {
        echo "<script>alert('Account created successfully!'); window.location='login.php';</script>";
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>

<style>
    /* PAGE BACKGROUND MATCHING QUIZ */
    body {
        font-family: 'Arial', sans-serif;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        height: 100vh;
        margin: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
        color: #fff;
    }

    /* CARD DESIGN */
    .register-box {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(12px);
        padding: 30px;
        width: 350px;
        border-radius: 15px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        animation: fadeSlide 1.2s ease;
    }

    /* ANIMATIONS */
    @keyframes fadeSlide {
        0% { opacity: 0; transform: translateY(40px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    .register-box h2 {
        text-align: center;
        margin-bottom: 20px;
        font-size: 26px;
    }

    input {
        width: 100%;
        padding: 12px;
        border: none;
        border-radius: 8px;
        margin-bottom: 15px;
        font-size: 15px;
        outline: none;
        transition: 0.3s;
    }

    input:focus {
        background: rgba(255,255,255,0.25);
        transform: scale(1.03);
    }

    button {
        width: 100%;
        padding: 12px;
        background: #fff;
        color: #764ba2;
        font-size: 16px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: bold;
        transition: 0.3s;
    }

    button:hover {
        background: #f3f3f3;
        transform: scale(1.05);
    }

    .link {
        display: block;
        text-align: center;
        margin-top: 15px;
        color: #fff;
        text-decoration: none;
        transition: 0.3s;
    }

    .link:hover {
        text-decoration: underline;
        letter-spacing: 1px;
    }
</style>

</head>

<body>

<div class="register-box">
    <h2>Create New Account</h2>

    <form method="POST">
        <input type="text" name="user_id" placeholder="Enter User ID" required>
        <input type="text" name="name" placeholder="Enter Name" required>
        <input type="password" name="password" placeholder="Enter Password" required>

        <button type="submit">Register</button>
    </form>

    <a class="link" href="login.php">Already have an account? Login</a>
</div>

</body>
</html>
