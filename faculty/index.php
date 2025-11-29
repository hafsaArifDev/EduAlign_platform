<?php
require "../backend/db.php";
require "includes/faculty-auth.php"; // Authentication for faculty

// Logged-in faculty ID
$faculty_id = $_SESSION['faculty_id'];

// Fetch faculty info
$stmt = $conn->prepare("SELECT fullname FROM faculty WHERE id = ?");
$stmt->execute([$faculty_id]);
$faculty = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Faculty Dashboard</title>

    <!-- SAME CSS AS STUDENT DASHBOARD -->
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

    <h2 class="welcome">Welcome, <?= htmlspecialchars($faculty['fullname']); ?> 👋</h2>

    <div class="grid-cards">

        <!-- Profile Card -->
        <a href="profile.php" class="dash-card">
            <h3>👤 Complete Faculty Profile</h3>
            <p>Update your personal, academic and professional details.</p>
        </a>

        <!-- Suggested Jobs -->
        <a href="suggested-jobs.php" class="dash-card">
            <h3>💼 Suggested Jobs</h3>
            <p>View AI-matched university jobs based on your expertise.</p>
        </a>

        <!-- Notifications -->
        <a href="notifications.php" class="dash-card">
            <h3>🔔 Notifications</h3>
            <p>Check job updates, application status and alerts.</p>
        </a>

    </div>

</div>

<?php include "includes/footer.php"; ?>

</body>
</html>
