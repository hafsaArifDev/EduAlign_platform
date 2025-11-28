<?php
require "../backend/db.php";
require "includes/student-auth.php";

// Logged-in student ID
$student_id = $_SESSION['student_id'];

// Fetch student info
$stmt = $conn->prepare("SELECT fullname FROM students WHERE id = ?");
$stmt->execute([$student_id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<?php include "includes/header.php"; ?>

<link rel="stylesheet" href="css/student.css">

<div class="dashboard-container">

    <h2 class="welcome">Welcome, <?= htmlspecialchars($student['fullname']); ?> 👋</h2>

    <div class="grid-cards">

        <!-- Profile Card -->
        <a href="profile.php" class="dash-card">
            <h3>🎓 Complete Profile</h3>
            <p>Fill your academic background, interests, and future goals.</p>
        </a>

        <!-- Suggested Programs -->
        <a href="suggested-programs.php" class="dash-card">
            <h3>✨ Suggested Programs</h3>
            <p>Get AI-matched programs based on your selected preferences.</p>
        </a>

        <!-- Notifications -->
        <a href="notifications.php" class="dash-card">
            <h3>🔔 Notifications</h3>
            <p>Check updates, approvals, and important alerts.</p>
        </a>

    </div>

</div>

<?php include "includes/footer.php"; ?>
