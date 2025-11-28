<?php
session_start();
require "../backend/db.php";

if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit;
}

$student_id = $_SESSION['student_id'];

$notes = $conn->prepare("SELECT * FROM student_notifications WHERE student_id = ? ORDER BY timestamp DESC");
$notes->execute([$student_id]);
$notifications = $notes->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Notifications</title>
    <link rel="stylesheet" href="css/student.css">
</head>
<body>

<?php include "includes/header.php"; ?>

<div class="container">
<h2>Your Notifications</h2>

<?php if (isset($_GET['success'])): ?>
    <p class="success">Application submitted successfully!</p>
<?php endif; ?>

<?php foreach ($notifications as $n): ?>
<div class="note <?= $n['status'] == 'unread' ? 'unread' : '' ?>">
    <p><?= $n['message'] ?></p>
    <span><?= $n['timestamp'] ?></span>
</div>
<?php endforeach; ?>

</div>

<?php include "includes/footer.php"; ?>

</body>
</html>
