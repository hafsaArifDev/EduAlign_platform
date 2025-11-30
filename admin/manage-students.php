<?php
require "includes/admin-auth.php";
require "../backend/db.php";

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $conn->prepare("DELETE FROM students_profiles WHERE student_id = ?")->execute([$id]);
    header("Location: manage-students.php");
    exit;
}

$students = $conn->query("SELECT * FROM students_profiles ORDER BY student_id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
<title>Manage Students</title>

<style>
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 40px;
    }
    th, td {
        border: 1px solid #ccc;
        padding: 8px;
        font-size: 14px;
        text-align: left;
        vertical-align: top;
    }
    th {
        background: #f5f5f5;
        font-weight: bold;
    }
    .scroll-box {
        overflow-x: auto;
        white-space: nowrap;
    }
</style>

</head>
<body>

<?php include "includes/header.php"; ?>

<div class="container">
    <h2>All Students</h2>

    <div class="scroll-box">
    <table>
        <tr>
            <th>ID</th>
            <th>Academic History</th>
            <th>Personal Info</th>
            <th>Preferences</th>
            <th>Future Goals</th>
            <th>Date of Birth</th>
            <th>Phone</th>
            <th>CNIC</th>
            <th>Gender</th>
            <th>Education Level</th>
            <th>Subjects</th>
            <th>Grades</th>
            <th>Desired Field</th>
            <th>Programs Interest</th>
            <th>Preferred City</th>
            <th>Action</th>
        </tr>

        <?php foreach($students as $s): ?>
        <tr>
            <td><?= $s['student_id'] ?></td>
            <td><?= nl2br(htmlspecialchars($s['academic_history'])) ?></td>
            <td><?= nl2br(htmlspecialchars($s['personal_info'])) ?></td>
            <td><?= nl2br(htmlspecialchars($s['preferences'])) ?></td>
            <td><?= nl2br(htmlspecialchars($s['future_goals'])) ?></td>
            <td><?= $s['date_of_birth'] ?></td>
            <td><?= htmlspecialchars($s['phone']) ?></td>
            <td><?= htmlspecialchars($s['cnic']) ?></td>
            <td><?= htmlspecialchars($s['gender']) ?></td>
            <td><?= htmlspecialchars($s['education_level']) ?></td>
            <td><?= nl2br(htmlspecialchars($s['subjects'])) ?></td>
            <td><?= htmlspecialchars($s['grades']) ?></td>
            <td><?= htmlspecialchars($s['desired_field']) ?></td>
            <td><?= nl2br(htmlspecialchars($s['programs_interest'])) ?></td>
            <td><?= htmlspecialchars($s['preferred_city']) ?></td>

            <td>
                <a href="?delete=<?= $s['student_id'] ?>" 
                   onclick="return confirm('Delete this student?')"
                   style="color:red;">
                   Delete
                </a>
            </td>
        </tr>
        <?php endforeach; ?>

    </table>
    </div>

</div>

<?php include "includes/footer.php"; ?>

</body>
</html>
