<?php
session_start();
include "db.php";  // Contains $conn

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Fetch form data safely
    $user_id = trim($_POST['user_id']);
    $password = trim($_POST['password']);

    // Check if user exists
    $sql = "SELECT * FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 1) {
        $user = $res->fetch_assoc();

        // Password validation
        if (password_verify($password, $user['password'])) {

            // Store user details in session
            $_SESSION['uid']      = $user['id'];
            $_SESSION['user_id']  = $user['user_id'];
            $_SESSION['name']     = $user['name'];

            header("Location: start.php");
            exit;
        } 
        else {
            $error = "❌ Invalid Password!";
        }
    } 
    else {
        $error = "❌ User ID not found!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ultimate Quiz!</title>

    <style>
        body {
            margin: 0;
            font-family: Poppins, Arial, sans-serif;
            background: linear-gradient(135deg, #0a0f24, #001a33);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
        }

        .login-box {
            width: 380px;
            background: rgba(0,0,0,0.6);
            padding: 35px;
            border-radius: 15px;
            box-shadow: 0 0 25px rgba(0,255,255,0.4);
            border: 1px solid cyan;
            animation: fadeIn 0.8s ease-in-out;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: cyan;
            text-shadow: 0 0 10px cyan;
            font-size: 28px;
        }

        label {
            font-weight: bold;
            color: #aeefff;
            display: block;
            margin-top: 10px;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-top: 6px;
            font-size: 16px;
            border-radius: 8px;
            border: 1px solid cyan;
            background: rgba(255,255,255,0.1);
            color: white;
        }

        input::placeholder {
            color: #b6eaff;
        }

        button {
            width: 100%;
            background: cyan;
            border: none;
            padding: 12px;
            font-size: 18px;
            color: #000;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s;
            margin-top: 18px;
        }

        button:hover {
            background: #5ffaff;
        }

        a {
            text-decoration: none;
            display: block;
            text-align: center;
            margin-top: 15px;
            font-size: 15px;
            color: #aeefff;
        }

        a:hover {
            color: cyan;
            text-shadow: 0 0 8px cyan;
        }

        .admin-btn {
            margin-top: 10px;
            background: transparent;
            border: 1px solid cyan;
            color: cyan;
        }

        .admin-btn:hover {
            background: cyan;
            color: #000;
        }

        .error {
            color: #ff6d6d;
            font-weight: bold;
            text-align: center;
            margin-bottom: 10px;
            font-size: 15px;
            text-shadow: 0 0 5px red;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

<body>

<div class="login-box">
    <h2>Ultimate Quiz!</h2>

    <?php 
    if (!empty($error)) {
        echo "<p class='error'>$error</p>";
    }
    ?>

    <form method="POST">
        <label>User ID:</label>
        <input type="text" name="user_id" placeholder="Enter your User ID" required>

        <label>Password:</label>
        <input type="password" name="password" placeholder="Enter your Password" required>

        <button type="submit">Login</button>
    </form>

    <a href="register.php">➡️ Create New Account</a>

    <!-- Admin Login Button -->
    <a href="admin_login.php">
        <button class="admin-btn">🔐 Admin Login</button>
    </a>
</div>

</body>
</html>
