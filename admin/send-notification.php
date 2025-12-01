<?php
require "includes/admin-auth.php";
require "../backend/db.php";

$success = "";
if (isset($_POST['send'])) {
    $type = $_POST['type']; 
    $target = $_POST['target_id'];
    $message = $_POST['message'];

    if ($target == 'all') {
        if ($type == 'faculty') {
            $stmt = $conn->query("SELECT faculty_id FROM faculty_profile");
            $rows = $stmt->fetchAll(PDO::FETCH_COLUMN);
            foreach ($rows as $fid) {
                $conn->prepare("INSERT INTO faculty_notifications (faculty_id, message) VALUES (?,?)")
                     ->execute([$fid, $message]);
            }
        } else {
            $stmt = $conn->query("SELECT student_id FROM students_profiles");
            $rows = $stmt->fetchAll(PDO::FETCH_COLUMN);
            foreach ($rows as $sid) {
                $conn->prepare("INSERT INTO student_notifications (student_id, message) VALUES (?,?)")
                     ->execute([$sid, $message]);
            }
        }
        $success = "Notification sent to all.";
    } else {
        if ($type == 'faculty') {
            $conn->prepare("INSERT INTO faculty_notifications (faculty_id, message) VALUES (?,?)")
                 ->execute([$target, $message]);
        } else {
            $conn->prepare("INSERT INTO student_notifications (student_id, message) VALUES (?,?)")
                 ->execute([$target, $message]);
        }
        $success = "Notification sent.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Send Notification</title>

<style>

/* PAGE CONTAINER */
.container {
    width: 90%;
    max-width: 700px;
    margin: 50px auto;
    background: white;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.08);
}

/* HEADING */
.container h2 {
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 20px;
    text-align: center;
    background: linear-gradient(135deg, #1abc9c, #3498db);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

/* SUCCESS BOX */
.success {
    padding: 12px;
    background: #e6ffed;
    color: #2e8b57;
    border-left: 5px solid #2ecc71;
    margin-bottom: 15px;
    font-weight: bold;
    border-radius: 6px;
}

/* FORM */
form {
    padding: 20px;
    background: #f7fcff;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.06);
}

form input, 
form select, 
form textarea {
    width: 100%;
    padding: 12px;
    margin-bottom: 12px;
    border: 1px solid #c9d6df;
    border-radius: 6px;
    font-size: 15px;
}

/* TEXTAREA HEIGHT */
textarea {
    height: 120px;
    resize: vertical;
}

/* BUTTON */
form button {
    width: 100%;
    background: linear-gradient(135deg, #1abc9c, #3498db);
    color: white;
    border: none;
    padding: 12px;
    border-radius: 6px;
    font-size: 17px;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s ease;
}

form button:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 12px rgba(0,0,0,0.15);
}

</style>

</head>
<body>

<?php include "includes/header.php"; ?>

<div class="container">

    <h2>Send Notification</h2>

    <?php if ($success): ?>
        <p class="success"><?= $success ?></p>
    <?php endif; ?>

    <!-- SEND NOTIFICATION FORM -->
    <form method="POST">
        <select name="type">
            <option value="student">Send to Students</option>
            <option value="faculty">Send to Faculty</option>
        </select>

        <input name="target_id" placeholder="Target ID or type 'all'">

        <textarea name="message" placeholder="Write your notification..." required></textarea>

        <button name="send" type="submit">Send Notification</button>
    </form>

</div>

<?php include "includes/footer.php"; ?>

</body>
</html>
