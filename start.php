<?php
session_start();

// ❗ Prevent opening start.php without logging in
if (!isset($_SESSION['uid'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome to the Quiz</title>

    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: radial-gradient(circle at center, #0a0f1f, #000000);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #ffffff;
            overflow: hidden;
        }

        .container {
            text-align: center;
            animation: fadeIn 1.5s ease-in-out;
        }

        .title {
            font-size: 50px;
            font-weight: 700;
            margin-bottom: 20px;
            color: #00eaff;
            text-shadow: 0 0 15px #00eaff, 0 0 25px #0088ff;
            animation: glow 2s infinite alternate;
        }

        .subtitle {
            font-size: 22px;
            margin-bottom: 40px;
            opacity: 0.9;
        }

        .user-info {
            font-size: 20px;
            margin-bottom: 25px;
            color: #00eaff;
            text-shadow: 0 0 10px #00eaff;
        }

        .start-btn {
            display: inline-block;
            padding: 15px 40px;
            font-size: 22px;
            color: #000;
            background: #00eaff;
            border-radius: 8px;
            font-weight: bold;
            text-decoration: none;
            box-shadow: 0 0 15px #00eaff;
            transition: 0.3s ease;
        }

        .start-btn:hover {
            background: #00c6d9;
            box-shadow: 0 0 25px #00eaff, 0 0 45px #0099cc;
            transform: scale(1.1);
        }

        .logout-btn {
            display: block;
            margin-top: 30px;
            font-size: 16px;
            color: #ffffff;
            opacity: 0.7;
            text-decoration: none;
        }

        .logout-btn:hover {
            opacity: 1;
        }

        @keyframes glow {
            from { text-shadow: 0 0 10px #00eaff; }
            to   { text-shadow: 0 0 25px #00eaff, 0 0 35px #0088ff; }
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

<body>

<div class="container">

    <!-- 👇 ADDED USER DETAILS (Only this block is added inside design) -->
    <div class="user-info">
        Logged in as: <b><?php echo $_SESSION['name']; ?></b>  
        (ID: <b><?php echo $_SESSION['user_id']; ?></b>)
    </div>
    <!-- 👆 END NEW BLOCK -->

    <div class="title">Welcome to the Ultimate Quiz!</div>
    <div class="subtitle">Test your knowledge with our 10-Question Challenge</div>

    <a href="quiz.php?start=1" class="start-btn">Start Quiz</a>

    <!-- Logout button -->
    <a href="logout.php" class="logout-btn">Logout</a>

</div>

</body>
</html>
