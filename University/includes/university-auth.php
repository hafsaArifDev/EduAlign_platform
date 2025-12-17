<?php
session_start();

if (!isset($_SESSION['university_id'])) {
    header("Location: login.php");
    exit;
}
?>
