<?php
require "../backend/db.php";
require "includes/university-auth.php";

$university_id = $_SESSION['university_id'];
$success = "";
$type = $_GET['type'] ?? "";

/* =========================
   FACULTY JOB APPLICANTS
   ========================= */
$facultyList = [];
if ($type === "faculty") {
    $stmt = $conn->prepare("
        SELECT 
            f.id AS fid,
            f.fullname,
            f.email,
            j.job_title
        FROM job_applications ja
        INNER JOIN jobs j ON ja.job_id = j.id
        INNER JOIN faculty f ON ja.faculty_id = f.id
        WHERE j.university_id = ?
    ");
    $stmt->execute([$university_id]);
    $facultyList = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/* =========================
   STUDENT PROGRAM APPLICANTS
   ========================= */
$studentList = [];
if ($type === "student") {
    $stmt = $conn->prepare("
        SELECT 
            s.id AS sid,
            s.fullname,
            s.email,
            p.program_name
        FROM program_applications pa
        INNER JOIN programs p ON pa.program_id = p.id
        INNER JOIN students s ON pa.student_id = s.id
        WHERE p.university_id = ?
    ");
    $stmt->execute([$university_id]);
    $studentList = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/* =========================
   SEND NOTIFICATIONS
   ========================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $message = trim($_POST['message']);
    $recipients = $_POST['recipients'] ?? [];

    foreach ($recipients as $r) {

        list($userType, $id) = explode("_", $r);

        if ($userType === "faculty") {

            $email = $conn->prepare("SELECT email FROM faculty WHERE id=?");
            $email->execute([$id]);
            $email = $email->fetchColumn();

            $finalMessage = "Applicant Email: $email\n\n$message";

            $conn->prepare("
                INSERT INTO faculty_notifications (faculty_id, message)
                VALUES (?, ?)
            ")->execute([$id, $finalMessage]);

        }

        if ($userType === "student") {

            $email = $conn->prepare("SELECT email FROM students WHERE id=?");
            $email->execute([$id]);
            $email = $email->fetchColumn();

            $finalMessage = "Applicant Email: $email\n\n$message";

            $conn->prepare("
                INSERT INTO student_notifications (student_id, message)
                VALUES (?, ?)
            ")->execute([$id, $finalMessage]);
        }
    }

    $success = "Notification sent to selected applicants.";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Send Notifications</title>

<style>
body{margin:0;font-family:Arial;background:#f0f6f9}
.container{width:90%;max-width:1000px;margin:40px auto}
.box{background:#fff;padding:30px;border-radius:14px;box-shadow:0 10px 30px rgba(0,0,0,0.08)}
h2{margin-top:0;background:linear-gradient(135deg,#1abc9c,#3498db);-webkit-background-clip:text;-webkit-text-fill-color:transparent}
select,textarea{width:100%;padding:12px;margin:12px 0;border-radius:8px;border:1px solid #ccc}
table{width:100%;border-collapse:collapse;margin:20px 0}
th,td{padding:12px;border-bottom:1px solid #e5e7eb;text-align:left}
th{background:#f9fafb}
button{padding:12px 20px;background:linear-gradient(135deg,#1abc9c,#3498db);color:#fff;border:none;border-radius:8px;font-weight:600;cursor:pointer}
.success{color:#1abc9c;font-weight:600}
</style>
</head>

<body>

<?php include "includes/header.php"; ?>

<div class="container">
<div class="box">

<h2>Send Notifications</h2>

<?php if ($success): ?>
<p class="success"><?= $success ?></p>
<?php endif; ?>

<form method="GET">
<label><strong>Select Applicant Type:</strong></label>
<select name="type" onchange="this.form.submit()">
    <option value="">-- Select --</option>
    <option value="faculty" <?= $type=="faculty"?"selected":"" ?>>Faculty Job Applicants</option>
    <option value="student" <?= $type=="student"?"selected":"" ?>>Student Program Applicants</option>
</select>
</form>

<?php if ($type): ?>
<form method="POST">

<table>
<tr>
<th>Select</th>
<th>Name</th>
<th>Email</th>
<th>Applied For</th>
</tr>

<?php foreach ($facultyList as $f): ?>
<tr>
<td><input type="checkbox" name="recipients[]" value="faculty_<?= $f['fid'] ?>"></td>
<td><?= $f['fullname'] ?></td>
<td><?= $f['email'] ?></td>
<td><?= $f['job_title'] ?></td>
</tr>
<?php endforeach; ?>

<?php foreach ($studentList as $s): ?>
<tr>
<td><input type="checkbox" name="recipients[]" value="student_<?= $s['sid'] ?>"></td>
<td><?= $s['fullname'] ?></td>
<td><?= $s['email'] ?></td>
<td><?= $s['program_name'] ?></td>
</tr>
<?php endforeach; ?>

</table>

<label><strong>Message:</strong></label>
<textarea name="message" rows="4" required placeholder="Write notification message..."></textarea>

<button type="submit">Send Notification</button>

</form>
<?php endif; ?>

</div>
</div>

</body>
</html>
