<?php
require "../backend/db.php";
require "includes/university-auth.php";

$id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM jobs WHERE id = ?");
$stmt->execute([$id]);

header("Location: manage-jobs.php");
exit;
?>
