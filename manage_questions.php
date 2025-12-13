<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "quiz_app");

/* ---------- DELETE QUESTION ---------- */
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM questions WHERE id = $id");
    header("Location: manage_questions.php?deleted=1");
    exit();
}

/* ---------- TOGGLE ACTIVE/INACTIVE ---------- */
if (isset($_GET['toggle'])) {
    $id = intval($_GET['toggle']);
    $conn->query("UPDATE questions SET is_active = 1 - is_active WHERE id = $id");
    header("Location: manage_questions.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Manage Questions</title>

<style>
    body {
        font-family: 'Arial', sans-serif;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        margin: 0;
        padding: 0;
        color: #fff;
        display: flex;
        justify-content: center;
        align-items: flex-start;
        height: 100vh;
        overflow-y: auto;
        padding-top: 40px;
    }

    .container {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(12px);
        padding: 25px;
        width: 85%;
        border-radius: 15px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.3);
        animation: fadeSlide 1.1s ease;
    }

    @keyframes fadeSlide {
        0% { opacity: 0; transform: translateY(40px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    h2 {
        text-align: center;
        font-size: 32px;
        margin-bottom: 20px;
        text-shadow: 0 2px 10px rgba(0,0,0,0.2);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background: rgba(255,255,255,0.1);
        border-radius: 12px;
        overflow: hidden;
    }

    th, td {
        padding: 15px;
        font-size: 16px;
    }

    th {
        background: rgba(255,255,255,0.3);
    }

    tr {
        transition: 0.3s;
    }

    tr:hover {
        background: rgba(255,255,255,0.2);
        transform: scale(1.01);
    }

    .action-btn {
        padding: 8px 12px;
        background: #fff;
        color: #764ba2;
        border-radius: 6px;
        text-decoration: none;
        font-weight: bold;
        margin: 2px;
        display: inline-block;
        transition: 0.3s;
    }

    .action-btn:hover {
        transform: scale(1.1);
        background: #f3f3f3;
    }

    .delete-btn {
        background: #ff4b4b;
        color: white;
    }

    .delete-btn:hover {
        background: #ff2b2b;
    }

    .edit-btn {
        background: #00eaff;
        color: #000;
    }

    .edit-btn:hover {
        background: #11f5ff;
    }

    .bottom-btns {
        margin-top: 25px;
        text-align: center;
    }

    .btn {
        display: inline-block;
        padding: 12px 22px;
        background: #fff;
        color: #764ba2;
        border-radius: 10px;
        text-decoration: none;
        font-weight: bold;
        margin: 5px;
        transition: 0.3s;
    }

    .btn:hover {
        transform: scale(1.08);
        background: #f3f3f3;
    }
</style>
</head>

<body>

<div class="container">

    <h2>Manage Questions (Admin Only)</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Question</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>

        <?php
        $result = $conn->query("SELECT * FROM questions ORDER BY id DESC");

        while ($row = $result->fetch_assoc()) { ?>
        
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['question'] ?></td>
            <td><?= $row['is_active'] ? "Active" : "Inactive" ?></td>

            <td>
                <!-- Toggle Active -->
                <a class="action-btn" 
                   href="?toggle=<?= $row['id'] ?>">
                   <?= $row['is_active'] ? "Deactivate" : "Activate" ?>
                </a>

                <!-- Edit (FIXED PATH) -->
                <a class="action-btn edit-btn" 
                   href="/quiz_app/edit_question.php?id=<?= $row['id'] ?>">
                   Edit
                </a>

                <!-- Delete -->
                <a class="action-btn delete-btn" 
                   href="?delete=<?= $row['id'] ?>" 
                   onclick="return confirm('Delete this question?');">
                   Delete
                </a>
            </td>
        </tr>

        <?php } ?>
    </table>

    <div class="bottom-btns">
        <a class="btn" href="add_question.php">➕ Add New Question</a>
        <a class="btn" href="logout.php">🚪 Logout</a>
    </div>

</div>

</body>
</html>
