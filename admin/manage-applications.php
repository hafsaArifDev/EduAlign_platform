<?php
require "includes/admin-auth.php";
require "../backend/db.php";

$job_apps = $conn->query("SELECT ja.*, j.job_title, fullname FROM job_applications ja JOIN jobs j ON ja.job_id=j.id JOIN faculty_profile f ON ja.faculty_id=f.faculty_id ORDER BY ja.applied_at DESC")->fetchAll(PDO::FETCH_ASSOC);
$prog_apps = $conn->query("SELECT pa.*, p.program_name, s.student_id FROM program_applications pa JOIN programs p ON pa.program_id=p.id JOIN students_profiles s ON pa.student_id=s.student_id ORDER BY pa.applied_at DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html><html><head><title>Applications</title></head><body>
<?php include "includes/header.php"; ?>
<div class="container">
    <h2>Job Applications</h2>
    <table border="1" width="100%">
        <tr><th>#</th><th>Job</th><th>Faculty</th><th>Date</th><th>Status</th></tr>
        <?php foreach($job_apps as $a): ?>
        <tr>
            <td><?= $a['id'] ?></td>
            <td><?= htmlspecialchars($a['job_title']) ?></td>
            <td><?= htmlspecialchars($a['fullname']) ?></td>
            <td><?= $a['applied_at'] ?></td>
            <td><?= htmlspecialchars($a['status']) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <h2>Program Applications</h2>
    <table border="1" width="100%">
        <tr><th>#</th><th>Program</th><th>Student ID</th><th>Date</th><th>Status</th></tr>
        <?php foreach($prog_apps as $a): ?>
        <tr>
            <td><?= $a['id'] ?></td>
            <td><?= htmlspecialchars($a['program_name']) ?></td>
            <td><?= htmlspecialchars($a['student_id']) ?></td>
            <td><?= $a['applied_at'] ?></td>
            <td><?= htmlspecialchars($a['status']) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
<?php include "includes/footer.php"; ?>
</body></html>
