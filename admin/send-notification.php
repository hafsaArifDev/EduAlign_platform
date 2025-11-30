<?php
require "includes/admin-auth.php";
require "../backend/db.php";

$success = "";
if (isset($_POST['send'])) {
    $type = $_POST['type']; // 'faculty' or 'student'
    $target = $_POST['target_id']; // specific id or 'all'
    $message = $_POST['message'];

    if ($target == 'all') {
        if ($type == 'faculty') {
            $stmt = $conn->query("SELECT faculty_id FROM faculty_profile");
            $rows = $stmt->fetchAll(PDO::FETCH_COLUMN);
            foreach ($rows as $fid) {
                $conn->prepare("INSERT INTO faculty_notifications (faculty_id, message) VALUES (?,?)")->execute([$fid, $message]);
            }
        } else {
            $stmt = $conn->query("SELECT student_id FROM students_profiles");
            $rows = $stmt->fetchAll(PDO::FETCH_COLUMN);
            foreach ($rows as $sid) {
                $conn->prepare("INSERT INTO student_notifications (student_id, message) VALUES (?,?)")->execute([$sid, $message]);
            }
        }
        $success = "Notification sent to all.";
    } else {
        if ($type == 'faculty') {
            $conn->prepare("INSERT INTO faculty_notifications (faculty_id, message) VALUES (?,?)")->execute([$target, $message]);
        } else {
            $conn->prepare("INSERT INTO student_notifications (student_id, message) VALUES (?,?)")->execute([$target, $message]);
        }
        $success = "Notification sent.";
    }
}
?>
<!DOCTYPE html><html><head><title>Send Notification</title></head><body>
<?php include "includes/header.php"; ?>
<div class="container">
    <h2>Send Notification</h2>
    <?php if ($success) echo "<p class='success'>$success</p>"; ?>
    <form method="POST">
        <select name="type">
            <option value="student">Student</option>
            <option value="faculty">Faculty</option>
        </select>
        <input name="target_id" placeholder="Target ID or type 'all'">
        <textarea name="message" placeholder="Message here" required></textarea>
        <button name="send" type="submit">Send</button>
    </form>
</div>
<?php include "includes/footer.php"; ?>
</body></html>
