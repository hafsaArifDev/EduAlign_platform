<?php
require "includes/admin-auth.php";
require "../backend/db.php";

// Summary numbers
$total_students = $conn->query("SELECT COUNT(*) FROM students_profiles")->fetchColumn();
$total_faculty = $conn->query("SELECT COUNT(*) FROM faculty_profile")->fetchColumn();
$total_jobs = $conn->query("SELECT COUNT(*) FROM jobs")->fetchColumn();
$total_programs = $conn->query("SELECT COUNT(*) FROM programs")->fetchColumn();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>

    <!-- MERGED CSS (Same as Student Dashboard) -->
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background: #f0f6f9;
        }

        .container {
            width: 90%;
            max-width: 1100px;
            margin: 50px auto;
        }

        .container h1 {
            font-size: 30px;
            font-weight: 700;
            color: #333;
            text-align: center;
            margin-bottom: 40px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
        }

        .card {
            background: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
            transition: 0.3s ease;
            border-top: 6px solid transparent;
            text-align: center;
        }

        .card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 35px rgba(0,0,0,0.12);
            border-top: 6px solid #1abc9c;
        }

        .card h3 {
            font-size: 22px;
            margin-bottom: 12px;
            background: linear-gradient(135deg, #1abc9c, #3498db);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .card p {
            font-size: 26px;
            font-weight: bold;
            color: #555;
            margin: 0;
        }
    </style>

</head>
<body>

<?php include "includes/header.php"; ?>

<div class="container">
    <h1>Welcome, <?= htmlspecialchars($_SESSION['admin_name']) ?></h1>

    <div class="grid">
        <div class="card"><h3>Students</h3><p><?= $total_students ?></p></div>
        <div class="card"><h3>Faculty</h3><p><?= $total_faculty ?></p></div>
        <div class="card"><h3>Jobs</h3><p><?= $total_jobs ?></p></div>
        <div class="card"><h3>Programs</h3><p><?= $total_programs ?></p></div>
    </div>
</div>

<?php include "includes/footer.php"; ?>

</body>
</html>
