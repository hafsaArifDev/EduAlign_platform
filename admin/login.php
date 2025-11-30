<?php
session_start();
require "../backend/db.php";

$error = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->execute([$username]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_name'] = $admin['name'] ?? $admin['username'];
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid credentials.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <style>
        body{font-family:Arial; background:#f3f6f8}
        .login-box{width:360px;margin:80px auto;padding:24px;background:#fff;border-radius:8px;box-shadow:0 8px 30px rgba(0,0,0,0.08)}
        input{width:100%;padding:12px;margin:8px 0;border:1px solid #ddd;border-radius:6px}
        button{width:100%;padding:12px;background:#3498db;color:#fff;border:0;border-radius:6px}
        .error{background:#e74c3c;color:#fff;padding:10px;border-radius:6px}
    </style>
</head>
<body>
<div class="login-box">
    <h2>Admin Login</h2>
    <?php if ($error) echo "<div class='error'>$error</div>"; ?>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
</div>
</body>
</html>
