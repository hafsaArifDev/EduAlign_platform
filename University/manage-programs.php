<?php
require "../backend/db.php";
require "includes/university-auth.php";

$university_id = $_SESSION['university_id'];

// Fetch all programs for this university
$stmt = $conn->prepare("SELECT * FROM programs WHERE university_id = ? ORDER BY created_at DESC");
$stmt->execute([$university_id]);
$programs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Programs</title>

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

    <h2>Manage Academic Programs</h2>

    <a href="add-program.php" class="btn add-btn">+ Add New Program</a>
    <br><br>

    <table>
        <tr>
            <th>Program Title</th>
            <th>Duration</th>
            <th>Fee</th>
            <th>Actions</th>
        </tr>

        <?php foreach ($programs as $p): ?>
        <tr>
            <td><?= htmlspecialchars($p['title']); ?></td>
            <td><?= $p['duration']; ?></td>
            <td><?= $p['fee']; ?></td>

            <td>
                <a href="edit-program.php?id=<?= $p['id']; ?>" class="btn edit-btn">Edit</a>
                <a href="delete-program.php?id=<?= $p['id']; ?>" class="btn del-btn"
                    onclick="return confirm('Are you sure you want to delete this program?');">
                    Delete
                </a>
            </td>
        </tr>
        <?php endforeach; ?>

        <?php if (empty($programs)): ?>
        <tr>
            <td colspan="4" style="text-align:center; color:#777;">No programs added yet.</td>
        </tr>
        <?php endif; ?>

    </table>

</div>

</body>
</html>
