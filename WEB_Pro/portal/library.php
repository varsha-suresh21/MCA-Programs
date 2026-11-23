<?php
require 'db.php';
$message = '';

// ADD BOOK
if (isset($_POST['add'])) {
    try {
        $stmt = $pdo->prepare("INSERT INTO books (isbn, title, author, status) VALUES (?, ?, ?, ?)");
        $stmt->execute([trim($_POST['isbn']), trim($_POST['title']), trim($_POST['author']), $_POST['status']]);
        header("Location: library.php?msg=added");
        exit;
    } catch (PDOException $e) {
        $message = "Error: Book with this ISBN already exists.";
    }
}

// UPDATE BOOK
if (isset($_POST['update'])) {
    $stmt = $pdo->prepare("UPDATE books SET isbn=?, title=?, author=?, status=? WHERE id=?");
    $stmt->execute([trim($_POST['isbn']), trim($_POST['title']), trim($_POST['author']), $_POST['status'], $_POST['id']]);
    header("Location: library.php?msg=updated");
    exit;
}

// TOGGLE ISSUE / RETURN STATUS
if (isset($_GET['toggle'])) {
    $stmt = $pdo->prepare("UPDATE books SET status = IF(status='Available', 'Issued', 'Available') WHERE id=?");
    $stmt->execute([$_GET['toggle']]);
    header("Location: library.php?msg=status");
    exit;
}

// DELETE BOOK
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM books WHERE id=?");
    $stmt->execute([$_GET['delete']]);
    header("Location: library.php?msg=deleted");
    exit;
}

// FETCH FOR EDIT
$editBook = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM books WHERE id=?");
    $stmt->execute([$_GET['edit']]);
    $editBook = $stmt->fetch();
}

if (isset($_GET['msg'])) {
    $alerts = [
        'added' => 'Book added to library.',
        'updated' => 'Book details updated.',
        'status' => 'Book issue/return status updated.',
        'deleted' => 'Book removed from library.'
    ];
    $message = $alerts[$_GET['msg']] ?? '';
}

$books = $pdo->query("SELECT * FROM books ORDER BY id DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Library Management System</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background: #f4f6f9; color: #333; }
        .container { max-width: 950px; margin: auto; background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        h2 { margin-top: 0; color: #1e293b; }
        .alert { padding: 10px 15px; background: #dcfce7; color: #166534; border-radius: 5px; margin-bottom: 15px; }
        .form-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin-bottom: 15px; }
        input, select { padding: 10px; border: 1px solid #cbd5e1; border-radius: 5px; width: 100%; box-sizing: border-box; }
        button, .btn { padding: 10px 16px; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; font-size: 14px; display: inline-block; }
        .btn-primary { background: #2563eb; color: #fff; }
        .btn-cancel { background: #64748b; color: #fff; }
        .btn-toggle { background: #0d9488; color: #fff; padding: 5px 10px; font-size: 13px; }
        .btn-edit { background: #f59e0b; color: #fff; padding: 5px 10px; font-size: 13px; }
        .btn-del { background: #dc2626; color: #fff; padding: 5px 10px; font-size: 13px; }
        .badge-avail { background: #dcfce7; color: #166534; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold; }
        .badge-issued { background: #fee2e2; color: #991b1b; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; border-bottom: 1px solid #e2e8f0; text-align: left; }
        th { background: #f8fafc; }
    </style>
</head>
<body>
<div class="container">
    <h2>Library Management System</h2>

    <?php if ($message): ?>
        <div class="alert"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="POST">
        <input type="hidden" name="id" value="<?= $editBook['id'] ?? '' ?>">
        <div class="form-row">
            <input type="text" name="isbn" placeholder="ISBN (e.g., 978-0132350884)" value="<?= htmlspecialchars($editBook['isbn'] ?? '') ?>" required>
            <input type="text" name="title" placeholder="Book Title" value="<?= htmlspecialchars($editBook['title'] ?? '') ?>" required>
            <input type="text" name="author" placeholder="Author Name" value="<?= htmlspecialchars($editBook['author'] ?? '') ?>" required>
            <select name="status">
                <option value="Available" <?= (($editBook['status'] ?? '') === 'Available') ? 'selected' : '' ?>>Available</option>
                <option value="Issued" <?= (($editBook['status'] ?? '') === 'Issued') ? 'selected' : '' ?>>Issued</option>
            </select>
        </div>
        <button type="submit" class="btn-primary" name="<?= $editBook ? 'update' : 'add' ?>">
            <?= $editBook ? 'Update Book' : 'Add Book' ?>
        </button>
        <?php if ($editBook): ?>
            <a href="library.php" class="btn btn-cancel">Cancel</a>
        <?php endif; ?>
    </form>

    <table>
        <thead>
            <tr>
                <th>ISBN</th>
                <th>Title</th>
                <th>Author</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($books) === 0): ?>
                <tr><td colspan="5" style="text-align:center;">No books in the library yet.</td></tr>
            <?php endif; ?>
            <?php foreach ($books as $book): ?>
            <tr>
                <td><?= htmlspecialchars($book['isbn']) ?></td>
                <td><?= htmlspecialchars($book['title']) ?></td>
                <td><?= htmlspecialchars($book['author']) ?></td>
                <td>
                    <span class="<?= $book['status'] === 'Available' ? 'badge-avail' : 'badge-issued' ?>">
                        <?= htmlspecialchars($book['status']) ?>
                    </span>
                </td>
                <td>
                    <a href="?toggle=<?= $book['id'] ?>" class="btn-toggle">
                        <?= $book['status'] === 'Available' ? 'Issue Book' : 'Return Book' ?>
                    </a>
                    <a href="?edit=<?= $book['id'] ?>" class="btn-edit">Edit</a>
                    <a href="?delete=<?= $book['id'] ?>" class="btn-del" onclick="return confirm('Delete this book?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
