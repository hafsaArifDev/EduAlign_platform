<?php
require "includes/admin-auth.php";
require "../backend/db.php";

if (isset($_POST['add_job'])) {
    $stmt = $conn->prepare("INSERT INTO jobs (job_title, department, institute, city, required_subject, skills_required, salary, deadline, description) VALUES (?,?,?,?,?,?,?,?,?)");
    $stmt->execute([
        $_POST['job_title'], $_POST['department'], $_POST['institute'], $_POST['city'],
        $_POST['required_subject'], $_POST['skills_required'], $_POST['salary'], $_POST['deadline'], $_POST['description']
    ]);
    $success = "Job added.";
}

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $conn->prepare("DELETE FROM jobs WHERE id = ?")->execute([$id]);
    header("Location: manage-jobs.php");
    exit;
}

$jobs = $conn->query("SELECT * FROM jobs ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head><title>Manage Jobs</title></head>
<body>
<?php include "includes/header.php"; ?>
<div class="container">
    <h2>Manage Jobs</h2>

    <h3>Add Job</h3>
    <form method="POST">
        <input name="job_title" placeholder="Job Title" required>
        <input name="department" placeholder="Department">
        <input name="institute" placeholder="Institute">
        <input name="city" placeholder="City">
        <input name="required_subject" placeholder="Required Subject">
        <input name="skills_required" placeholder="Skills Required">
        <input name="salary" placeholder="Salary">
        <input type="date" name="deadline" placeholder="Deadline">
        <textarea name="description" placeholder="Description"></textarea>
        <button name="add_job" type="submit">Add Job</button>
    </form>

    <h3>Existing Jobs</h3>
    <table border="1" width="100%">
        <tr><th>#</th><th>Title</th><th>Institute</th><th>City</th><th>Deadline</th><th>Action</th></tr>
        <?php foreach($jobs as $j): ?>
        <tr>
            <td><?= $j['id'] ?></td>
            <td><?= htmlspecialchars($j['job_title']) ?></td>
            <td><?= htmlspecialchars($j['institute']) ?></td>
            <td><?= htmlspecialchars($j['city']) ?></td>
            <td><?= $j['deadline'] ?></td>
            <td><a href="?delete=<?= $j['id'] ?>" onclick="return confirm('Delete?')">Delete</a></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
<?php include "includes/footer.php"; ?>
</body>
</html>
