<?php
require "includes/admin-auth.php";
require "../backend/db.php";

$success = $error = "";

// Add program
if (isset($_POST['add_program'])) {
    $stmt = $conn->prepare("INSERT INTO programs (program_name, degree_level, university_name, city, fee, deadline, description) VALUES (?,?,?,?,?,?,?)");
    $stmt->execute([
        $_POST['program_name'], $_POST['degree_level'], $_POST['university_name'],
        $_POST['city'], $_POST['fee'], $_POST['deadline'], $_POST['description']
    ]);
    $success = "Program added.";
}

// Delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $conn->prepare("DELETE FROM programs WHERE id = ?")->execute([$id]);
    header("Location: manage-programs.php");
    exit;
}

$programs = $conn->query("SELECT * FROM programs ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head><title>Manage Programs</title></head>
<body>
<?php include "includes/header.php"; ?>
<div class="container">
    <h2>Manage Programs</h2>
    <?php if ($success) echo "<p class='success'>$success</p>"; ?>

    <h3>Add Program</h3>
    <form method="POST">
        <input name="program_name" placeholder="Program Name" required>
        <input name="degree_level" placeholder="Degree Level">
        <input name="university_name" placeholder="University">
        <input name="city" placeholder="City">
        <input name="fee" placeholder="Fee">
        <input type="date" name="deadline" placeholder="Deadline">
        <textarea name="description" placeholder="Description"></textarea>
        <button name="add_program" type="submit">Add</button>
    </form>

    <h3>Existing Programs</h3>
    <table border="1" width="100%">
        <tr><th>#</th><th>Name</th><th>University</th><th>City</th><th>Deadline</th><th>Action</th></tr>
        <?php foreach($programs as $p): ?>
        <tr>
            <td><?= $p['id'] ?></td>
            <td><?= htmlspecialchars($p['program_name']) ?></td>
            <td><?= htmlspecialchars($p['university_name']) ?></td>
            <td><?= htmlspecialchars($p['city']) ?></td>
            <td><?= $p['deadline'] ?></td>
            <td><a href="?delete=<?= $p['id'] ?>" onclick="return confirm('Delete?')">Delete</a></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
<?php include "includes/footer.php"; ?>
</body>
</html>
