<?php
require 'db.php';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)");
    try {
        $stmt->execute([$name, $email, $pass]);
        $message = "Registration successful! <a href='login.php'>Login here</a>";
    } catch (PDOException $e) {
        $message = "Error: Email already registered.";
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Student Registration</title></head>
<body>
    <h2>Student Registration</h2>
    <p><?= $message ?></p>
    <form method="POST">
        <input type="text" name="full_name" placeholder="Full Name" required><br><br>
        <input type="email" name="email" placeholder="Email" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <button type="submit">Register</button>
    </form>
</body>
</html>
