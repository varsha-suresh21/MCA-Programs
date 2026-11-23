<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>College Web Applications Portal</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f4f6f9; color: #333; }
        .container { max-width: 600px; margin: auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        h2 { margin-top: 0; color: #1e293b; }
        .nav-list { list-style: none; padding: 0; }
        .nav-list li { margin: 12px 0; }
        .nav-list a { display: block; padding: 12px 16px; background: #2563eb; color: #fff; text-decoration: none; border-radius: 5px; font-weight: bold; }
        .nav-list a:hover { background: #1d4ed8; }
        .logout-btn { background: #dc2626 !important; margin-top: 25px; }
    </style>
</head>
<body>
<div class="container">
    <h2>Web Applications Dashboard</h2>
    
    <?php if (isset($_SESSION['user_name'])): ?>
        <p>Welcome, <strong><?= htmlspecialchars($_SESSION['user_name']) ?></strong>!</p>
    <?php endif; ?>

    <ul class="nav-list">
        <li><a href="register.php">1. Student Registration System</a></li>
        <li><a href="login.php">2. Student Login System</a></li>
        <li><a href="students.php">3. Student Record Management System</a></li>
        <li><a href="admission.php">4. College Admission Form</a></li>
        <li><a href="employee.php">5. Employee Management System</a></li>
        <li><a href="library.php">6. Library Management System</a></li>
        <li><a href="logout.php" class="logout-btn">Logout</a></li>
    </ul>
</div>
</body>
</html>
