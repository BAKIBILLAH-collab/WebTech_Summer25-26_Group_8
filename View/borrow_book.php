<?php

require_once __DIR__ . '/../Model/Session.php';
requireLogin();

$selectedBook = json_decode(base64_decode($_GET['book'] ?? '', true), true);
$selectedBook = is_array($selectedBook) ? $selectedBook : [];
$bookTitle = $selectedBook['title'] ?? 'PHP for Beginners';
$bookAuthor = $selectedBook['author'] ?? 'John Smith';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CareShelf - Borrow Book</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="wrapper">
        <div class="header-box">
            <h2>CareShelf Library Management System</h2>
        </div>

        <div class="topnav">
            <a href="index.php">Home</a>
            <a href="../Controller/LogoutController.php">Logout</a>
            <div class="membership-link">
                <a href="membership_required.php">Membership</a>
            </div>
        </div>

        <h1 class="page-title">Borrow Book</h1>

        <form action="membership_required.php" method="post">
            <table class="form-table">
                <tr>
                    <td class="label"><label>Book Title:</label></td>
                    <td><input type="text" name="book_title" value="<?= htmlspecialchars($bookTitle) ?>"></td>
                </tr>
                <tr>
                    <td class="label"><label>Author:</label></td>
                    <td><input type="text" name="author" value="<?= htmlspecialchars($bookAuthor) ?>"></td>
                </tr>
                <tr>
                    <td class="label"><label>Borrow Date:</label></td>
                    <td><input type="date" name="borrow_date" value="2026-08-16"></td>
                </tr>
                <tr>
                    <td class="label"><label>Due Date:</label></td>
                    <td><input type="date" name="due_date" value="2026-08-30"></td>
                </tr>
                <tr>
                    <td class="label"><label>Membership:</label></td>
                    <td><input type="text" name="membership" value="Active"></td>
                </tr>
            </table>

            <div class="button-row">
                <button class="btn" type="submit">Confirm Borrow</button>
                <button class="btn btn-alt" type="reset">Cancel</button>
            </div>
        </form>

        <div class="link-row">
            <a href="search_book.php">Back to Search</a> |
            <a href="index.php">Back to menu</a>
        </div>
    </div>
    <footer class="site-footer" role="contentinfo">
        <span>CareShelf Library Management System &copy; 2026</span>
        <span>Contact: +880 1XXX-XXXXXX</span>
        <a href="mailto:careshelf@example.com">careshelf@example.com</a>
    </footer>
</body>
</html>
