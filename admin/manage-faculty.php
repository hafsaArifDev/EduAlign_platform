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
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        font-size: 13px;
    }
    th, td {
        padding: 8px;
        border: 1px solid #ccc;
        vertical-align: top;
    }
    th {
        background: #f1f1f1;
        font-weight: bold;
    }
</style>
</head>
<body>

<?php include "includes/header.php"; ?>

<div class="container">
    <h2>Faculty Profiles (Full Detail)</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Fullname</th>
            <th>Email</th>
            <th>CNIC</th>
            <th>Contact</th>
            <th>Gender</th>
            <th>Nationality</th>
            <th>Date of Birth</th>
            
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
            <th>Start Date</th>
            <th>End Date</th>

            <th>Primary Teaching</th>
            <th>Research Interest</th>
            <th>Preferred Departments</th>
            <th>Certifications</th>
            <th>Skills</th>
            <th>Reference_contact</th>

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

            <td><?= htmlspecialchars($f['education']) ?></td>
            <td><?= htmlspecialchars($f['experience']) ?></td>
            <td><?= htmlspecialchars($f['publications']) ?></td>
            <td><?= htmlspecialchars($f['expertise']) ?></td>

            <td><?= htmlspecialchars($f['degree']) ?></td>
            <td><?= htmlspecialchars($f['institution']) ?></td>
            <td><?= htmlspecialchars($f['passing_year']) ?></td>
            <td><?= htmlspecialchars($f['marks_cgpa']) ?></td>
            <td><?= htmlspecialchars($f['university']) ?></td>
            <td><?= htmlspecialchars($f['major_subjects']) ?></td>

            <td><?= htmlspecialchars($f['organization_name']) ?></td>
            <td><?= htmlspecialchars($f['designation']) ?></td>
            <td><?= htmlspecialchars($f['start_date']) ?></td>
            <td><?= htmlspecialchars($f['end_date']) ?></td>

            <td><?= htmlspecialchars($f['primary_teaching_subjects']) ?></td>
            <td><?= htmlspecialchars($f['research_interest']) ?></td>
            <td><?= htmlspecialchars($f['preferred_departments']) ?></td>
            <td><?= htmlspecialchars($f['certifications']) ?></td>
            <td><?= htmlspecialchars($f['skills']) ?></td>
            <td><?= htmlspecialchars($f['reference_contact']) ?></td>

            <td>
                <?php if (!empty($f['resume'])): ?>
                    <a href="../uploads/<?= $f['resume'] ?>" target="_blank">View</a>
                <?php endif; ?>
            </td>

            <td>
                <?php if (!empty($f['cv'])): ?>
                    <a href="../uploads/<?= $f['cv'] ?>" target="_blank">View</a>
                <?php endif; ?>
            </td>

            <td>
                <a href="?delete=<?= $f['faculty_id'] ?>" onclick="return confirm('Delete this faculty?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>

    </table>

</div>

<?php include "includes/footer.php"; ?>

</body>
</html>
