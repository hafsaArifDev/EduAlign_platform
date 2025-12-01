<?php
require "includes/admin-auth.php";
require "../backend/db.php";

if (isset($_POST['add_job'])) {
    $stmt = $conn->prepare("INSERT INTO jobs 
        (job_title, department, institute, city, required_subject, skills_required, salary, deadline, description)
        VALUES (?,?,?,?,?,?,?,?,?)");

    $stmt->execute([
        $_POST['job_title'], $_POST['department'], $_POST['institute'], $_POST['city'],
        $_POST['required_subject'], $_POST['skills_required'], $_POST['salary'], 
        $_POST['deadline'], $_POST['description']
    ]);

    $success = "Job added successfully!";
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
<head>
<title>Manage Jobs</title>

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

/* FORM STYLE */
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

/* TABLE STYLE */
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
    transition: 0.2s;
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

    <h2>Manage Jobs</h2>

    <?php if (!empty($success)): ?>
        <p class="success"><?= $success ?></p>
    <?php endif; ?>

    <!-- ADD JOB FORM -->
    <h3>Add Job</h3>
    <form method="POST">
        <input name="job_title" placeholder="Job Title" required>
        <input name="department" placeholder="Department">
        <input name="institute" placeholder="Institute">
        <input name="city" placeholder="City">
        <input name="required_subject" placeholder="Required Subject">
        <input name="skills_required" placeholder="Skills Required">
        <input name="salary" placeholder="Salary">
        <input type="date" name="deadline">
        <textarea name="description" placeholder="Description" rows="3"></textarea>
        <button type="submit" name="add_job">Add Job</button>
    </form>

    <!-- JOB LIST TABLE -->
    <h3>Existing Jobs</h3>
    <table>
        <tr>
            <th>#</th>
            <th>Title</th>
            <th>Institute</th>
            <th>City</th>
            <th>Deadline</th>
            <th>Action</th>
        </tr>

        <?php foreach ($jobs as $j): ?>
        <tr>
            <td><?= $j['id'] ?></td>
            <td><?= htmlspecialchars($j['job_title']) ?></td>
            <td><?= htmlspecialchars($j['institute']) ?></td>
            <td><?= htmlspecialchars($j['city']) ?></td>
            <td><?= $j['deadline'] ?></td>
            <td>
                <a class="delete-btn" href="?delete=<?= $j['id'] ?>" onclick="return confirm('Delete this job?')">
                    Delete
                </a>
            </td>
        </tr>
        <?php endforeach; ?>

    </table>

</div>

<?php include "includes/footer.php"; ?>

</body>
</html>
