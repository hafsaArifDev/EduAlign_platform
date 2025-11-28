<?php
require "../backend/db.php";
require "includes/student-auth.php";

// Logged-in student ID
$student_id = $_SESSION['student_id'];

// پہلے سے موجود profile fetch کریں
$stmt = $conn->prepare("SELECT * FROM students_profiles WHERE student_id = ?");
$stmt->execute([$student_id]);
$profile = $stmt->fetch(PDO::FETCH_ASSOC);

// فارم submit ہونے پر data update کریں
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $academic_history = $_POST['academic_history'];
    $personal_info    = $_POST['personal_info'];
    $preferences      = $_POST['preferences'];
    $future_goals     = $_POST['future_goals'];

    if ($profile) {
        // اگر profile پہلے سے موجود ہے تو update کریں
        $stmt = $conn->prepare("UPDATE students_profiles SET academic_history = ?, personal_info = ?, preferences = ?, future_goals = ? WHERE student_id = ?");
        $stmt->execute([$academic_history, $personal_info, $preferences, $future_goals, $student_id]);
    } else {
        // اگر profile موجود نہیں تو insert کریں
        $stmt = $conn->prepare("INSERT INTO students_profiles (student_id, academic_history, personal_info, preferences, future_goals) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$student_id, $academic_history, $personal_info, $preferences, $future_goals]);
    }

    $success = "Profile updated successfully!";
    // دوبارہ profile fetch کریں تاکہ updated values دکھائی دیں
    $stmt = $conn->prepare("SELECT * FROM students_profiles WHERE student_id = ?");
    $stmt->execute([$student_id]);
    $profile = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<?php include "includes/header.php"; ?>
<link rel="stylesheet" href="css/student.css">

<div class="dashboard-container">
    <h2 class="welcome">Edit Profile ✏️</h2>

    <?php if(isset($success)) { ?>
        <p class="success-msg"><?= htmlspecialchars($success); ?></p>
    <?php } ?>

    <form action="" method="POST" class="profile-form">
        <label for="academic_history">Academic History:</label>
        <textarea name="academic_history" id="academic_history" rows="4"><?= htmlspecialchars($profile['academic_history'] ?? ''); ?></textarea>

        <label for="personal_info">Personal Info:</label>
        <textarea name="personal_info" id="personal_info" rows="4"><?= htmlspecialchars($profile['personal_info'] ?? ''); ?></textarea>

        <label for="preferences">Preferences:</label>
        <textarea name="preferences" id="preferences" rows="4"><?= htmlspecialchars($profile['preferences'] ?? ''); ?></textarea>

        <label for="future_goals">Future Goals:</label>
        <textarea name="future_goals" id="future_goals" rows="4"><?= htmlspecialchars($profile['future_goals'] ?? ''); ?></textarea>

        <button type="submit" class="btn-edit">Update Profile</button>
    </form>
     <a href="profile.php" class="btn-edit">✏️Check Edited Profile</a>
</div>

<?php include "includes/footer.php"; ?>
