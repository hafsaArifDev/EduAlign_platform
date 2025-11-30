<?php
session_start();
require "../backend/db.php";

$success = "";
$error = "";

// فارم سبمٹ ہونے پر
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = trim($_POST['name']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];

    // پاسورڈ میچ نہ ہو
    if ($password !== $confirm) {
        $error = "Passwords do not match!";
    } else {

        // چیک کریں username پہلے سے موجود نہ ہو
        $check = $conn->prepare("SELECT id FROM admins WHERE username = ?");
        $check->execute([$username]);

        if ($check->fetch()) {
            $error = "This username already exists!";
        } else {
            // نیا admin create کریں
            $hashed = password_hash($password, PASSWORD_DEFAULT);

            $insert = $conn->prepare("INSERT INTO admins (name, username, password) VALUES (?,?,?)");
            $insert->execute([$name, $username, $hashed]);

            $success = "Admin registered successfully!";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Registration</title>
    <style>
        body {
            font-family: Arial;
            background: #f3f6f8;
        }
        .box {
            width: 380px;
            margin: 80px auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 6px;
            border: 1px solid #ccc;
        }
        button {
            width: 100%;
            padding: 12px;
            background: #3498db;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
        }
        .success {
            background: #2ecc71;
            padding: 10px;
            color: white;
            border-radius: 6px;
        }
        .error {
            background: #e74c3c;
            padding: 10px;
            color: white;
            border-radius: 6px;
        }
        a { text-decoration: none; color: #3498db; }
    </style>
</head>
<body>

<div class="box">
    <h2 style="text-align:center;">Admin Registration</h2>

    <?php if ($success): ?>
        <div class="success"><?= $success ?></div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="name" placeholder="Full Name" required>

        <input type="text" name="username" placeholder="Username" required>

        <input type="password" name="password" placeholder="Password" required>

        <input type="password" name="confirm" placeholder="Confirm Password" required>

        <button type="submit">Register Admin</button>
    </form>

    <p style="text-align:center;margin-top:10px;">
        Already have an account? <a href="login.php">Login</a>
    </p>
</div>

</body>
</html>
