<?php
session_start();
require "../backend/db.php";

// اگر faculty login نہ ہو
if (!isset($_SESSION['faculty_id'])) {
    header("Location: login.php");
    exit;
}

$faculty_id = $_SESSION['faculty_id'];

// Job ID from URL
if (!isset($_GET['jid'])) {
    die("Invalid Job Request!");
}

$job_id = $_GET['jid'];

// 1) Fetch Job Details
$stmt = $conn->prepare("SELECT * FROM jobs WHERE id = ?");
$stmt->execute([$job_id]);
$job = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$job) {
    die("Job not found!");
}

// 2) Check if Already Applied
$check = $conn->prepare("SELECT id FROM job_applications WHERE faculty_id = ? AND job_id = ?");
$check->execute([$faculty_id, $job_id]);

$already_applied = $check->fetch(PDO::FETCH_ASSOC);

// 3) Apply Logic
$success = "";
$error = "";

if (isset($_POST['apply'])) {

    if ($already_applied) {
        $error = "You have already applied for this job.";
    } else {
        $apply = $conn->prepare("INSERT INTO job_applications (faculty_id, job_id) VALUES (?, ?)");
        $apply->execute([$faculty_id, $job_id]);
        $success = "Your application has been submitted successfully!";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Apply Job</title>
    <link rel="stylesheet" href="css/faculty.css">

    <style>
        .job-box {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 12px rgba(0,0,0,0.15);
            margin-top: 30px;
        }
        .btn {
            display: inline-block;
            padding: 12px 18px;
            background: linear-gradient(135deg, #1abc9c, #3498db);
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin-top: 10px;
        }
        .btn:hover {
            opacity: 0.9;
        }
        .success {
            background: #2ecc71;
            padding: 12px;
            color: white;
            border-radius: 6px;
            margin-bottom: 20px;
        }
        .error {
            background: #e74c3c;
            padding: 12px;
            color: white;
            border-radius: 6px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

<?php include "includes/header.php"; ?>

<div class="container">

    <h2>Apply for Job</h2>
    <p>Review the job details and submit your application.</p>

    <div class="job-box">

        <?php if ($success): ?>
            <div class="success"><?= $success ?></div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>

        <h3><?= $job['job_title'] ?> (<?= $job['department'] ?>)</h3>

        <p><strong>Institute:</strong> <?= $job['institute'] ?></p>
        <p><strong>City:</strong> <?= $job['city'] ?></p>
        <p><strong>Salary:</strong> <?= $job['salary'] ?></p>
        <p><strong>Deadline:</strong> <?= $job['deadline'] ?></p>

        <p><?= $job['description'] ?></p>

        <?php if (!$already_applied && !$success): ?>
            <form method="POST">
                <button class="btn" type="submit" name="apply">Apply Now</button>
            </form>
        <?php else: ?>
            <p><strong>Status:</strong> Already Applied</p>
        <?php endif; ?>

        <br>
        <a href="suggested-jobs.php" class="btn">Back to Jobs</a>

    </div>

</div>

<?php include "includes/footer.php"; ?>

</body>
</html>