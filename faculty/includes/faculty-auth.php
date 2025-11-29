<?php
session_start();

if (!isset($_SESSION['faculty_id'])) {
    header("Location: login.php");
    exit;
}
?>
