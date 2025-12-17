<?php
require "../backend/db.php";
require "includes/university-auth.php";

$university_id = $_SESSION['university_id'];

$success = "";
$error = "";

// Fetch current data
$stmt = $conn->prepare("SELECT * FROM universities WHERE id = ?");
$stmt->execute([$university_id]);
$uni = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = $_POST['uni_name'];
    $address = $_POST['address'];
    $description = $_POST['description'];

    $logo_name = $uni['logo']; // old logo by default

    // If new logo is uploaded
    if (!empty($_FILES['logo']['name'])) {
        $logo_name = time() . "_" . $_FILES['logo']['name'];
        move_uploaded_file($_FILES['logo']['tmp_name'], "uploads/" . $logo_name);
    }

    $update = $conn->prepare("
        UPDATE universities 
        SET uni_name = ?, address = ?, description = ?, logo = ? 
        WHERE id = ?
    ");

   if ($update->execute([$name, $address, $description, $logo_name, $university_id])) {

    // REDIRECT TO PROFILE PAGE
    header("Location: profile.php");
    exit;

} else {
    $error = "Something went wrong.";
}
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit University Profile</title>

    <style>
        body { font-family: Arial; background: #f0f6f9; }
        .container { width: 90%; max-width: 700px; margin: 40px auto; }
        form { background:white; padding:25px; border-radius:10px; box-shadow:0 8px 25px rgba(0,0,0,0.08); }
        input, textarea {
            width:100%; padding:12px; margin:10px 0;
            border-radius:6px; border:1px solid #ccc;
        }
        button {
            padding:12px 16px;
            background:#1abc9c; color:white;
            border:none; border-radius:6px;
            cursor:pointer; font-size:16px;
        }
        img.logo {
            width:120px; height:120px; object-fit:cover; border-radius:8px;
            margin-bottom:15px;
        }
        .success { color:green; }
        .error { color:red; }
    </style>
</head>

<body>
<?php include "includes/header.php"; ?>

<div class="container">

<h2>Edit University Profile</h2>

<?php if ($success): ?><p class="success"><?= $success; ?></p><?php endif; ?>
<?php if ($error): ?><p class="error"><?= $error; ?></p><?php endif; ?>

<form method="POST" enctype="multipart/form-data">

    <?php if ($uni['logo']): ?>
        <img src="uploads/<?= $uni['logo']; ?>" class="logo">
    <?php endif; ?>

    <input type="text" name="uni_name" value="<?= $uni['uni_name']; ?>" required placeholder="University Name">
    
    <input type="text" name="address" value="<?= $uni['address']; ?>" placeholder="Address">
    
    <textarea name="description" placeholder="Description"><?= $uni['description']; ?></textarea>
    
    <label>Update Logo:</label>
    <input type="file" name="logo" accept="image/*">

    <button type="submit">Save Changes</button>
</form>

</div>

</body>
</html>
