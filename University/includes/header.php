<?php
// university/includes/header.php
?>
<!DOCTYPE html>
<html>
<head>
    <style>
        .main-header {
            background: linear-gradient(135deg, #1abc9c, #3498db);
            color: white;
            padding: 16px 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .main-header .logo {
            font-size: 22px;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .header-actions {
            display: flex;
            gap: 12px;
        }

        .btn-outline {
            padding: 8px 18px;
            border-radius: 20px;
            border: 2px solid #ffffff;
            color: #ffffff;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: 0.3s ease;
        }

        .btn-outline:hover {
            background: #ffffff;
            color: #3498db;
        }

        .btn-logout {
            padding: 8px 18px;
            border-radius: 20px;
            background: #e74c3c;
            color: #ffffff;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: 0.3s ease;
        }

        .btn-logout:hover {
            background: #c0392b;
        }
    </style>
</head>

<body>

<header class="main-header">
    <div class="logo">
        EduAlign – University Portal
    </div>

    <div class="header-actions">

        <!-- 🔹 MAIN NEON DASHBOARD -->
        <a href="../index.php" class="btn-outline">
            Main Dashboard
        </a>

        <!-- 🔹 UNIVERSITY DASHBOARD -->
        <a href="index.php" class="btn-outline">
            University Dashboard
        </a>

        <!-- 🔹 LOGOUT -->
        <a href="logout.php" class="btn-logout">
            Logout
        </a>

    </div>
</header>

</body>
</html>
