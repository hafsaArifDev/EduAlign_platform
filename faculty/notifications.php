<?php
session_start();
require "../backend/db.php";

// اگر faculty login نہ ہو
if (!isset($_SESSION['faculty_id'])) {
    header("Location: login.php");
    exit;
}

$faculty_id = $_SESSION['faculty_id'];

// Faculty Notifications لانا
$getNotes = $conn->prepare("
    SELECT * FROM faculty_notifications 
    WHERE faculty_id = ? 
    ORDER BY timestamp DESC
");
$getNotes->execute([$faculty_id]);
$notifications = $getNotes->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Notifications</title>
    <link rel="stylesheet" href="css/faculty.css">

    <style>
        .note {
            background: #ffffff;
            padding: 15px;
            margin: 12px 0;
            border-radius: 8px;
            box-shadow: 0 0 8px rgba(0,0,0,0.12);
        }
        .unread {
            border-left: 4px solid #3498db;
            background: #ecf6ff;
        }
        .note p { margin: 0; font-size: 15px; }
        .note span {
            display: block;
            font-size: 12px;
            margin-top: 6px;
            color: #777;
        }
    </style>
</head>
<body>

<?php include "includes/header.php"; ?>

<div class="container">

<h2>Your Notifications</h2>

<?php if (isset($_GET['success'])): ?>
    <p class="success">Job application submitted successfully!</p>
<?php endif; ?>

<?php if (count($notifications) == 0): ?>
    <p>No notifications available.</p>
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
