<?php
session_start();

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hard-coded admin credentials
    if($username == "admin" && $password == "admin123"){
        $_SESSION['admin'] = true;
        header("Location: manage_questions.php");
        exit();
    } else {
        $error = "Invalid admin credentials!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>

<style>
    /* MATCHING QUIZ BACKGROUND */
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

    /* GLASS CARD */
    .admin-box {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(12px);
        padding: 30px;
        width: 350px;
        border-radius: 15px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        animation: fadeSlide 1.2s ease;
        text-align: center;
    }

    /* ANIMATION */
    @keyframes fadeSlide {
        0% { opacity: 0; transform: translateY(40px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    .admin-box h2 {
        margin-bottom: 20px;
        font-size: 28px;
        font-weight: bold;
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

    .error-text {
        margin-top: 10px;
        color: #ffb3b3;
        font-weight: bold;
        animation: shake 0.4s ease;
    }

    /* ERROR SHAKE ANIMATION */
    @keyframes shake {
        0% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        50% { transform: translateX(5px); }
        75% { transform: translateX(-5px); }
        100% { transform: translateX(0); }
    }
</style>

</head>

<body>

<div class="admin-box">
    <h2>Admin Login</h2>

    <form method="POST">
        <input type="text" name="username" placeholder="Admin Username" required>
        <input type="password" name="password" placeholder="Admin Password" required>

        <button name="login">Login</button>

        <?php 
        if(isset($error)) { 
            echo "<p class='error-text'>$error</p>"; 
        } 
        ?>
    </form>
</div>

</body>
</html>
