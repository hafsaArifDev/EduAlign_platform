<?php
require "../backend/db.php";
require "includes/university-auth.php";

$university_id = $_SESSION['university_id'];

// Application ID check
if (!isset($_GET['id'])) {
    die("Invalid request");
}

$app_id = $_GET['id'];

/*
    Fetch program application
    + program details
    + student basic info
    + student profile info
    (ONLY for current university)
*/
$stmt = $conn->prepare("
    SELECT 
        pa.id AS application_id,
        pa.applied_at,
        
        -- Program info
        COALESCE(p.title, p.program_name) AS program_title,
        p.fee,
        p.duration,
        p.description AS program_description,
        
        -- Student basic info
        s.fullname,
        s.email,
        
        -- Student profile info
        sp.phone,
        sp.cnic,
        sp.gender,
        sp.education_level,
        sp.subjects,
        sp.grades,
        sp.desired_field,
        sp.programs_interest,
        sp.preferred_city
        
    FROM program_applications pa
    INNER JOIN programs p ON pa.program_id = p.id
    INNER JOIN students s ON pa.student_id = s.id
    LEFT JOIN students_profiles sp ON s.id = sp.student_id
    WHERE pa.id = ?
      AND p.university_id = ?
");
$stmt->execute([$app_id, $university_id]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$data) {
    die("Application not found or access denied.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Program Application Details</title>

    <style>
        body {
            margin:0;
            font-family: Arial, sans-serif;
            background:#f0f6f9;
        }
        .container {
            width:90%;
            max-width:1000px;
            margin:40px auto;
        }
        .box {
            background:#fff;
            padding:30px;
            border-radius:12px;
            box-shadow:0 8px 25px rgba(0,0,0,0.08);
            margin-bottom:25px;
        }
        h2 {
            margin-top:0;
            color:#333;
        }
        h3 {
            margin-bottom:10px;
            color:#1abc9c;
        }
        .row {
            margin:8px 0;
        }
        .label {
            font-weight:bold;
            color:#555;
        }
        .value {
            color:#333;
        }
        .back-btn {
            display:inline-block;
            margin-top:20px;
            padding:10px 18px;
            background:#3498db;
            color:#fff;
            text-decoration:none;
            border-radius:6px;
            font-weight:600;
        }
    </style>
</head>

<body>

<?php include "includes/header.php"; ?>

<div class="container">

    <!-- PROGRAM DETAILS -->
    <div class="box">
        <h2>Program Details</h2>

        <div class="row">
            <span class="label">Program Title: </span>
            <span class="value"><?= htmlspecialchars($data['program_title']); ?></span>
        </div>

        <div class="row">
            <span class="label">Duration: </span>
            <span class="value"><?= htmlspecialchars($data['duration']); ?></span>
        </div>

        <div class="row">
            <span class="label">Fee: </span>
            <span class="value"><?= htmlspecialchars($data['fee']); ?></span>
        </div>

        <div class="row">
            <span class="label">Description: </span>
            <span class="value"><?= nl2br(htmlspecialchars($data['program_description'])); ?></span>
        </div>
    </div>

    <!-- STUDENT DETAILS -->
    <div class="box">
        <h2>Student Information</h2>

        <h3>Basic Information</h3>

        <div class="row">
            <span class="label">Full Name: </span>
            <span class="value"><?= htmlspecialchars($data['fullname']); ?></span>
        </div>

        <div class="row">
            <span class="label">Email: </span>
            <span class="value"><?= htmlspecialchars($data['email']); ?></span>
        </div>

        <h3>Profile Information</h3>

        <div class="row">
            <span class="label">Phone: </span>
            <span class="value"><?= htmlspecialchars($data['phone']); ?></span>
        </div>

        <div class="row">
            <span class="label">CNIC: </span>
            <span class="value"><?= htmlspecialchars($data['cnic']); ?></span>
        </div>

        <div class="row">
            <span class="label">Gender: </span>
            <span class="value"><?= htmlspecialchars($data['gender']); ?></span>
        </div>

        <div class="row">
            <span class="label">Education Level: </span>
            <span class="value"><?= htmlspecialchars($data['education_level']); ?></span>
        </div>

        <div class="row">
            <span class="label">Subjects: </span>
            <span class="value"><?= htmlspecialchars($data['subjects']); ?></span>
        </div>

        <div class="row">
            <span class="label">Grades: </span>
            <span class="value"><?= htmlspecialchars($data['grades']); ?></span>
        </div>

        <div class="row">
            <span class="label">Desired Field: </span>
            <span class="value"><?= htmlspecialchars($data['desired_field']); ?></span>
        </div>

        <div class="row">
            <span class="label">Program Interests: </span>
            <span class="value"><?= htmlspecialchars($data['programs_interest']); ?></span>
        </div>

        <div class="row">
            <span class="label">Preferred City: </span>
            <span class="value"><?= htmlspecialchars($data['preferred_city']); ?></span>
        </div>

        <div class="row">
            <span class="label">Applied On: </span>
            <span class="value"><?= $data['applied_at']; ?></span>
        </div>

        <a href="program-applications.php" class="back-btn">
            ← Back to Applications
        </a>
    </div>

</div>

</body>
</html>
