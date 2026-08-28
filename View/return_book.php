<?php
$pageTitle = 'CareShelf - Return Book';
require_once __DIR__ . '/../Model/Session.php';
requireLogin();
require_once __DIR__ . '/../Model/LoanModel.php';

$customerId = (int) ($_SESSION['user_id'] ?? 0);
$loanId = (int) ($_POST['loan_id'] ?? $_GET['loan_id'] ?? 0);
$loanModel = new LoanModel();
$loan = $loanModel->getLoanById($customerId, $loanId);
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $loan) {
    $returnDate = $_POST['return_date'] ?? date('Y-m-d');
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $returnDate) || $returnDate < $loan['borrow_date']) {
        $message = 'Enter a valid return date.';
    } elseif ($loanModel->returnBook($customerId, $loanId, $returnDate)) {
        header('Location: view_my_books.php?returned=1');
        exit;
    } else {
        $message = 'This loan has already been returned.';
    }
}
?>
<?php require_once __DIR__ . '/includes/header.php'; ?>

<h1 class="page-title">Return Book</h1>

<?php if ($message !== ''): ?><div class="notice-box notice-danger"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></div><?php endif; ?>

<?php if ($loan): ?>
    <form action="return_book.php" method="post">
        <input type="hidden" name="loan_id" value="<?= (int) $loan['loan_id'] ?>">
        <table class="form-table">
            <tr><td class="label">Book Title:</td><td><?= htmlspecialchars($loan['title'], ENT_QUOTES, 'UTF-8') ?></td></tr>
            <tr><td class="label">Author:</td><td><?= htmlspecialchars($loan['author'], ENT_QUOTES, 'UTF-8') ?></td></tr>
            <tr><td class="label">Borrow Date:</td><td><?= htmlspecialchars($loan['borrow_date'], ENT_QUOTES, 'UTF-8') ?></td></tr>
            <tr><td class="label">Due Date:</td><td><?= htmlspecialchars($loan['due_date'], ENT_QUOTES, 'UTF-8') ?></td></tr>
            <tr><td class="label"><label for="return_date">Return Date:</label></td><td><input type="date" name="return_date" id="return_date" value="<?= date('Y-m-d') ?>" min="<?= htmlspecialchars($loan['borrow_date'], ENT_QUOTES, 'UTF-8') ?>" required></td></tr>
        </table>
        <div class="button-row"><button class="btn" type="submit">Confirm Return</button><a class="btn btn-alt" href="view_my_books.php">Cancel</a></div>
    </form>
<?php else: ?>
    <div class="notice-box notice-danger">Select a valid active loan from My Books first.</div>
<?php endif; ?>

<div class="link-row"><a href="view_my_books.php">Back to My Books</a> | <a href="index.php">Back to menu</a></div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
