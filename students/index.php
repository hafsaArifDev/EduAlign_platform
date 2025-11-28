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

<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>

    <!-- MERGED CSS -->
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background: #f0f6f9;
        }

        .dashboard-container {
            width: 90%;
            max-width: 1100px;
            margin: 50px auto;
        }

        .welcome {
            font-size: 30px;
            font-weight: 700;
            color: #333;
            text-align: center;
            margin-bottom: 40px;
        }

        /* GRID CARDS */
        .grid-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
        }

        /* DASHBOARD CARD */
        .dash-card {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            text-decoration: none;
            display: block;
            color: #333;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
            transition: 0.3s ease;
            border-top: 6px solid transparent;
        }

        .dash-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 35px rgba(0,0,0,0.12);
            border-top: 6px solid #1abc9c;
        }

        .dash-card h3 {
            font-size: 22px;
            margin-bottom: 12px;
            background: linear-gradient(135deg, #1abc9c, #3498db);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .dash-card p {
            margin: 0;
            color: #555;
            font-size: 15px;
            line-height: 1.5;
        }
    </style>

</head>

<body>

<?php include "includes/header.php"; ?>

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

</body>
</html>