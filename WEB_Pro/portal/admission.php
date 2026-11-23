<?php
require 'db.php';
$message = '';

// SUBMIT ADMISSION FORM
if (isset($_POST['submit_admission'])) {
    try {
        $stmt = $pdo->prepare("INSERT INTO admissions (applicant_name, dob, course, marks_percentage, phone) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([
            trim($_POST['applicant_name']),
            $_POST['dob'],
            $_POST['course'],
            $_POST['marks_percentage'],
            trim($_POST['phone'])
        ]);
        header("Location: admission.php?msg=submitted");
        exit;
    } catch (PDOException $e) {
        $message = "Error submitting form: " . $e->getMessage();
    }
}

// DELETE APPLICATION
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM admissions WHERE id=?");
    $stmt->execute([$_GET['delete']]);
    header("Location: admission.php?msg=deleted");
    exit;
}

if (isset($_GET['msg'])) {
    $message = ($_GET['msg'] === 'submitted') ? "Admission application submitted successfully!" : "Application deleted.";
}

// FETCH ALL APPLICATIONS
$admissions = $pdo->query("SELECT * FROM admissions ORDER BY id DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>College Admission Form</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background: #f4f6f9; color: #333; }
        .container { max-width: 900px; margin: auto; background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        h2 { margin-top: 0; color: #1e293b; }
        .alert { padding: 10px 15px; background: #dcfce7; color: #166534; border-radius: 5px; margin-bottom: 15px; }
        .form-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; margin-bottom: 15px; }
        label { display: block; font-size: 13px; font-weight: bold; margin-bottom: 5px; }
        input, select { padding: 10px; border: 1px solid #cbd5e1; border-radius: 5px; width: 100%; box-sizing: border-box; }
        button { padding: 10px 18px; background: #2563eb; color: #fff; border: none; border-radius: 5px; cursor: pointer; font-size: 14px; }
        .btn-del { background: #dc2626; color: #fff; padding: 5px 10px; border-radius: 4px; text-decoration: none; font-size: 13px; }
        table { width: 100%; border-collapse: collapse; margin-top: 25px; }
        th, td { padding: 12px; border-bottom: 1px solid #e2e8f0; text-align: left; }
        th { background: #f8fafc; }
    </style>
</head>
<body>
<div class="container">
    <h2>College Admission Form</h2>

    <?php if ($message): ?>
        <div class="alert"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-grid">
            <div>
                <label>Applicant Full Name</label>
                <input type="text" name="applicant_name" placeholder="Enter full name" required>
            </div>
            <div>
                <label>Date of Birth</label>
                <input type="date" name="dob" required>
            </div>
            <div>
                <label>Select Course</label>
                <select name="course" required>
                    <option value="">-- Choose Course --</option>
                    <option value="B.Sc Computer Science">B.Sc Computer Science</option>
                    <option value="BCA">BCA</option>
                    <option value="B.Tech CSE">B.Tech CSE</option>
                    <option value="B.Com">B.Com</option>
                    <option value="BBA">BBA</option>
                </select>
            </div>
            <div>
                <label>12th Grade Marks (%)</label>
                <input type="number" step="0.01" min="0" max="100" name="marks_percentage" placeholder="e.g., 85.50" required>
            </div>
            <div>
                <label>Phone Number</label>
                <input type="tel" name="phone" placeholder="e.g., 9876543210" required>
            </div>
        </div>
        <button type="submit" name="submit_admission">Submit Application</button>
    </form>

    <h3>Submitted Applications</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Applicant Name</th>
                <th>DOB</th>
                <th>Course</th>
                <th>Marks (%)</th>
                <th>Phone</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($admissions) === 0): ?>
                <tr><td colspan="7" style="text-align:center;">No applications submitted yet.</td></tr>
            <?php endif; ?>
            <?php foreach ($admissions as $app): ?>
            <tr>
                <td>#<?= $app['id'] ?></td>
                <td><?= htmlspecialchars($app['applicant_name']) ?></td>
                <td><?= htmlspecialchars($app['dob']) ?></td>
                <td><?= htmlspecialchars($app['course']) ?></td>
                <td><?= htmlspecialchars($app['marks_percentage']) ?>%</td>
                <td><?= htmlspecialchars($app['phone']) ?></td>
                <td>
                    <a href="?delete=<?= $app['id'] ?>" class="btn-del" onclick="return confirm('Delete this application?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>

