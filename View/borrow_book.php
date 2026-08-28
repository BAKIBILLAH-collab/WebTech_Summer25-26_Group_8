<?php

require_once __DIR__ . '/../Model/Session.php';
requireLogin();
require_once __DIR__ . '/../Model/BookModel.php';
require_once __DIR__ . '/../Model/LoanModel.php';
require_once __DIR__ . '/../Model/UserModel.php';

$customerId = (int) ($_SESSION['user_id'] ?? 0);
$bookId = (int) ($_GET['book_id'] ?? 0);
$book = $bookId > 0 ? (new BookModel())->getBookById($bookId) : null;
$customer = $customerId > 0 ? (new UserModel())->getCustomerById($customerId) : null;
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $borrowDate = $_POST['borrow_date'] ?? date('Y-m-d');
    $dueDate = $_POST['due_date'] ?? date('Y-m-d', strtotime('+14 days'));
    $isActive = $customer !== null
        && strtolower((string) $customer['membership_status']) === 'active'
        && (empty($customer['membership_expiry_date']) || $customer['membership_expiry_date'] >= $borrowDate);

    if (!$book || !$isActive || $dueDate <= $borrowDate) {
        $message = 'Borrowing is unavailable. Check your membership and selected book.';
    } elseif ((new LoanModel())->borrow($customerId, $bookId, $borrowDate, $dueDate)) {
        header('Location: view_my_books.php?borrowed=1');
        exit;
    } else {
        $message = 'This book is no longer available.';
    }
}

$bookTitle = $book['title'] ?? 'Book not found';
$bookAuthor = $book['author'] ?? 'Select a book from search';
$isActive = $customer !== null
    && strtolower((string) $customer['membership_status']) === 'active'
    && (empty($customer['membership_expiry_date']) || $customer['membership_expiry_date'] >= date('Y-m-d'));
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

        <?php if ($message !== ''): ?>
            <div class="notice-box notice-danger"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>

        <?php if ($book && $isActive): ?>
        <form action="borrow_book.php?book_id=<?= $bookId ?>" method="post" onsubmit="return validateBorrowForm();">
            <table class="form-table">
                <tr>
                    <td class="label"><label>Book Title:</label></td>
                    <td><input type="text" name="book_title" value="<?= htmlspecialchars($bookTitle) ?>" required></td>
                </tr>
                <tr>
                    <td class="label"><label>Author:</label></td>
                    <td><input type="text" name="author" value="<?= htmlspecialchars($bookAuthor) ?>" required></td>
                </tr>
                <tr>
                    <td class="label"><label>Borrow Date:</label></td>
                    <td><input type="date" name="borrow_date" value="<?= date('Y-m-d') ?>" required></td>
                </tr>
                <tr>
                    <td class="label"><label>Due Date:</label></td>
                    <td><input type="date" name="due_date" value="<?= date('Y-m-d', strtotime('+14 days')) ?>" required></td>
                </tr>
                <tr>
                    <td class="label"><label>Membership:</label></td>
                    <td><input type="text" name="membership" value="Active" readonly></td>
                </tr>
            </table>

            <div class="button-row">
                <button class="btn" type="submit">Confirm Borrow</button>
                <button class="btn btn-alt" type="reset">Cancel</button>
            </div>
        </form>
        <?php elseif ($message === ''): ?>
            <div class="notice-box notice-danger">An active membership and an available book are required to borrow.</div>
        <?php endif; ?>

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
