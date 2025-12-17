<?php
require "../backend/db.php";
require "includes/university-auth.php";

$university_id = $_SESSION['university_id'];

// Fetch job applications belonging ONLY to this university
$stmt = $conn->prepare("
    SELECT ja.*, j.title AS job_title
    FROM job_applications ja
    INNER JOIN jobs j ON ja.job_id = j.id
    WHERE j.university_id = ?
    ORDER BY ja.applied_at DESC
");
$stmt->execute([$university_id]);
$applications = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Job Applications</title>

    <style>
        body { font-family: Arial; background: #f0f6f9; }
        .container { width: 90%; max-width: 1000px; margin: 40px auto; }

        table {
            width: 100%;
            background: white;
            border-radius: 10px;
            border-collapse: collapse;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
        }
        th, td {
            padding: 14px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        th {
            background: linear-gradient(135deg, #1abc9c, #3498db);
            color: white;
        }

        a.view-btn {
            background: #3498db;
            padding: 8px 14px;
            color: white;
            border-radius: 6px;
            text-decoration:none;
            font-weight:bold;
        }
    </style>
</head>

<body>

<?php include "includes/header.php"; ?>

<div class="container">

    <h2>Job Applications</h2>

    <table>
        <tr>
            <th>Job Title</th>
            <th>Applicant Type</th>
            <th>Applied On</th>
            <th>Action</th>
        </tr>

        <?php foreach ($applications as $row): ?>
        <tr>
            <td><?= htmlspecialchars($row['job_title']); ?></td>

            <td>
                <?php
                if ($row['student_id']) echo "Student";
                else if ($row['faculty_id']) echo "Faculty";
                ?>
            </td>

            <td><?= $row['applied_at']; ?></td>

            <td>
                <a href="view-job-application.php?id=<?= $row['id']; ?>" class="view-btn">View</a>
            </td>
        </tr>
        <?php endforeach; ?>

        <?php if (empty($applications)): ?>
        <tr>
            <td colspan="4" style="text-align:center; color:#777;">No applications yet.</td>
        </tr>
        <?php endif; ?>

    </table>

</div>

</body>
</html>
