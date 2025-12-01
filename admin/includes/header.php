<?php
// includes/admin-header.php
?>
<header class="admin-header">
    <h1>EduAlign – Admin Panel</h1>

    <nav class="admin-nav">
        <a href="/eduAlign-platform/admin/dashboard.php">Dashboard</a>
        <a href="/eduAlign-platform/admin/manage-students.php">Students</a>
        <a href="/eduAlign-platform/admin/manage-faculty.php">Faculty</a>
        <a href="/eduAlign-platform/admin/manage-programs.php">Programs</a>
        <a href="/eduAlign-platform/admin/manage-jobs.php">Jobs</a>
        <a href="/eduAlign-platform/admin/manage-applications.php">Applications</a>
        <a href="/eduAlign-platform/admin/send-notification.php">Send Notification</a>
        <a href="/eduAlign-platform/admin/logout.php" class="logout-btn">Logout</a>
    </nav>
</header>

<style>
/* PROFESSIONAL ADMIN HEADER (Same as Student Portal Header) */
.admin-header {
    background: linear-gradient(135deg, #1abc9c, #3498db);
    color: white;
    padding: 15px 25px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}

/* LEFT SIDE TITLE */
.admin-header h1 {
    margin: 0;
    font-size: 26px;
    font-weight: 700;
    letter-spacing: 1px;
}

/* NAV LINKS */
.admin-nav a {
    color: white;
    margin-left: 18px;
    text-decoration: none;
    font-weight: 600;
    font-size: 15px;
    transition: 0.3s ease;
}

/* Hover Effect */
.admin-nav a:hover {
    opacity: 0.85;
    text-decoration: underline;
}

/* LOGOUT BUTTON DIFFERENT */
.logout-btn {
    background: white;
    color: #e74c3c !important;
    padding: 8px 14px;
    border-radius: 6px;
    font-weight: 700;
    box-shadow: 0 3px 10px rgba(0,0,0,0.15);
}

.logout-btn:hover {
    background: #ffeaea;
    transform: translateY(-2px);
}
</style>
