<?php
require "includes/admin-auth.php";
require "../backend/db.php";

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $conn->prepare("DELETE FROM faculty_profile WHERE faculty_id = ?")->execute([$id]);
    header("Location: manage-faculty.php");
    exit;
}

$faculty = $conn->query("SELECT * FROM faculty_profile ORDER BY faculty_id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
<title>Manage Faculty</title>

<style>

/* FIXED PAGE CONTAINER */
.container {
    width: 95%;
    max-width: 1500px;
    margin: 30px auto;
    background: white;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
}

/* TITLE */
.container h2 {
    font-size: 24px;
    font-weight: 700;
    margin-bottom: 20px;
    background: linear-gradient(135deg, #1abc9c, #3498db);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

/* SCROLL WRAPPER – FIX ALIGNMENT ISSUE */
.table-wrapper {
    overflow-x: auto;
    width: 100%;
}

/* TABLE */
table {
    width: 100%;
    min-width: 1800px; /* FIX: Table now scrolls, no overflow breaking */
    border-collapse: collapse;
    table-layout: auto;
}

/* HEADER */
th {
    background: linear-gradient(135deg, #1abc9c, #3498db);
    color: white;
    padding: 10px;
    font-size: 13px;
    white-space: nowrap;
    text-align: left;
}

/* ROWS */
td {
    padding: 10px;
    font-size: 13px;
    border-bottom: 1px solid #ddd;
    word-wrap: break-word;
    white-space: normal;
}

/* ZEBRA */
tr:nth-child(even) {
    background: #f8fcff;
}

/* HOVER */
tr:hover {
    background: #e9f7ff;
}

/* BUTTONS */
.view-btn {
    color: #2980b9;
    text-decoration: none;
    font-weight: bold;
}

.view-btn:hover {
    text-decoration: underline;
}

.delete-btn {
    background: #ffe5e5;
    border: 1px solid #ffb3b3;
    padding: 5px 10px;
    border-radius: 5px;
    color: #e74c3c;
    text-decoration: none;
    font-weight: 600;
}

.delete-btn:hover {
    background: #ffd6d6;
}

</style>
</head>
<body>

<?php include "includes/header.php"; ?>

<div class="container">
    <h2>Faculty Profiles</h2>

    <div class="table-wrapper">
    <table>
        <tr>
            <th>ID</th>
            <th>Fullname</th>
            <th>Email</th>
            <th>CNIC</th>
            <th>Contact</th>
            <th>Gender</th>
            <th>Nationality</th>
            <th>DOB</th>
            <th>Education</th>
            <th>Experience</th>
            <th>Publications</th>
            <th>Expertise</th>
            <th>Degree</th>
            <th>Institution</th>
            <th>Passing Year</th>
            <th>Marks/CGPA</th>
            <th>University</th>
            <th>Major Subjects</th>
            <th>Organization</th>
            <th>Designation</th>
            <th>Start</th>
            <th>End</th>
            <th>Primary Teaching</th>
            <th>Research Interest</th>
            <th>Preferred Departments</th>
            <th>Certifications</th>
            <th>Skills</th>
            <th>Reference</th>
            <th>Resume</th>
            <th>CV</th>
            <th>Action</th>
        </tr>

        <?php foreach ($faculty as $f): ?>
        <tr>
            <td><?= $f['faculty_id'] ?></td>
            <td><?= htmlspecialchars($f['fullname']) ?></td>
            <td><?= htmlspecialchars($f['email']) ?></td>
            <td><?= htmlspecialchars($f['cnic']) ?></td>
            <td><?= htmlspecialchars($f['contact']) ?></td>
            <td><?= htmlspecialchars($f['gender']) ?></td>
            <td><?= htmlspecialchars($f['nationality']) ?></td>
            <td><?= htmlspecialchars($f['date_of_birth']) ?></td>
            <td><?= nl2br(htmlspecialchars($f['education'])) ?></td>
            <td><?= nl2br(htmlspecialchars($f['experience'])) ?></td>
            <td><?= nl2br(htmlspecialchars($f['publications'])) ?></td>
            <td><?= nl2br(htmlspecialchars($f['expertise'])) ?></td>
            <td><?= htmlspecialchars($f['degree']) ?></td>
            <td><?= htmlspecialchars($f['institution']) ?></td>
            <td><?= htmlspecialchars($f['passing_year']) ?></td>
            <td><?= htmlspecialchars($f['marks_cgpa']) ?></td>
            <td><?= htmlspecialchars($f['university']) ?></td>
            <td><?= nl2br(htmlspecialchars($f['major_subjects'])) ?></td>
            <td><?= htmlspecialchars($f['organization_name']) ?></td>
            <td><?= htmlspecialchars($f['designation']) ?></td>
            <td><?= htmlspecialchars($f['start_date']) ?></td>
            <td><?= htmlspecialchars($f['end_date']) ?></td>
            <td><?= htmlspecialchars($f['primary_teaching_subjects']) ?></td>
            <td><?= htmlspecialchars($f['research_interest']) ?></td>
            <td><?= htmlspecialchars($f['preferred_departments']) ?></td>
            <td><?= nl2br(htmlspecialchars($f['certifications'])) ?></td>
            <td><?= htmlspecialchars($f['skills']) ?></td>
            <td><?= htmlspecialchars($f['reference_contact']) ?></td>
            <td><?php if($f['resume']): ?><a class="view-btn" href="../uploads/<?= $f['resume'] ?>" target="_blank">View</a><?php endif; ?></td>
            <td><?php if($f['cv']): ?><a class="view-btn" href="../uploads/<?= $f['cv'] ?>" target="_blank">View</a><?php endif; ?></td>
            <td><a href="?delete=<?= $f['faculty_id'] ?>" class="delete-btn" onclick="return confirm('Delete faculty?')">Delete</a></td>
        </tr>
        <?php endforeach; ?>

    </table>
    </div>
</div>

<?php include "includes/footer.php"; ?>

</body>
</html>
