<?php
require "includes/admin-auth.php";
require "../backend/db.php";

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $conn->prepare("DELETE FROM students_profiles WHERE student_id = ?")->execute([$id]);
    header("Location: manage-students.php");
    exit;
}

$students = $conn->query("SELECT * FROM students_profiles ORDER BY student_id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
<title>Manage Students</title>

<style>

/* PAGE CONTAINER */
.container {
    width: 95%;
    max-width: 1300px;
    margin: 40px auto;
    background: #ffffff;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.08);
}

/* PAGE HEADING */
.container h2 {
    font-size: 26px;
    margin-bottom: 25px;
    font-weight: 700;
    background: linear-gradient(135deg, #1abc9c, #3498db);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

/* SCROLL BOX */
.scroll-box {
    overflow-x: auto;
    white-space: nowrap;
    padding-bottom: 10px;
}

/* TABLE DESIGN */
table {
    width: 100%;
    border-collapse: collapse;
    min-width: 1300px;
    font-size: 14px;
}

/* HEADER */
th {
    background: linear-gradient(135deg, #1abc9c, #3498db);
    color: white;
    padding: 12px 10px;
    font-weight: 700;
    border: none;
    text-align: left;
}

/* TABLE ROWS */
td {
    padding: 10px;
    border-bottom: 1px solid #e6e6e6;
    vertical-align: top;
    color: #444;
}

/* EVEN ROW STRIPED EFFECT */
tr:nth-child(even) {
    background: #f5fafc;
}

/* HOVER EFFECT */
tr:hover {
    background: #ecf9ff;
    transition: 0.2s;
}

/* DELETE BUTTON */
.delete-btn {
    color: #e74c3c;
    font-weight: bold;
    text-decoration: none;
    padding: 6px 10px;
    border-radius: 5px;
    background: #ffecec;
    border: 1px solid #ffb5b5;
}

.delete-btn:hover {
    background: #ffdddd;
    border-color: #ff8c8c;
}
</style>

</head>
<body>

<?php include "includes/header.php"; ?>

<div class="container">
    <h2>All Students</h2>

    <div class="scroll-box">
        <table>
            <tr>
                <th>ID</th>
                <th>Academic History</th>
                <th>Personal Info</th>
                <th>Preferences</th>
                <th>Future Goals</th>
                <th>Date of Birth</th>
                <th>Phone</th>
                <th>CNIC</th>
                <th>Gender</th>
                <th>Education Level</th>
                <th>Subjects</th>
                <th>Grades</th>
                <th>Desired Field</th>
                <th>Programs Interest</th>
                <th>Preferred City</th>
                <th>Action</th>
            </tr>

            <?php foreach($students as $s): ?>
            <tr>
                <td><?= $s['student_id'] ?></td>
                <td><?= nl2br(htmlspecialchars($s['academic_history'])) ?></td>
                <td><?= nl2br(htmlspecialchars($s['personal_info'])) ?></td>
                <td><?= nl2br(htmlspecialchars($s['preferences'])) ?></td>
                <td><?= nl2br(htmlspecialchars($s['future_goals'])) ?></td>
                <td><?= $s['date_of_birth'] ?></td>
                <td><?= htmlspecialchars($s['phone']) ?></td>
                <td><?= htmlspecialchars($s['cnic']) ?></td>
                <td><?= htmlspecialchars($s['gender']) ?></td>
                <td><?= htmlspecialchars($s['education_level']) ?></td>
                <td><?= nl2br(htmlspecialchars($s['subjects'])) ?></td>
                <td><?= htmlspecialchars($s['grades']) ?></td>
                <td><?= htmlspecialchars($s['desired_field']) ?></td>
                <td><?= nl2br(htmlspecialchars($s['programs_interest'])) ?></td>
                <td><?= htmlspecialchars($s['preferred_city']) ?></td>

                <td>
                    <a href="?delete=<?= $s['student_id'] ?>"
                       onclick="return confirm('Delete this student?')"
                       class="delete-btn">
                       Delete
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>

        </table>
    </div>

</div>

<?php include "includes/footer.php"; ?>

</body>
</html>
