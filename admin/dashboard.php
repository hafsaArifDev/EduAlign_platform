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
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>

<?php include "includes/header.php"; ?>   <!-- ✔ صحیح path -->

<div class="container">
    <h1>Welcome, <?= htmlspecialchars($_SESSION['admin_name']) ?></h1>

    <div class="grid">
        <div class="card"><h3>Students</h3><p><?= $total_students ?></p></div>
        <div class="card"><h3>Faculty</h3><p><?= $total_faculty ?></p></div>
        <div class="card"><h3>Jobs</h3><p><?= $total_jobs ?></p></div>
        <div class="card"><h3>Programs</h3><p><?= $total_programs ?></p></div>
    </div>
</div>

<?php include "includes/footer.php"; ?>   <!-- ✔ صحیح path -->

</body>
</html>
