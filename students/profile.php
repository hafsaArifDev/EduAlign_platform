<?php
require "../backend/db.php";
require "includes/student-auth.php";

// Logged-in student ID
$student_id = $_SESSION['student_id'];

// Fetch basic student info
$stmt1 = $conn->prepare("SELECT fullname, email FROM students WHERE id = ?");
$stmt1->execute([$student_id]);
$student = $stmt1->fetch(PDO::FETCH_ASSOC);

// Fetch full profile
$stmt2 = $conn->prepare("SELECT * FROM students_profiles WHERE student_id = ?");
$stmt2->execute([$student_id]);
$profile = $stmt2->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Profile</title>

    <!-- MERGED CSS -->
    <style>
        body {
            margin: 0;
            padding: 0;
            background: #f0f6f9;
            font-family: 'Arial', sans-serif;
        }

        .dashboard-container {
            width: 90%;
            max-width: 900px;
            margin: 40px auto;
        }

        .welcome {
            text-align: center;
            font-size: 32px;
            font-weight: 700;
            background: linear-gradient(135deg, #1abc9c, #3498db);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 35px;
        }

        .profile-card {
            background: #fff;
            padding: 30px 35px;
            border-radius: 12px;
            box-shadow: 0 12px 30px rgba(0,0,0,0.12);
            font-size: 17px;
            line-height: 1.8;
        }

        .profile-card p {
            margin: 10px 0;
        }

        .profile-card strong {
            color: #1abc9c;
        }

        .section-title {
            margin-top: 25px;
            font-size: 22px;
            font-weight: 700;
            color: #3498db;
            border-left: 5px solid #1abc9c;
            padding-left: 10px;
        }

        .btn-edit {
            display: inline-block;
            margin-top: 25px;
            padding: 12px 25px;
            background: linear-gradient(135deg, #1abc9c, #27ae60);
            color: white !important;
            border-radius: 6px;
            font-size: 16px;
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s ease;
        }

        .btn-edit:hover {
            opacity: 0.9;
            transform: translateY(-3px);
        }
    </style>
</head>

<body>

<?php include "includes/header.php"; ?>

<div class="dashboard-container">

    <h2 class="welcome">My Profile 👤</h2>

    <div class="profile-card">

        <!-- ========================= -->
        <!-- PERSONAL INFORMATION -->
        <!-- ========================= -->
        <div class="section-title">Personal Information</div>

        <p><strong>Full Name:</strong> <?= htmlspecialchars($student['fullname']); ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($student['email']); ?></p>

        <p><strong>Date of Birth:</strong> <?= htmlspecialchars($profile['date_of_birth'] ?? 'Not added'); ?></p>
        <p><strong>Phone:</strong> <?= htmlspecialchars($profile['phone'] ?? 'Not added'); ?></p>
        <p><strong>CNIC:</strong> <?= htmlspecialchars($profile['cnic'] ?? 'Not added'); ?></p>
        <p><strong>Gender:</strong> <?= htmlspecialchars($profile['gender'] ?? 'Not added'); ?></p>


        <!-- ========================= -->
        <!-- ACADEMIC DETAILS -->
        <!-- ========================= -->
        <div class="section-title">Academic Information</div>

        <p><strong>Education Level:</strong> <?= htmlspecialchars($profile['education_level'] ?? 'Not added'); ?></p>
        <p><strong>Subjects Studied:</strong> <?= htmlspecialchars($profile['subjects'] ?? 'Not added'); ?></p>
        <p><strong>Grades / Marks:</strong> <?= htmlspecialchars($profile['grades'] ?? 'Not added'); ?></p>


        <!-- ========================= -->
        <!-- FUTURE & PREFERENCES -->
        <!-- ========================= -->
        <div class="section-title">Preferences & Goals</div>

        <p><strong>Desired Field of Study:</strong> <?= htmlspecialchars($profile['desired_field'] ?? 'Not added'); ?></p>
        <p><strong>Programs of Interest:</strong> <?= htmlspecialchars($profile['programs_interest'] ?? 'Not added'); ?></p>
        <p><strong>Preferred City / Location:</strong> <?= htmlspecialchars($profile['preferred_city'] ?? 'Not added'); ?></p>

    </div>

    <a href="edit-profile.php" class="btn-edit">✏️ Edit Profile</a>

</div>

<?php include "includes/footer.php"; ?>

</body>
</html>