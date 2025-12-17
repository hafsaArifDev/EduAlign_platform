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

    <!-- ONLY STYLING FIX -->
    <style>
        body {
            background: #f0f6f9;
            font-family: Arial, sans-serif;
        }

        .container {
            width: 90%;
            max-width: 900px;
            margin: 40px auto;
        }

        h2 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 25px;
            background: linear-gradient(135deg, #1abc9c, #3498db);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .success {
            background: #e6fffa;
            color: #065f46;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .note {
            background: #ffffff;
            padding: 16px 18px;
            margin-bottom: 14px;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.08);
            border-left: 5px solid #3498db;
        }

        .note.unread {
            background: #f0f9ff;
            border-left-color: #1abc9c;
        }

        .note p {
            margin: 0;
            font-size: 15px;
            color: #374151;
        }

        .note span {
            display: block;
            margin-top: 6px;
            font-size: 12px;
            color: #6b7280;
        }

        .empty {
            background: #ffffff;
            padding: 26px;
            border-radius: 12px;
            text-align: center;
            color: #6b7280;
            box-shadow: 0 6px 18px rgba(0,0,0,0.08);
        }
    </style>
</head>
<body>

<?php include "includes/header.php"; ?>

<div class="container">

    <h2>Your Notifications</h2>

    <?php if (isset($_GET['success'])): ?>
        <div class="success">Job application submitted successfully!</div>
    <?php endif; ?>

    <?php if (count($notifications) === 0): ?>
        <div class="empty">No notifications available.</div>
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
