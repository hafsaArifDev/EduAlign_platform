<?php
require "../backend/db.php";
require "includes/university-auth.php";

$university_id = $_SESSION['university_id'];
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = $_POST['title'];
    $description = $_POST['description'];
    $requirements = $_POST['requirements'];
    $salary = $_POST['salary'];
    $deadline = $_POST['deadline'];

    $stmt = $conn->prepare("
        INSERT INTO jobs (university_id, title, description, requirements, salary, deadline)
        VALUES (?, ?, ?, ?, ?, ?)
    ");

    if ($stmt->execute([$university_id, $title, $description, $requirements, $salary, $deadline])) {
        header("Location: manage-jobs.php");
        exit;
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Job</title>

    <style>
        body { font-family: Arial; background: #f0f6f9; }
        .container { width: 90%; max-width: 700px; margin: 40px auto; }
        form { background: white; padding: 25px; border-radius: 10px; box-shadow: 0 8px 25px rgba(0,0,0,0.08); }
        input, textarea {
            width: 100%; padding: 12px; margin: 10px 0; border-radius: 6px; border: 1px solid #ccc;
        }
        button {
            padding: 12px 16px; background: #1abc9c; color:white; border:none;
            border-radius:6px; cursor:pointer; font-size:16px;
        }
    </style>
</head>
<body>

<?php include "includes/header.php"; ?>

<div class="container">

<h2>Add New Job</h2>

<?php if ($success): ?>
    <p style="color:green;"><?= $success; ?></p>
<?php endif; ?>

<form method="POST">
    <input type="text" name="title" required placeholder="Job Title">
    <textarea name="description" required placeholder="Job Description"></textarea>
    <textarea name="requirements" placeholder="Requirements"></textarea>
    <input type="text" name="salary" placeholder="Salary Range">
    <input type="date" name="deadline" required>

    <button type="submit">Post Job</button>
</form>

</div>
</body>
</html>
