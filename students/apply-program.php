<?php
session_start();
require "../backend/db.php";

if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit;
}

$student_id = $_SESSION['student_id'];
$program_id = $_GET['pid'] ?? 0;

// Check valid program
$program = $conn->prepare("SELECT * FROM programs WHERE id = ?");
$program->execute([$program_id]);

if ($program->rowCount() === 0) {
    die("Invalid program selected.");
}

// Check if already applied
$check = $conn->prepare("SELECT * FROM program_applications WHERE student_id = ? AND program_id = ?");
$check->execute([$student_id, $program_id]);

if ($check->rowCount() > 0) {
    die("You already applied for this program.");
}

// Insert application
$apply = $conn->prepare("INSERT INTO program_applications (student_id, program_id) VALUES (?, ?)");
$apply->execute([$student_id, $program_id]);

// Add notification
$note = $conn->prepare("
    INSERT INTO student_notifications (student_id, message) 
    VALUES (?, 'Your application has been submitted successfully.')
");
$note->execute([$student_id]);

header("Location: notifications.php?success=1");
exit;
?>
