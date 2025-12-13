<?php
session_start();
include "db.php";

$res = $conn->query("SELECT * FROM results ORDER BY date_taken DESC");
?>
<!DOCTYPE html>
<html>
<head>
<title>Results</title>
<style>
table{border-collapse:collapse;width:100%;background:white;}
td,th{border:1px solid #ddd;padding:10px;}
th{background:#1e3a8a;color:white;}
.btn{padding:5px 10px;background:#06b6d4;color:white;text-decoration:none;border-radius:5px;}
</style>
</head>

<body>
<h2>All Quiz Attempts</h2>

<table>
<tr>
    <th>ID</th>
    <th>User ID</th>
    <th>Score</th>
    <th>Date</th>
    <th>Preview</th>
</tr>

<?php while($r=$res->fetch_assoc()): ?>
<tr>
    <td><?php echo $r['id']; ?></td>
    <td><?php echo $r['user_id']; ?></td>
    <td><?php echo $r['score']." / ".$r['total']; ?></td>
    <td><?php echo $r['date_taken']; ?></td>
    <td><a class="btn" href="preview.php?id=<?php echo $r['id']; ?>">Preview</a></td>
</tr>
<?php endwhile; ?>

</table>

</body>
</html>
