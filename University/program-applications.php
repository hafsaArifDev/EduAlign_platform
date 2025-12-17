<?php
require "../backend/db.php";
require "includes/university-auth.php";

$university_id = $_SESSION['university_id'];

// Fetch ONLY student program applications for this university
$stmt = $conn->prepare("
    SELECT 
        pa.id,
        pa.applied_at,
        COALESCE(p.title, p.program_name) AS program_title,
        s.fullname AS student_name
    FROM program_applications pa
    INNER JOIN programs p ON pa.program_id = p.id
    INNER JOIN students s ON pa.student_id = s.id
    WHERE p.university_id = ?
    ORDER BY pa.applied_at DESC
");
$stmt->execute([$university_id]);
$applications = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Program Applications</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f0f6f9;
        }

        .container {
            width: 90%;
            max-width: 1000px;
            margin: 40px auto;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        table {
            width: 100%;
            background: #fff;
            border-radius: 12px;
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
            color: #fff;
        }

        .view-btn {
            padding: 8px 14px;
            background: #3498db;
            color: #fff;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
        }

        .empty {
            text-align: center;
            color: #777;
            padding: 20px;
        }
    </style>
</head>

<body>

<?php include "includes/header.php"; ?>

<div class="container">

    <h2>Program Applications</h2>

    <table>
        <tr>
            <th>Program Title</th>
            <th>Student Name</th>
            <th>Applied On</th>
            <th>Action</th>
        </tr>

        <?php if ($applications): foreach ($applications as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['program_title']); ?></td>
                <td><?= htmlspecialchars($row['student_name']); ?></td>
                <td><?= $row['applied_at']; ?></td>
                <td>
                    <a class="view-btn" href="view-program-application.php?id=<?= $row['id']; ?>">
                        View
                    </a>
                </td>
            </tr>
        <?php endforeach; else: ?>
            <tr>
                <td colspan="4" class="empty">
                    No program applications found.
                </td>
            </tr>
        <?php endif; ?>
    </table>

</div>

</body>
</html>
