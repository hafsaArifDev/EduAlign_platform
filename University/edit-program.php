<?php
require "../backend/db.php";
require "includes/university-auth.php";

$id = $_GET['id'];

// Fetch old data
$stmt = $conn->prepare("SELECT * FROM programs WHERE id = ?");
$stmt->execute([$id]);
$program = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$program) die("Invalid Program ID");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = $_POST['title'];
    $duration = $_POST['duration'];
    $fee = $_POST['fee'];
    $criteria = $_POST['criteria'];
    $description = $_POST['description'];

    $update = $conn->prepare("
        UPDATE programs 
        SET title=?, duration=?, fee=?, criteria=?, description=? 
        WHERE id=?
    ");

    $update->execute([$title, $duration, $fee, $criteria, $description, $id]);

    header("Location: manage-programs.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Program</title>
</head>

<body>

<?php include "includes/header.php"; ?>

<div class="container">

<h2>Edit Program</h2>

<form method="POST">
    <input type="text" name="title" value="<?= $program['title']; ?>" required>
    <input type="text" name="duration" value="<?= $program['duration']; ?>" required>
    <input type="text" name="fee" value="<?= $program['fee']; ?>" required>
    <textarea name="criteria"><?= $program['criteria']; ?></textarea>
    <textarea name="description"><?= $program['description']; ?></textarea>

    <button type="submit">Update Program</button>
</form>

</div>

</body>
</html>
