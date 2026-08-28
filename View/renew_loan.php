<?php
$pageTitle = 'CareShelf - Renew Loan';
require_once __DIR__ . '/../Model/Session.php';
requireLogin();
require_once __DIR__ . '/../Model/LoanModel.php';

$customerId = (int) ($_SESSION['user_id'] ?? 0);
$loanId = (int) ($_POST['loan_id'] ?? $_GET['loan_id'] ?? 0);
$loanModel = new LoanModel();
$loan = $loanModel->getLoanById($customerId, $loanId);
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $loan) {
    $newDueDate = $_POST['new_due_date'] ?? '';
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $newDueDate) || $newDueDate <= $loan['due_date']) {
        $message = 'The new due date must be later than the current due date.';
    } elseif ($loanModel->renew($customerId, $loanId, $newDueDate)) {
        header('Location: view_my_books.php?renewed=1');
        exit;
    } else {
        $message = 'This loan cannot be renewed. The maximum of three renewals may have been reached.';
    }
}
?>
<?php require_once __DIR__ . '/includes/header.php'; ?>

<h1 class="page-title">Renew Loan</h1>

<?php if ($message !== ''): ?><div class="notice-box notice-danger"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></div><?php endif; ?>

<?php if ($loan): ?>
    <div class="notice-box notice-info">Choose a date later than the current due date.</div>
    <form action="renew_loan.php" method="post">
        <input type="hidden" name="loan_id" value="<?= (int) $loan['loan_id'] ?>">
        <table class="form-table">
            <tr><td class="label">Book Title:</td><td><?= htmlspecialchars($loan['title'], ENT_QUOTES, 'UTF-8') ?></td></tr>
            <tr><td class="label">Author:</td><td><?= htmlspecialchars($loan['author'], ENT_QUOTES, 'UTF-8') ?></td></tr>
            <tr><td class="label">Current Due Date:</td><td><?= htmlspecialchars($loan['due_date'], ENT_QUOTES, 'UTF-8') ?></td></tr>
            <tr><td class="label">Renewals Used:</td><td><?= (int) $loan['renewed_count'] ?> / 3</td></tr>
            <tr><td class="label"><label for="new_due_date">New Due Date:</label></td><td><input type="date" name="new_due_date" id="new_due_date" min="<?= htmlspecialchars($loan['due_date'], ENT_QUOTES, 'UTF-8') ?>" required></td></tr>
        </table>
        <div class="button-row"><button class="btn" type="submit">Confirm Renewal</button><a class="btn btn-alt" href="view_my_books.php">Cancel</a></div>
    </form>
<?php else: ?>
    <div class="notice-box notice-danger">Select a valid active loan from My Books first.</div>
<?php endif; ?>

<div class="link-row"><a href="view_my_books.php">Back to My Books</a> | <a href="index.php">Back to menu</a></div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
