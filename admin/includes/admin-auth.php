<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: /eduAlign-platform/admin/login.php");
    exit;
}
