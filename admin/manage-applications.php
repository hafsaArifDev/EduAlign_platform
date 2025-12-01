<?php
require "includes/admin-auth.php";
require "../backend/db.php";

$job_apps = $conn->query("
    SELECT ja.*, j.job_title, fullname 
    FROM job_applications ja 
    JOIN jobs j ON ja.job_id = j.id 
    JOIN faculty_profile f ON ja.faculty_id = f.faculty_id 
    ORDER BY ja.applied_at DESC
")->fetchAll(PDO::FETCH_ASSOC);

$prog_apps = $conn->query("
    SELECT pa.*, p.program_name, s.student_id 
    FROM program_applications pa 
    JOIN programs p ON pa.program_id = p.id 
    JOIN students_profiles s ON pa.student_id = s.student_id 
    ORDER BY pa.applied_at DESC
")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
<title>Applications</title>

<style>

/* PAGE CONTAINER */
.container {
    width: 90%;
    max-width: 1400px;
    margin: 40px auto;
    background: #ffffff;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.08);
}

/* HEADINGS */
.container h2 {
    font-size: 28px;
    font-weight: 700;
    margin-top: 20px;
    margin-bottom: 15px;
    background: linear-gradient(135deg, #1abc9c, #3498db);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

/* TABLE STYLING */
table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 35px;
    font-size: 15px;
}

th {
    background: linear-gradient(135deg, #1abc9c, #3498db);
    color: white;
    padding: 10px;
    font-weight: 700;
    text-align: left;
}

td {
    padding: 10px;
    border-bottom: 1px solid #ececec;
}

tr:nth-child(even) {
    background: #f7fcff;
}

tr:hover {
    background: #e7f6ff;
    transition: 0.2s;
}

/* STATUS COLORING */
td.status {
    font-weight: bold;
}

.status.pending {
    color: #f39c12;
}

.status.approved {
    color: #27ae60;
}

.status.rejected {
    color: #e74c3c;
}

</style>

</head>
<body>

<?php include "includes/header.php"; ?>

<div class="container">

    <!-- JOB APPLICATIONS -->
    <h2>Job Applications</h2>
    <table>
        <tr>
            <th>#</th>
            <th>Job</th>
            <th>Faculty</th>
            <th>Date</th>
            <th>Status</th>
        </tr>

        <?php foreach($job_apps as $a): ?>
        <tr>
            <td><?= $a['id'] ?></td>
            <td><?= htmlspecialchars($a['job_title']) ?></td>
            <td><?= htmlspecialchars($a['fullname']) ?></td>
            <td><?= $a['applied_at'] ?></td>
            <td class="status <?= strtolower($a['status']) ?>">
                <?= htmlspecialchars($a['status']) ?>
            </td>
        </tr>
        <?php endforeach; ?>

    </table>

    <!-- PROGRAM APPLICATIONS -->
    <h2>Program Applications</h2>
    <table>
        <tr>
            <th>#</th>
            <th>Program</th>
            <th>Student</th>
            <th>Date</th>
            <th>Status</th>
        </tr>

        <?php foreach($prog_apps as $a): ?>
        <tr>
            <td><?= $a['id'] ?></td>
            <td><?= htmlspecialchars($a['program_name']) ?></td>
            <td><?= htmlspecialchars($a['student_id']) ?></td>
            <td><?= $a['applied_at'] ?></td>
            <td class="status <?= strtolower($a['status']) ?>">
                <?= htmlspecialchars($a['status']) ?>
            </td>
        </tr>
        <?php endforeach; ?>

    </table>

</div>

<?php include "includes/footer.php"; ?>

</body>
</html>
