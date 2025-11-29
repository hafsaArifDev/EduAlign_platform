<?php
require "../backend/db.php";
require "includes/faculty-auth.php";

// Logged-in faculty ID
$faculty_id = $_SESSION['faculty_id'];

// Fetch basic faculty info
$stmt1 = $conn->prepare("SELECT fullname, email FROM faculty WHERE id = ?");
$stmt1->execute([$faculty_id]);
$faculty = $stmt1->fetch(PDO::FETCH_ASSOC);

// Fetch full faculty profile
$stmt2 = $conn->prepare("SELECT * FROM faculty_profile WHERE faculty_id = ?");
$stmt2->execute([$faculty_id]);
$profile = $stmt2->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Faculty Profile</title>

    <!-- PROFILE PAGE CSS -->
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

    <h2 class="welcome">My Faculty Profile 👤</h2>

    <div class="profile-card">

        <!-- ========================= -->
        <!-- PERSONAL INFORMATION -->
        <!-- ========================= -->
        <div class="section-title">Personal Information</div>

        <p><strong>Full Name:</strong> <?= htmlspecialchars($faculty['fullname']); ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($faculty['email']); ?></p>

        <p><strong>Date of Birth:</strong> <?= htmlspecialchars($profile['date_of_birth'] ?? 'Not added'); ?></p>
        <p><strong>CNIC:</strong> <?= htmlspecialchars($profile['cnic'] ?? 'Not added'); ?></p>
        <p><strong>Gender:</strong> <?= htmlspecialchars($profile['gender'] ?? 'Not added'); ?></p>
        <p><strong>Nationality:</strong> <?= htmlspecialchars($profile['nationality'] ?? 'Not added'); ?></p>
        <p><strong>Contact:</strong> <?= htmlspecialchars($profile['contact'] ?? 'Not added'); ?></p>
        <p><strong>Address:</strong> <?= htmlspecialchars($profile['address'] ?? 'Not added'); ?></p>


        <!-- ========================= -->
        <!-- ACADEMIC QUALIFICATIONS -->
        <!-- ========================= -->
        <div class="section-title">Academic Qualifications</div>

        <p><strong>Degree:</strong> <?= htmlspecialchars($profile['degree'] ?? 'Not added'); ?></p>
        <p><strong>Institution:</strong> <?= htmlspecialchars($profile['institution'] ?? 'Not added'); ?></p>
        <p><strong>Passing Year:</strong> <?= htmlspecialchars($profile['passing_year'] ?? 'Not added'); ?></p>
        <p><strong>Marks / CGPA:</strong> <?= htmlspecialchars($profile['marks_cgpa'] ?? 'Not added'); ?></p>
        <p><strong>University:</strong> <?= htmlspecialchars($profile['university'] ?? 'Not added'); ?></p>
        <p><strong>Major Subjects:</strong> <?= htmlspecialchars($profile['major_subjects'] ?? 'Not added'); ?></p>


        <!-- ========================= -->
        <!-- PROFESSIONAL EXPERIENCE -->
        <!-- ========================= -->
        <div class="section-title">Professional Experience</div>

        <p><strong>Organization Name:</strong> <?= htmlspecialchars($profile['organization_name'] ?? 'Not added'); ?></p>
        <p><strong>Designation:</strong> <?= htmlspecialchars($profile['designation'] ?? 'Not added'); ?></p>
        <p><strong>Start Date:</strong> <?= htmlspecialchars($profile['start_date'] ?? 'Not added'); ?></p>
        <p><strong>End Date:</strong> <?= htmlspecialchars($profile['end_date'] ?? 'Not added'); ?></p>
        <p><strong>Primary Teaching Subjects:</strong> <?= htmlspecialchars($profile['primary_teaching_subjects'] ?? 'Not added'); ?></p>
        <p><strong>Research Interest:</strong> <?= htmlspecialchars($profile['research_interest'] ?? 'Not added'); ?></p>
        <p><strong>Preferred Departments:</strong> <?= htmlspecialchars($profile['preferred_departments'] ?? 'Not added'); ?></p>
        <p><strong>Publications / Certifications:</strong> <?= htmlspecialchars($profile['certifications'] ?? 'Not added'); ?></p>
        <p><strong>Skills:</strong> <?= htmlspecialchars($profile['skills'] ?? 'Not added'); ?></p>


        <!-- ========================= -->
        <!-- REFERENCE -->
        <!-- ========================= -->
        <div class="section-title">Reference</div>
        <p><strong>Reference Detail:</strong> <?= htmlspecialchars($profile['reference_contact'] ?? 'Not added'); ?></p>


        <!-- ========================= -->
        <!-- RESUME -->
        <!-- ========================= -->
        <div class="section-title">Resume</div>

        <?php if (!empty($profile['resume'])): ?>
            <p><strong>Resume:</strong> 
                <a href="../uploads/<?= htmlspecialchars($profile['resume']); ?>" target="_blank">
                    View / Download
                </a>
            </p>
        <?php else: ?>
            <p><strong>Resume:</strong> Not uploaded</p>
        <?php endif; ?>

    </div>

    <!-- EDIT BUTTON -->
    <a href="edit-profile.php" class="btn-edit">✏️ Edit Profile</a>

</div>

<?php include "includes/footer.php"; ?>

</body>
</html>
