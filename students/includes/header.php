<!DOCTYPE html>
<html>
<head>
    <style>
        /* PROFESSIONAL HEADER DESIGN */
        .main-header {
            background: linear-gradient(135deg, #1abc9c, #3498db);
            color: white;
            padding: 15px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        /* Left side title */
        .main-header h1 {
            margin: 0;
            font-size: 26px;
            font-weight: 700;
            letter-spacing: 1px;
        }

        /* Right side Dashboard Button */
        .dash-btn {
            background: white;
            color: #3498db !important;
            padding: 10px 18px;
            border-radius: 6px;
            font-weight: 700;
            text-decoration: none;
            font-size: 15px;
            transition: 0.3s ease;
            box-shadow: 0 3px 10px rgba(0,0,0,0.15);
        }

        .dash-btn:hover {
            background: #ecf9ff;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
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
.header-right {
    display: flex;
    align-items: center;
    gap: 12px; /* space between buttons */
}


    </style>
</head>

<body>

<header class="main-header">
    <h1>EduAlign – Student Portal</h1>

    <div class="header-right">
    <!-- NEW BUTTON ADDED HERE -->
    <a href="index.php" class="dash-btn">Student Dashboard</a>
    <a href="/eduAlign-platform/students/logout.php" class="logout-btn">Logout</a>
     </div>
</header>