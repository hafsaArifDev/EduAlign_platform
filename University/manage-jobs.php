<?php
require "../backend/db.php";
require "includes/university-auth.php";

$university_id = $_SESSION['university_id'];

// Fetch all jobs of this university
$stmt = $conn->prepare("SELECT * FROM jobs WHERE university_id = ? ORDER BY created_at DESC");
$stmt->execute([$university_id]);
$jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Jobs</title>

    <style>
        body { font-family: Arial, sans-serif; background: #f0f6f9; }
        .container { width: 90%; max-width: 1000px; margin: 40px auto; }
        h2 { margin-bottom: 20px; font-size: 28px; color: #333; }

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

        a.btn {
            padding: 10px 16px;
            border-radius: 6px;
            text-decoration: none;
            color: white;
            font-weight: bold;
        }

        .add-btn { background: #1abc9c; }
        .edit-btn { background: #3498db; }
        .del-btn { background: #e74c3c; }
    </style>
</head>

<body>

<?php include "includes/header.php"; ?>

<div class="container">

    <h2>Manage Jobs</h2>

    <a href="add-job.php" class="btn add-btn">+ Add New Job</a>
    <br><br>

    <table>
        <tr>
            <th>Job Title</th>
            <th>Deadline</th>
            <th>Posted On</th>
            <th>Actions</th>
        </tr>

        <?php foreach ($jobs as $job): ?>
        <tr>
            <td><?= htmlspecialchars($job['title']); ?></td>
            <td><?= $job['deadline']; ?></td>
            <td><?= $job['created_at']; ?></td>

            <td>
                <a href="edit-job.php?id=<?= $job['id']; ?>" class="btn edit-btn">Edit</a>
                <a href="delete-job.php?id=<?= $job['id']; ?>" class="btn del-btn" onclick="return confirm('Delete this job?');">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>

        <?php if (empty($jobs)): ?>
        <tr>
            <td colspan="4" style="text-align:center; color:#777;">No jobs posted yet.</td>
        </tr>
        <?php endif; ?>

    </table>

</div>

</body>
</html>
