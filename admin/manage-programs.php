<?php
require "includes/admin-auth.php";
require "../backend/db.php";

$success = $error = "";

// Add program
if (isset($_POST['add_program'])) {
    $stmt = $conn->prepare("INSERT INTO programs 
        (program_name, degree_level, university_name, city, fee, deadline, description) 
        VALUES (?,?,?,?,?,?,?)");

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
<head>
<title>Manage Programs</title>

<style>

/* PAGE CONTAINER */
.container {
    width: 90%;
    max-width: 1200px;
    margin: 40px auto;
    background: #ffffff;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.08);
}

/* HEADINGS */
.container h2, .container h3 {
    font-weight: 700;
    background: linear-gradient(135deg, #1abc9c, #3498db);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.container h2 { font-size: 28px; margin-bottom: 20px; }
.container h3 { font-size: 22px; margin-top: 30px; }

/* SUCCESS MESSAGE */
.success {
    padding: 10px;
    background: #e6ffed;
    color: #2e8b57;
    border-left: 4px solid #2ecc71;
    margin-bottom: 15px;
    font-weight: bold;
}

/* FORM STYLING */
form {
    background: #f8fcff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.06);
    margin-bottom: 30px;
}

form input, form textarea {
    width: 100%;
    margin-bottom: 12px;
    padding: 10px;
    border: 1px solid #c9d6df;
    border-radius: 6px;
    font-size: 15px;
}

form button {
    background: linear-gradient(135deg, #1abc9c, #3498db);
    border: none;
    padding: 10px 25px;
    border-radius: 6px;
    font-size: 16px;
    color: white;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s ease;
}

form button:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0,0,0,0.15);
}

/* TABLE */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
    font-size: 15px;
}

th {
    background: linear-gradient(135deg, #1abc9c, #3498db);
    color: white;
    padding: 10px;
    font-weight: 700;
    text-align: left;
}

td {
    padding: 10px;
    border-bottom: 1px solid #e6e6e6;
}

tr:nth-child(even) {
    background: #f4fbff;
}

tr:hover {
    background: #eaf7ff;
    transition: 0.2s ease;
}

/* DELETE BUTTON */
.delete-btn {
    background: #ffe5e5;
    color: #e74c3c;
    padding: 6px 12px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 600;
    border: 1px solid #ffbebe;
}

.delete-btn:hover {
    background: #ffd6d6;
}

</style>

</head>
<body>

<?php include "includes/header.php"; ?>

<div class="container">

    <h2>Manage Programs</h2>
    <?php if ($success) echo "<p class='success'>$success</p>"; ?>

    <!-- ADD PROGRAM FORM -->
    <h3>Add Program</h3>
    <form method="POST">
        <input name="program_name" placeholder="Program Name" required>
        <input name="degree_level" placeholder="Degree Level">
        <input name="university_name" placeholder="University">
        <input name="city" placeholder="City">
        <input name="fee" placeholder="Fee">
        <input type="date" name="deadline">
        <textarea name="description" placeholder="Description" rows="3"></textarea>
        <button name="add_program" type="submit">Add Program</button>
    </form>

    <!-- EXISTING PROGRAMS TABLE -->
    <h3>Existing Programs</h3>
    <table>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>University</th>
            <th>City</th>
            <th>Deadline</th>
            <th>Action</th>
        </tr>

        <?php foreach($programs as $p): ?>
        <tr>
            <td><?= $p['id'] ?></td>
            <td><?= htmlspecialchars($p['program_name']) ?></td>
            <td><?= htmlspecialchars($p['university_name']) ?></td>
            <td><?= htmlspecialchars($p['city']) ?></td>
            <td><?= $p['deadline'] ?></td>
            <td>
                <a class="delete-btn" href="?delete=<?= $p['id'] ?>" onclick="return confirm('Delete program?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>

    </table>

</div>

<?php include "includes/footer.php"; ?>

</body>
</html>
