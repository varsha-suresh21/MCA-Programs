<?php
session_start();
require 'db.php';

// CREATE
if (isset($_POST['add'])) {
    $stmt = $pdo->prepare("INSERT INTO students (roll_no, name, department, email) VALUES (?, ?, ?, ?)");
    $stmt->execute([$_POST['roll_no'], $_POST['name'], $_POST['department'], $_POST['email']]);
    header("Location: students.php"); exit;
}

// UPDATE
if (isset($_POST['update'])) {
    $stmt = $pdo->prepare("UPDATE students SET roll_no=?, name=?, department=?, email=? WHERE id=?");
    $stmt->execute([$_POST['roll_no'], $_POST['name'], $_POST['department'], $_POST['email'], $_POST['id']]);
    header("Location: students.php"); exit;
}

// DELETE
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM students WHERE id=?");
    $stmt->execute([$_GET['delete']]);
    header("Location: students.php"); exit;
}

// FETCH RECORD FOR EDITING
$editStudent = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM students WHERE id=?");
    $stmt->execute([$_GET['edit']]);
    $editStudent = $stmt->fetch();
}

// READ ALL
$students = $pdo->query("SELECT * FROM students ORDER BY id DESC")->fetchAll();
?>
<!DOCTYPE html>
<html>
<head><title>Student Record Management</title></head>
<body>
    <h2>Student Record Management (CRUD)</h2>
    <form method="POST">
        <input type="hidden" name="id" value="<?= $editStudent['id'] ?? '' ?>">
        <input type="text" name="roll_no" placeholder="Roll No" value="<?= $editStudent['roll_no'] ?? '' ?>" required>
        <input type="text" name="name" placeholder="Name" value="<?= $editStudent['name'] ?? '' ?>" required>
        <input type="text" name="department" placeholder="Department" value="<?= $editStudent['department'] ?? '' ?>" required>
        <input type="email" name="email" placeholder="Email" value="<?= $editStudent['email'] ?? '' ?>" required>
        <button type="submit" name="<?= $editStudent ? 'update' : 'add' ?>">
            <?= $editStudent ? 'Update Student' : 'Add Student' ?>
        </button>
    </form>
    <hr>
    <table border="1" cellpadding="8">
        <tr><th>Roll No</th><th>Name</th><th>Department</th><th>Email</th><th>Actions</th></tr>
        <?php foreach ($students as $s): ?>
        <tr>
            <td><?= htmlspecialchars($s['roll_no']) ?></td>
            <td><?= htmlspecialchars($s['name']) ?></td>
            <td><?= htmlspecialchars($s['department']) ?></td>
            <td><?= htmlspecialchars($s['email']) ?></td>
            <td>
                <a href="?edit=<?= $s['id'] ?>">Edit</a> | 
                <a href="?delete=<?= $s['id'] ?>" onclick="return confirm('Delete record?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
