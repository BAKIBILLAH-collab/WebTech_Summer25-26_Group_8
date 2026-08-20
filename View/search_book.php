<?php

require_once __DIR__ . '/../Controller/BookController.php';

$search = $_GET['search'] ?? '';
$category = $_GET['category'] ?? 'All';
$books = (new BookController())->search($search, $category);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CareShelf - Search Book</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="wrapper">
        <div class="header-box">
            <h2>CareShelf Library Management System</h2>
        </div>

        <div class="topnav">
            <a href="index.php">Home</a>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
            <div class="membership-link">
                <a href="membership_required.php">Membership</a>
            </div>
        </div>

        <h1 class="page-title">Search Book</h1>

        <form action="search_book.php" method="get">
            <table class="form-table">
                <tr>
                    <td class="label"><label>Search:</label></td>
                    <td><input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Search by title or author"></td>
                    <td style="width: 180px;">
                        <select name="category" aria-label="Book category">
                            <?php foreach (['All', 'Technology', 'Science', 'History', 'Novel'] as $categoryOption): ?>
                                <option value="<?= $categoryOption ?>" <?= $category === $categoryOption ? 'selected' : '' ?>><?= $categoryOption ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td style="width: 150px;"><button class="btn" type="submit">Search</button></td>
                </tr>
            </table>
        </form>

        <form action="borrow_book.php" method="get">
            <table class="form-table book-table">
                <tr>
                    <th>Select</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Category</th>
                    <th>Available Copies</th>
                </tr>
                <?php foreach ($books as $book): ?>
                    <tr>
                        <td>
                            <input class="book-select" type="radio" name="book" value="<?= htmlspecialchars(base64_encode(json_encode($book))) ?>" required>
                        </td>
                        <td><?= htmlspecialchars($book['title']) ?></td>
                        <td><?= htmlspecialchars($book['author']) ?></td>
                        <td><?= htmlspecialchars($book['category']) ?></td>
                        <td><?= htmlspecialchars((string) $book['available_copies']) ?></td>
                    </tr>
                <?php endforeach; ?>
                <?php if ($books === []): ?>
                    <tr>
                        <td colspan="5" class="empty-state">No books matched your search.</td>
                    </tr>
                <?php endif; ?>
            </table>

            <div class="button-row">
                <button class="btn" type="submit" <?= $books === [] ? 'disabled' : '' ?>>Borrow Selected Book</button>
            </div>
        </form>

        <div class="link-row">
            <a href="login.php">Back to Login</a> |
            <a href="index.php">Back to menu</a>
        </div>
    </div>
</body>
</html>
