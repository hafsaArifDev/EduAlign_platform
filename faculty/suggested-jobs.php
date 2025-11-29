<?php
session_start();
require "../backend/db.php";

// اگر faculty logged in نہ ہو
if (!isset($_SESSION['faculty_id'])) {
    header("Location: login.php");
    exit;
}

$faculty_id = $_SESSION['faculty_id'];

// Fetch faculty profile info (subjects, skills, interest, departments)
$stmt = $conn->prepare("
    SELECT primary_teaching_subjects, skills, research_interest, preferred_departments 
    FROM faculty_profile WHERE faculty_id = ?
");
$stmt->execute([$faculty_id]);
$faculty = $stmt->fetch(PDO::FETCH_ASSOC);

// اگر پروفائل ابھی نہ بنی ہو
if (!$faculty) {
    $match_keywords = "";
} else {
    $match_keywords =
        ($faculty['primary_teaching_subjects'] ?? '') . " " .
        ($faculty['skills'] ?? '') . " " .
        ($faculty['research_interest'] ?? '') . " " .
        ($faculty['preferred_departments'] ?? '');
}

// Suggested Jobs Query
$query = $conn->prepare("
    SELECT * FROM jobs 
    WHERE job_title LIKE ? 
       OR required_subject LIKE ?
       OR skills_required LIKE ?
       OR department LIKE ?
");
$search = "%" . $match_keywords . "%";
$query->execute([$search, $search, $search, $search]);

$jobs = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Suggested Jobs</title>
    <link rel="stylesheet" href="css/faculty.css">
</head>
<body>

<?php include "includes/header.php"; ?>

<div class="container">

<h2>Suggested Jobs</h2>
<p>AI-matched job opportunities based on your teaching subjects, skills & research interests.</p>

<?php if (count($jobs) === 0): ?>
    <p>No jobs found matching your profile.</p>
<?php endif; ?>

<?php foreach ($jobs as $j): ?>
<div class="program-box">
    
    <h3><?= $j['job_title'] ?> (<?= $j['department'] ?>)</h3>

    <p><strong>Institute:</strong> <?= $j['institute'] ?></p>
    <p><strong>City:</strong> <?= $j['city'] ?></p>
    <p><strong>Salary:</strong> <?= $j['salary'] ?></p>
    <p><strong>Deadline:</strong> <?= $j['deadline'] ?></p>

    <p><?= $j['description'] ?></p>

    <a class="btn" href="apply-job.php?jid=<?= $j['id'] ?>">Apply Now</a>

</div>
<?php endforeach; ?>

</div>

<?php include "includes/footer.php"; ?>

</body>
</html>