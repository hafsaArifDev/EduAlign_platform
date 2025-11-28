<?php
require "../backend/db.php";
require "includes/student-auth.php";

$student_id = $_SESSION['student_id'];

// Fetch existing profile
$stmt = $conn->prepare("SELECT * FROM students_profiles WHERE student_id = ?");
$stmt->execute([$student_id]);
$profile = $stmt->fetch(PDO::FETCH_ASSOC);

// If form submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $data = [
        $_POST['date_of_birth'],
        $_POST['phone'],
        $_POST['cnic'],
        $_POST['gender'],
        $_POST['education_level'],
        $_POST['subjects'],
        $_POST['grades'],
        $_POST['desired_field'],
        $_POST['programs_interest'],
        $_POST['preferred_city'],
        $student_id
    ];

    if ($profile) {
        $query = $conn->prepare("
            UPDATE students_profiles SET 
            date_of_birth=?, phone=?, cnic=?, gender=?,
            education_level=?, subjects=?, grades=?,
            desired_field=?, programs_interest=?, preferred_city=?
            WHERE student_id=?
        ");
    } else {
        $query = $conn->prepare("
            INSERT INTO students_profiles 
            (date_of_birth,phone,cnic,gender,education_level,subjects,grades,
            desired_field,programs_interest,preferred_city,student_id) 
            VALUES (?,?,?,?,?,?,?,?,?,?,?)
        ");
    }

    $query->execute($data);
    $success = "Profile updated successfully!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Profile</title>

    <!-- MERGED FORM CSS -->
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background: #f3f8fa;
        }

        .form-container {
            width: 90%;
            max-width: 650px;
            margin: 40px auto;
            background: #ffffff;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            transition: 0.3s ease;
        }

        .form-container:hover {
            transform: translateY(-4px);
        }

        h2 {
            text-align: center;
            font-size: 28px;
            margin-bottom: 25px;
            background: linear-gradient(135deg, #1abc9c, #3498db);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 700;
        }

        h3 {
            margin-top: 25px;
            color: #1abc9c;
            font-size: 20px;
            font-weight: 600;
        }

        input, select {
            width: 100%;
            padding: 12px;
            margin: 10px 0 20px 0;
            border-radius: 6px;
            border: 1px solid #d7d7d7;
            background: #fafafa;
            font-size: 15px;
            transition: 0.3s ease;
        }

        input:focus, select:focus {
            border-color: #3498db;
            background: #fff;
            outline: none;
            box-shadow: 0 0 6px rgba(52,152,219,0.3);
        }

        button {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #1abc9c, #27ae60);
            border: none;
            border-radius: 6px;
            color: white;
            font-size: 17px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s ease;
        }

        button:hover {
            opacity: 0.9;
            transform: translateY(-3px);
        }

        .success {
            padding: 12px;
            background: #2ecc71;
            color: white;
            border-radius: 6px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 600;
        }

        /* =============================== */
        /* STYLING FOR: Check Edited Profile BUTTON */
        /* =============================== */
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

    <h2>Update Profile ✏️</h2>

    <?php if (!empty($success)) echo "<p class='success'>$success</p>"; ?>

    <form method="POST">

        <h3>Personal Information</h3>

        <input type="date" name="date_of_birth"
               value="<?= $profile['date_of_birth'] ?? '' ?>" required>

        <input type="text" name="phone" placeholder="Phone Number"
               value="<?= $profile['phone'] ?? '' ?>" required>

        <input type="text" name="cnic" placeholder="CNIC"
               value="<?= $profile['cnic'] ?? '' ?>" required>

        <select name="gender" required>
            <option value="">Select Gender</option>
            <option value="Male" <?= ($profile['gender'] ?? '')=='Male'?'selected':'' ?>>Male</option>
            <option value="Female" <?= ($profile['gender'] ?? '')=='Female'?'selected':'' ?>>Female</option>
            <option value="Other" <?= ($profile['gender'] ?? '')=='Other'?'selected':'' ?>>Other</option>
        </select>

        <h3>Academic Information</h3>

        <select name="education_level" required>
            <option value="">Select Education Level</option>
            <option value="Matric" <?= ($profile['education_level'] ?? '')=='Matric'?'selected':'' ?>>Matric</option>
            <option value="Intermediate" <?= ($profile['education_level'] ?? '')=='Intermediate'?'selected':'' ?>>Intermediate</option>
            <option value="Bachelors" <?= ($profile['education_level'] ?? '')=='Bachelors'?'selected':'' ?>>Bachelors</option>
            <option value="Masters" <?= ($profile['education_level'] ?? '')=='Masters'?'selected':'' ?>>Masters</option>
        </select>

        <input type="text" name="subjects" placeholder="Subjects Studied"
               value="<?= $profile['subjects'] ?? '' ?>">

        <input type="text" name="grades" placeholder="Grades / Marks"
               value="<?= $profile['grades'] ?? '' ?>">

        <h3>Preferences</h3>

        <input type="text" name="desired_field" placeholder="Desired Field of Study"
               value="<?= $profile['desired_field'] ?? '' ?>">

        <input type="text" name="programs_interest" placeholder="Programs of Interest"
               value="<?= $profile['programs_interest'] ?? '' ?>">

        <input type="text" name="preferred_city" placeholder="Preferred City / Location"
               value="<?= $profile['preferred_city'] ?? '' ?>">

        <button type="submit">Save Profile</button>
    </form>

    <a href="profile.php" class="btn-edit">Check Edited Profile</a>
</div>

<?php include "includes/footer.php"; ?>

</body>
</html>