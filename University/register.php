<?php
require "../backend/db.php";

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Email duplication check
    $check = $conn->prepare("SELECT * FROM universities WHERE email = ?");
    $check->execute([$email]);

    if ($check->rowCount() > 0) {
        $error = "Email already registered!";
    } else {

        // INSERT INTO UNIVERSITIES (NOT faculty)
        $query = $conn->prepare("
            INSERT INTO universities (uni_name, email, password) 
            VALUES (?, ?, ?)
        ");

        if ($query->execute([$fullname, $email, $password])) {
            $success = "University account created successfully! Please login.";
        } else {
            $error = "Something went wrong. Try again.";
        }
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Register Faculty</title>

    <!-- SAME MERGED CSS YOU PROVIDED -->
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #1abc9c, #3498db);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .form-container {
            width: 420px;
            background: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.18);
            text-align: center;
        }

        .form-container h2 {
            margin-bottom: 25px;
            font-size: 26px;
            font-weight: 700;
            color: #333;
        }

        .form-container input {
            width: 100%;
            padding: 14px;
            margin: 12px 0;
            border-radius: 6px;
            border: 1px solid #ddd;
            background: #f7f7f7;
            font-size: 15px;
            transition: 0.3s ease;
        }

        .form-container input:focus {
            border-color: #3498db;
            background: #fff;
            outline: none;
            box-shadow: 0 0 5px rgba(52,152,219,0.3);
        }

        .form-container button {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #1abc9c, #27ae60);
            color: #fff;
            font-size: 17px;
            font-weight: 600;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.3s ease;
        }

        .form-container button:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        .form-container p a {
            color: #2ecc71;
            font-weight: 600;
            text-decoration: none;
        }

        .form-container p a:hover {
            text-decoration: underline;
        }

        .success {
            padding: 10px;
            background: #2ecc71;
            color: white;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .error {
            padding: 10px;
            background: #e74c3c;
            color: white;
            border-radius: 5px;
            margin-bottom: 15px;
        }
    </style>

</head>
<body>

<div class="form-container">
    <h2>Register as University</h2>

    <?php if ($success): ?>
        <p class="success"><?= $success ?></p>
    <?php endif; ?>

    <?php if ($error): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="fullname" required placeholder="Full Name">
        <input type="email" name="email" required placeholder="Email Address">
        <input type="password" name="password" required placeholder="Password">

        <button type="submit">Register</button>
    </form>

    <p>Already have an account? <a href="login.php">Login</a></p>
</div>

</body>
</html>
