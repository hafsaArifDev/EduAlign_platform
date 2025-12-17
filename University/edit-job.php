<?php
require "../backend/db.php";
require "includes/university-auth.php";

$id = $_GET['id'];

// Get job data
$stmt = $conn->prepare("SELECT * FROM jobs WHERE id = ?");
$stmt->execute([$id]);
$job = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$job) {
    die("Invalid job ID");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = $_POST['title'];
    $description = $_POST['description'];
    $requirements = $_POST['requirements'];
    $salary = $_POST['salary'];
    $deadline = $_POST['deadline'];

    $update = $conn->prepare("
        UPDATE jobs SET title=?, description=?, requirements=?, salary=?, deadline=? WHERE id=?
    ");

    $update->execute([$title, $description, $requirements, $salary, $deadline, $id]);

    header("Location: manage-jobs.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head><title>Edit Job</title></head>

<body>

<?php include "includes/header.php"; ?>

<h2>Edit Job</h2>

<form method="POST">
    <input type="text" name="title" value="<?= $job['title']; ?>">
    <textarea name="description"><?= $job['description']; ?></textarea>
    <textarea name="requirements"><?= $job['requirements']; ?></textarea>
    <input type="text" name="salary" value="<?= $job['salary']; ?>">
    <input type="date" name="deadline" value="<?= $job['deadline']; ?>">

    <button type="submit">Update Job</button>
</form>

</body>
</html>
