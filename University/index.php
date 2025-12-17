<?php
require "../backend/db.php";
require "includes/university-auth.php"; // University authentication

// Logged-in university ID
$university_id = $_SESSION['university_id'];


// Fetch university info
$stmt = $conn->prepare("SELECT uni_name FROM universities WHERE id = ?");
$stmt->execute([$university_id]);
$uni = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>University Dashboard</title>

    <!-- SAME STYLING AS FACULTY & STUDENT DASHBOARD -->
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

    <h2 class="welcome">Welcome, <?= htmlspecialchars($uni['uni_name']); ?> 👋</h2>

    <div class="grid-cards">

        <!-- Profile -->
        <a href="profile.php" class="dash-card">
            <h3>🏫 University Profile</h3>
            <p>Update university information, logo, contact details and description.</p>
        </a>

        <!-- Job Management -->
        <a href="manage-jobs.php" class="dash-card">
            <h3>💼 Manage Jobs</h3>
            <p>Create new job posts, edit existing jobs and track applicants.</p>
        </a>

        <!-- Job Applications -->
        <a href="job-applications.php" class="dash-card">
            <h3>📄 Job Applications</h3>
            <p>View which students/faculty applied to your job posts.</p>
        </a>

        <!-- Upload Programs -->
        <a href="manage-programs.php" class="dash-card">
            <h3>🎓 Academic Programs</h3>
            <p>Upload degree programs, criteria, fee structure and details.</p>
        </a>

        <!-- Program Applications -->
        <a href="program-applications.php" class="dash-card">
            <h3>📚 Program Applications</h3>
            <p>See all students who applied for your academic programs.</p>
        </a>

        <!-- Notifications -->
        <a href="notifications.php" class="dash-card">
            <h3>🔔 Notifications</h3>
            <p>Get updates about new applications and system alerts.</p>
        </a>

    </div>

</div>

<?php include "includes/footer.php"; ?>

</body>
</html>
