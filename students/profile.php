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

    // If profile exists → Update
    if ($profile) {
        $query = $conn->prepare("
            UPDATE students_profiles SET 
            date_of_birth=?, phone=?, cnic=?, gender=?,
            education_level=?, subjects=?, grades=?,
            desired_field=?, programs_interest=?, preferred_city=?
            WHERE student_id=?
        ");
    } 
    else { // Insert new
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

<?php include "includes/header.php"; ?>

<link rel="stylesheet" href="css/student.css">

<div class="form-container">

    <h2>Update Profile ✏️</h2>

    <?php if (!empty($success)) echo "<p class='success'>$success</p>"; ?>

    <form method="POST">

        <h3>Personal Information</h3>
        <input type="date" name="date_of_birth" value="<?= $profile['date_of_birth'] ?? '' ?>" required>
        <input type="text" name="phone" placeholder="Phone Number" value="<?= $profile['phone'] ?? '' ?>" required>
        <input type="text" name="cnic" placeholder="CNIC" value="<?= $profile['cnic'] ?? '' ?>" required>

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

        <input type="text" name="subjects" placeholder="Subjects Studied" value="<?= $profile['subjects'] ?? '' ?>">
        <input type="text" name="grades" placeholder="Grades / Marks" value="<?= $profile['grades'] ?? '' ?>">

        <h3>Preferences</h3>
        <input type="text" name="desired_field" placeholder="Desired Field of Study" value="<?= $profile['desired_field'] ?? '' ?>">
        <input type="text" name="programs_interest" placeholder="Programs of Interest" value="<?= $profile['programs_interest'] ?? '' ?>">
        <input type="text" name="preferred_city" placeholder="Preferred City / Location" value="<?= $profile['preferred_city'] ?? '' ?>">

        <button type="submit">Save Profile</button>
    </form>
</div>

<?php include "includes/footer.php"; ?>
