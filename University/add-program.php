<?php
require "../backend/db.php";
require "includes/university-auth.php";

$university_id = $_SESSION['university_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = $_POST['title'];
    $duration = $_POST['duration'];
    $fee = $_POST['fee'];
    $criteria = $_POST['criteria'];
    $description = $_POST['description'];

    $stmt = $conn->prepare("
        INSERT INTO programs (university_id, title, duration, fee, criteria, description)
        VALUES (?, ?, ?, ?, ?, ?)
    ");

    if ($stmt->execute([$university_id, $title, $duration, $fee, $criteria, $description])) {
        header("Location: manage-programs.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Program</title>

    <style>
        body { font-family: Arial; background: #f0f6f9; }
        .container { width: 90%; max-width: 700px; margin: 40px auto; }
        form { background:white; padding:25px; border-radius:10px; box-shadow:0 8px 25px rgba(0,0,0,0.08); }
        input, textarea { width:100%; padding:12px; margin:10px 0; border-radius:6px; border:1px solid #ccc; }
        button {
            padding:12px 16px; background:#1abc9c; color:white;
            border:none; border-radius:6px; cursor:pointer; font-size:16px;
        }
    </style>
</head>

<body>

<?php include "includes/header.php"; ?>

<div class="container">

<h2>Add New Academic Program</h2>

<form method="POST">
    <input type="text" name="title" required placeholder="Program Title">
    <input type="text" name="duration" required placeholder="Duration (e.g., 4 Years)">
    <input type="text" name="fee" required placeholder="Fee Structure">
    <textarea name="criteria" required placeholder="Eligibility Criteria"></textarea>
    <textarea name="description" placeholder="Additional Description"></textarea>

    <button type="submit">Add Program</button>
</form>

</div>

</body>
</html>
