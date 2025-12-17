<?php
require "../backend/db.php";
require "includes/university-auth.php";

$application_id = $_GET['id'];

// Fetch application details
$stmt = $conn->prepare("
    SELECT ja.*, j.title AS job_title
    FROM job_applications ja
    INNER JOIN jobs j ON ja.job_id = j.id
    WHERE ja.id = ?
");
$stmt->execute([$application_id]);
$app = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$app) { die("Invalid Application ID"); }

// Fetch student or faculty details
if ($app['student_id']) {
    $type = "Student";
    $q = $conn->prepare("SELECT * FROM students_profiles WHERE student_id = ?");
    $q->execute([$app['student_id']]);
    $user = $q->fetch(PDO::FETCH_ASSOC);
} else {
    $type = "Faculty";
    $q = $conn->prepare("SELECT * FROM faculty_profile WHERE faculty_id = ?");
    $q->execute([$app['faculty_id']]);
    $user = $q->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Applicant Details</title>

    <style>
        body { font-family: Arial; background: #f0f6f9; }
        .container { width: 90%; max-width: 900px; margin: 40px auto; }
        .box {
            background:white; padding:25px; border-radius:10px;
            box-shadow:0 8px 25px rgba(0,0,0,0.08);
        }
        .label { font-weight:bold; color:#555; display:block; margin-top:10px; }
        .value { color:#333; }
        a.btn { padding:10px 15px; background:#3498db; color:white; text-decoration:none; border-radius:6px; }
    </style>
</head>

<body>

<?php include "includes/header.php"; ?>

<div class="container">
    <div class="box">

        <h2>Application Details</h2>

        <p><strong>Job Title:</strong> <?= htmlspecialchars($app['job_title']); ?></p>
        <p><strong>Applicant Type:</strong> <?= $type; ?></p>

        <hr>

        <h3>Applicant Information</h3>

        <p><strong>Full Name:</strong> <?= $user['fullname']; ?></p>
        <p><strong>Email:</strong> <?= $user['email']; ?></p>
        <p><strong>Contact:</strong> <?= $user['contact']; ?></p>

        <?php if ($type == "Student"): ?>
            <p><strong>Degree:</strong> <?= $user['degree']; ?></p>
            <p><strong>CGPA:</strong> <?= $user['cgpa']; ?></p>
        <?php else: ?>
            <p><strong>Designation:</strong> <?= $user['designation']; ?></p>
            <p><strong>Experience:</strong> <?= $user['experience']; ?></p>
        <?php endif; ?>

        <hr>

        <h3>Documents</h3>
        <?php if ($app['resume']): ?>
            <a class="btn" href="../uploads/<?= $app['resume']; ?>" download>Download Resume</a>
        <?php endif; ?>

    </div>
</div>

</body>
</html>
