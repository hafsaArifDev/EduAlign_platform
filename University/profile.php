<?php
require "../backend/db.php";
require "includes/university-auth.php";

$university_id = $_SESSION['university_id'];

// Fetch university data
$stmt = $conn->prepare("SELECT * FROM universities WHERE id = ?");
$stmt->execute([$university_id]);
$uni = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>University Profile</title>

    <style>
        body { font-family: Arial; background: #f0f6f9; margin:0; padding:0; }
        .container { width: 90%; max-width: 900px; margin: 40px auto; }
        .profile-box {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
        }
        .profile-box h2 {
            color: #333; font-size: 28px; margin-bottom: 20px;
        }
        .row { margin: 10px 0; }
        .label { font-weight:bold; color:#555; }
        .value { color:#333; }
        a.btn {
            padding: 12px 18px;
            background: #3498db;
            color:white; 
            border-radius: 6px;
            text-decoration:none;
            font-weight:bold;
            margin-top:20px;
            display:inline-block;
        }
        img.logo {
            width:120px;
            height:120px;
            object-fit:cover;
            border-radius:10px;
            margin-bottom:20px;
        }
    </style>
</head>

<body>
<?php include "includes/header.php"; ?>

<div class="container">

    <div class="profile-box">

        <h2>University Profile</h2>

        <?php if ($uni['logo']): ?>
            <img src="uploads/<?= $uni['logo']; ?>" class="logo">
        <?php endif; ?>

        <div class="row">
            <span class="label">University Name: </span>
            <span class="value"><?= htmlspecialchars($uni['uni_name']); ?></span>
        </div>

        <div class="row">
            <span class="label">Email: </span>
            <span class="value"><?= htmlspecialchars($uni['email']); ?></span>
        </div>

        <div class="row">
            <span class="label">Address: </span>
            <span class="value"><?= htmlspecialchars($uni['address']); ?></span>
        </div>

        <div class="row">
            <span class="label">Description: </span>
            <span class="value"><?= nl2br(htmlspecialchars($uni['description'])); ?></span>
        </div>

        <a href="update-profile.php" class="btn">Edit Profile</a>

    </div>

</div>

</body>
</html>
