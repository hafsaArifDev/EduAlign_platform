<?php
session_start();
require "../backend/db.php";

// اگر student login نہ ہو
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit;
}

$student_id = $_SESSION['student_id'];

// Student Profile لانا
$profile = $conn->prepare("SELECT preferences FROM students_profiles WHERE student_id = ?");
$profile->execute([$student_id]);
$student_pref = $profile->fetch(PDO::FETCH_ASSOC);

// اگر profile نہ بنی ہوئی ہو
if (!$student_pref) {
    $preferences = "";
} else {
    $preferences = $student_pref['preferences'];
}

// Suggested Programs Query
$query = $conn->prepare("
    SELECT * FROM programs 
    WHERE program_name LIKE ? 
       OR degree_level LIKE ?
       OR city LIKE ?
");
$search = "%" . $preferences . "%";
$query->execute([$search, $search, $search]);

$programs = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Suggested Programs</title>
    <link rel="stylesheet" href="css/student.css">
</head>
<body>

<?php include "includes/header.php"; ?>

<div class="container">

<h2>Suggested Programs</h2>
<p>AI-matched degree programs based on your preferences.</p>

<?php if (count($programs) === 0): ?>
    <p>No programs found matching your preferences.</p>
<?php endif; ?>

<?php foreach ($programs as $p): ?>
<div class="program-box">
    <h3><?= $p['program_name'] ?> (<?= $p['degree_level'] ?>)</h3>
    <p><strong>University:</strong> <?= $p['university_name'] ?></p>
    <p><strong>City:</strong> <?= $p['city'] ?></p>
    <p><strong>Fee:</strong> <?= $p['fee'] ?></p>
    <p><strong>Deadline:</strong> <?= $p['deadline'] ?></p>
    <p><?= $p['description'] ?></p>

    <a class="btn" href="apply-program.php?pid=<?= $p['id'] ?>">Apply Now</a>
</div>
<?php endforeach; ?>

</div>

<?php include "includes/footer.php"; ?>

</body>
</html>
