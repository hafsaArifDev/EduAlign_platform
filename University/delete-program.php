<?php
require "../backend/db.php";
require "includes/university-auth.php";

$id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM programs WHERE id = ?");
$stmt->execute([$id]);

header("Location: manage-programs.php");
exit;
?>
