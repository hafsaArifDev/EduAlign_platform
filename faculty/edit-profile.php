<?php
require "../backend/db.php";
require "includes/faculty-auth.php";

$faculty_id = $_SESSION['faculty_id'];

// Fetch profile
$stmt = $conn->prepare("SELECT * FROM faculty_profile WHERE faculty_id = ?");
$stmt->execute([$faculty_id]);
$profile = $stmt->fetch(PDO::FETCH_ASSOC);

$success = "";
$error = "";

// Uploads folder path
$upload_dir = __DIR__ . "/../uploads/";

if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Resume Upload
    $resume_name = $profile['resume'] ?? null;

    if (!empty($_FILES['resume']['name'])) {

        $ext = strtolower(pathinfo($_FILES['resume']['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, ['pdf', 'doc', 'docx'])) {
            $error = "Invalid resume file format.";
        } else {
            $resume_name = time() . "_" . basename($_FILES['resume']['name']);
            move_uploaded_file($_FILES['resume']['tmp_name'], $upload_dir . $resume_name);
        }
    }

    if (empty($error)) {

        $data = [
            // Personal Info
            $_POST['full_name'], $_POST['email'], $_POST['password'],
            $_POST['date_of_birth'], $_POST['cnic'], $_POST['gender'],
            $_POST['nationality'], $_POST['contact'], $_POST['address'],

            // Academic
            $_POST['degree'], $_POST['institution'], $_POST['passing_year'],
            $_POST['marks_cgpa'], $_POST['university'], $_POST['major_subjects'],

            // Experience
            $_POST['organization_name'], $_POST['designation'],
            $_POST['start_date'], $_POST['end_date'], $_POST['primary_teaching_subjects'],
            $_POST['research_interest'], $_POST['preferred_departments'],
            $_POST['certifications'], $_POST['skills'], $_POST['reference_contact'],

            $resume_name,
            $faculty_id
        ];

        if ($profile) {
            // Update profile
            $query = $conn->prepare("
                UPDATE faculty_profile SET
                fullname=?, email=?, password=?, date_of_birth=?, cnic=?, gender=?,
                nationality=?, contact=?, address=?,
                degree=?, institution=?, passing_year=?, marks_cgpa=?, university=?, major_subjects=?,
                organization_name=?, designation=?, start_date=?, end_date=?,
                primary_teaching_subjects=?, research_interest=?, preferred_departments=?,
                certifications=?, skills=?, reference_contact=?, resume=?
                WHERE faculty_id=?
            ");
        } else {
            // Insert new profile
            $query = $conn->prepare("
                INSERT INTO faculty_profile 
                (full_name,email,password,date_of_birth,cnic,gender,nationality,contact,address,
                degree,institution,passing_year,marks_cgpa,university,major_subjects,
                organization_name,designation,start_date,end_date,
                primary_teaching_subjects,research_interest,preferred_departments,
                certifications,skills,reference_contact,resume,faculty_id)
                VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
            ");
        }

        $query->execute($data);
        $success = "Profile updated successfully!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Faculty Profile</title>

    <style>
        body { margin:0; padding:0; font-family:Arial; background:#f3f8fa; }
        .form-container {
            width:90%; max-width:700px; margin:40px auto;
            background:white; padding:35px; border-radius:12px;
            box-shadow:0 10px 30px rgba(0,0,0,0.15);
        }
        h2 {
            text-align:center; font-size:28px; margin-bottom:25px;
            background:linear-gradient(135deg,#1abc9c,#3498db);
            -webkit-background-clip:text; -webkit-text-fill-color:transparent;
            font-weight:700;
        }
        h3 { margin-top:25px; color:#1abc9c; font-size:20px; font-weight:600; }

        input, select, textarea {
            width:100%; padding:12px; margin:10px 0 20px 0;
            border-radius:6px; border:1px solid #d7d7d7;
            background:#fafafa; font-size:15px;
        }
        textarea { height:90px; resize:none; }

        button {
            width:100%; padding:14px; background:linear-gradient(135deg,#1abc9c,#27ae60);
            border:none; border-radius:6px; color:white; font-size:17px;
            font-weight:600; cursor:pointer;
        }

        .success { background:#2ecc71; padding:12px; color:white; text-align:center; border-radius:6px; }
        .error { background:#e74c3c; padding:12px; color:white; border-radius:6px; margin-bottom:20px; }
     .btn-edit {
            display: block;
            margin-top: 25px;
            text-align: center;
            padding: 12px 0;
            background: linear-gradient(135deg, #1abc9c, #3498db);
            color: white !important;
            text-decoration: none;
            font-size: 17px;
            font-weight: 600;
            border-radius: 6px;
            transition: 0.3s ease;
        }
         .btn-edit:hover {
            opacity: 0.9;
            transform: translateY(-3px);
            box-shadow: 0px 3px 10px rgba(0,0,0,0.15);
        }
    </style>
</head>

<body>

<?php include "includes/header.php"; ?>

<div class="form-container">

    <h2>Edit Faculty Profile ✏️</h2>

    <?php if (!empty($success)) echo "<p class='success'>$success</p>"; ?>
    <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>

    <form method="POST" enctype="multipart/form-data">

        <h3>Personal Information</h3>

        <input type="text" name="full_name" placeholder="Full Name"
               value="<?= $profile['full_name'] ?? '' ?>" required>

        <input type="email" name="email" placeholder="Email"
               value="<?= $profile['email'] ?? '' ?>" required>

        <input type="password" name="password" placeholder="Password"
               value="<?= $profile['password'] ?? '' ?>" required>

        <input type="date" name="date_of_birth"
               value="<?= $profile['date_of_birth'] ?? '' ?>">

        <input type="text" name="cnic" placeholder="CNIC"
               value="<?= $profile['cnic'] ?? '' ?>">

        <select name="gender">
            <option value="">Select Gender</option>
            <option value="Male" <?= ($profile['gender'] ?? '')=='Male'?'selected':'' ?>>Male</option>
            <option value="Female" <?= ($profile['gender'] ?? '')=='Female'?'selected':'' ?>>Female</option>
            <option value="Other" <?= ($profile['gender'] ?? '')=='Other'?'selected':'' ?>>Other</option>
        </select>

        <input type="text" name="nationality" placeholder="Nationality"
               value="<?= $profile['nationality'] ?? '' ?>">

        <input type="text" name="contact" placeholder="Contact Number"
               value="<?= $profile['contact'] ?? '' ?>">

        <textarea name="address" placeholder="Full Address"><?= $profile['address'] ?? '' ?></textarea>

        <h3>Academic Qualifications</h3>

        <select name="degree">
            <option value="">Select Degree</option>
            <option value="Bachelors" <?= ($profile['degree'] ?? '')=='Bachelors'?'selected':'' ?>>Bachelors</option>
            <option value="Masters" <?= ($profile['degree'] ?? '')=='Masters'?'selected':'' ?>>Masters</option>
            <option value="MPhil" <?= ($profile['degree'] ?? '')=='MPhil'?'selected':'' ?>>MPhil</option>
            <option value="PhD" <?= ($profile['degree'] ?? '')=='PhD'?'selected':'' ?>>PhD</option>
        </select>

        <input type="text" name="institution" placeholder="Institution"
               value="<?= $profile['institution'] ?? '' ?>">

        <input type="text" name="passing_year" placeholder="Passing Year"
               value="<?= $profile['passing_year'] ?? '' ?>">

        <input type="text" name="marks_cgpa" placeholder="Marks / CGPA"
               value="<?= $profile['marks_cgpa'] ?? '' ?>">

        <input type="text" name="university" placeholder="University"
               value="<?= $profile['university'] ?? '' ?>">

        <textarea name="major_subjects" placeholder="Major Subjects"><?= $profile['major_subjects'] ?? '' ?></textarea>

        <h3>Professional Experience</h3>

        <input type="text" name="organization_name" placeholder="Organization Name"
               value="<?= $profile['organization_name'] ?? '' ?>">

        <input type="text" name="designation" placeholder="Designation"
               value="<?= $profile['designation'] ?? '' ?>">

        <label>Start Date</label>
        <input type="date" name="start_date"
               value="<?= $profile['start_date'] ?? '' ?>">

        <label>End Date</label>
        <input type="date" name="end_date"
               value="<?= $profile['end_date'] ?? '' ?>">

        <textarea name="primary_teaching_subjects" placeholder="Primary Teaching Subjects"><?= $profile['primary_teaching_subjects'] ?? '' ?></textarea>

        <textarea name="research_interest" placeholder="Research Interest"><?= $profile['research_interest'] ?? '' ?></textarea>

        <textarea name="preferred_departments" placeholder="Preferred Departments"><?= $profile['preferred_departments'] ?? '' ?></textarea>

        <textarea name="certifications" placeholder="Publications / Certifications"><?= $profile['certifications'] ?? '' ?></textarea>

        <textarea name="skills" placeholder="Skills"><?= $profile['skills'] ?? '' ?></textarea>

        <textarea name="reference_contact" placeholder="Reference Contact"><?= $profile['reference_contact'] ?? '' ?></textarea>

        <h3>Resume Upload</h3>

        <input type="file" name="resume">

        <?php if (!empty($profile['resume'])): ?>
            <p>Current Resume:
                <a href="../uploads/<?= $profile['resume'] ?>" target="_blank">View</a>
            </p>
        <?php endif; ?>

        <button type="submit">Save Profile</button>
           <a href="profile.php" class="btn-edit">Check Edited Profile</a>
    </form>

</div>

<?php include "includes/footer.php"; ?>

</body>
</html>