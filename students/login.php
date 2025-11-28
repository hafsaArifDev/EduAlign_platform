<?php
session_start();
require "../backend/db.php";

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = $conn->prepare("SELECT * FROM students WHERE email = ?");
    $query->execute([$email]);

    if ($query->rowCount() > 0) {
        $user = $query->fetch(PDO::FETCH_ASSOC);

        if (password_verify($password, $user['password'])) {
            $_SESSION['student_id'] = $user['id'];
            header("Location: index.php");
            exit;
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "No account found with this email.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Login</title>

    <!-- MERGED CSS -->
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
            color: #3498db;
            font-weight: 600;
            text-decoration: none;
        }

        .form-container p a:hover {
            text-decoration: underline;
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
    <h2>Student Login</h2>

    <?php if ($error): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="email" name="email" required placeholder="Enter Email">
        <input type="password" name="password" required placeholder="Enter Password">
        <button type="submit">Login</button>
    </form>

    <p>Don’t have an account? <a href="register.php">Register</a></p>
</div>

</body>
</html>