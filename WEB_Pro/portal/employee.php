<?php
require 'db.php';
$message = '';

// ADD EMPLOYEE
if (isset($_POST['add'])) {
    try {
        $stmt = $pdo->prepare("INSERT INTO employees (emp_code, name, designation, salary) VALUES (?, ?, ?, ?)");
        $stmt->execute([trim($_POST['emp_code']), trim($_POST['name']), trim($_POST['designation']), $_POST['salary']]);
        header("Location: employees.php?msg=added");
        exit;
    } catch (PDOException $e) {
        $message = "Error: Employee Code already exists.";
    }
}

// UPDATE EMPLOYEE
if (isset($_POST['update'])) {
    $stmt = $pdo->prepare("UPDATE employees SET emp_code=?, name=?, designation=?, salary=? WHERE id=?");
    $stmt->execute([trim($_POST['emp_code']), trim($_POST['name']), trim($_POST['designation']), $_POST['salary'], $_POST['id']]);
    header("Location: employees.php?msg=updated");
    exit;
}

// DELETE EMPLOYEE
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM employees WHERE id=?");
    $stmt->execute([$_GET['delete']]);
    header("Location: employees.php?msg=deleted");
    exit;
}

// FETCH FOR EDIT
$editEmp = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM employees WHERE id=?");
    $stmt->execute([$_GET['edit']]);
    $editEmp = $stmt->fetch();
}

if (isset($_GET['msg'])) {
    $alerts = ['added' => 'Employee added.', 'updated' => 'Employee updated.', 'deleted' => 'Employee deleted.'];
    $message = $alerts[$_GET['msg']] ?? '';
}

$employees = $pdo->query("SELECT * FROM employees ORDER BY id DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employee Management System</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background: #f4f6f9; color: #333; }
        .container { max-width: 900px; margin: auto; background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        h2 { margin-top: 0; color: #1e293b; }
        .alert { padding: 10px 15px; background: #dcfce7; color: #166534; border-radius: 5px; margin-bottom: 15px; }
        .form-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin-bottom: 15px; }
        input { padding: 10px; border: 1px solid #cbd5e1; border-radius: 5px; width: 100%; box-sizing: border-box; }
        button, .btn { padding: 10px 16px; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; font-size: 14px; display: inline-block; }
        .btn-primary { background: #2563eb; color: #fff; }
        .btn-cancel { background: #64748b; color: #fff; }
        .btn-edit { background: #f59e0b; color: #fff; padding: 5px 10px; font-size: 13px; }
        .btn-del { background: #dc2626; color: #fff; padding: 5px 10px; font-size: 13px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; border-bottom: 1px solid #e2e8f0; text-align: left; }
        th { background: #f8fafc; }
    </style>
</head>
<body>
<div class="container">
    <h2>Employee Management System</h2>

    <?php if ($message): ?>
        <div class="alert"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="POST">
        <input type="hidden" name="id" value="<?= $editEmp['id'] ?? '' ?>">
        <div class="form-row">
            <input type="text" name="emp_code" placeholder="Emp Code (e.g., EMP01)" value="<?= htmlspecialchars($editEmp['emp_code'] ?? '') ?>" required>
            <input type="text" name="name" placeholder="Employee Name" value="<?= htmlspecialchars($editEmp['name'] ?? '') ?>" required>
            <input type="text" name="designation" placeholder="Designation" value="<?= htmlspecialchars($editEmp['designation'] ?? '') ?>" required>
            <input type="number" step="0.01" name="salary" placeholder="Salary" value="<?= htmlspecialchars($editEmp['salary'] ?? '') ?>" required>
        </div>
        <button type="submit" class="btn-primary" name="<?= $editEmp ? 'update' : 'add' ?>">
            <?= $editEmp ? 'Update Employee' : 'Add Employee' ?>
        </button>
        <?php if ($editEmp): ?>
            <a href="employees.php" class="btn btn-cancel">Cancel</a>
        <?php endif; ?>
    </form>

    <table>
        <thead>
            <tr>
                <th>Emp Code</th>
                <th>Name</th>
                <th>Designation</th>
                <th>Salary</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($employees) === 0): ?>
                <tr><td colspan="5" style="text-align:center;">No employees found.</td></tr>
            <?php endif; ?>
            <?php foreach ($employees as $emp): ?>
            <tr>
                <td><?= htmlspecialchars($emp['emp_code']) ?></td>
                <td><?= htmlspecialchars($emp['name']) ?></td>
                <td><?= htmlspecialchars($emp['designation']) ?></td>
                <td>₹<?= number_format($emp['salary'], 2) ?></td>
                <td>
                    <a href="?edit=<?= $emp['id'] ?>" class="btn-edit">Edit</a>
                    <a href="?delete=<?= $emp['id'] ?>" class="btn-del" onclick="return confirm('Delete this employee?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
