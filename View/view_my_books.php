<?php
$pageTitle = 'CareShelf - View My Books';
require_once __DIR__ . '/../Model/Session.php';
requireLogin();
require_once __DIR__ . '/../Model/LoanModel.php';
require_once __DIR__ . '/../Model/UserModel.php';

$customerId = (int) ($_SESSION['user_id'] ?? 0);
$loans = (new LoanModel())->getCurrentLoans($customerId);
$customer = (new UserModel())->getCustomerById($customerId) ?? [];
$selectedLoanId = (int) ($_GET['loan_id'] ?? ($loans[0]['loan_id'] ?? 0));
$message = isset($_GET['borrowed']) ? 'Book borrowed successfully.' : '';
if (isset($_GET['renewed'])) {
    $message = 'Loan renewed successfully.';
} elseif (isset($_GET['returned'])) {
    $message = 'Book returned successfully.';
}
?>
<?php require_once __DIR__ . '/includes/header.php'; ?>

<h1 class="page-title">View My Books</h1>
<?php if ($message !== ''): ?><div class="notice-box notice-success"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></div><?php endif; ?>

<div class="summary-strip">
    <div class="summary-item"><span class="summary-value"><?= count($loans) ?></span><span class="summary-label">Books Borrowed</span></div>
    <div class="summary-item"><span class="summary-value"><?= max(0, 7 - count($loans)) ?></span><span class="summary-label">Slots Remaining</span></div>
    <div class="summary-item"><span class="summary-value"><?= htmlspecialchars(ucfirst((string) ($customer['membership_status'] ?? 'Unknown')), ENT_QUOTES, 'UTF-8') ?></span><span class="summary-label">Membership</span></div>
    <div class="summary-item"><span class="summary-value"><?= htmlspecialchars((string) ($customer['membership_expiry_date'] ?? 'Not available'), ENT_QUOTES, 'UTF-8') ?></span><span class="summary-label">Expiry Date</span></div>
</div>

<form action="view_my_books.php" method="get">
    <div class="table-wrap">
        <table class="form-table book-table">
            <tr><th>Select</th><th>Title</th><th>Author</th><th>Borrow Date</th><th>Due Date</th><th>Renewals</th><th>Status</th></tr>
            <?php foreach ($loans as $loan): ?>
                <?php $status = strtolower((string) $loan['status']); ?>
                <tr>
                    <td><input class="book-select" type="radio" name="loan_id" value="<?= (int) $loan['loan_id'] ?>" <?= (int) $loan['loan_id'] === $selectedLoanId ? 'checked' : '' ?> required></td>
                    <td><?= htmlspecialchars($loan['title'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($loan['author'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($loan['borrow_date'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($loan['due_date'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= (int) $loan['renewed_count'] ?> / 3</td>
                    <td><span class="badge <?= $status === 'overdue' ? 'badge-danger' : 'badge-success' ?>"><?= htmlspecialchars(ucfirst($status), ENT_QUOTES, 'UTF-8') ?></span></td>
                </tr>
            <?php endforeach; ?>
            <?php if ($loans === []): ?><tr><td colspan="7" class="empty-state">You have no active borrowed books.</td></tr><?php endif; ?>
        </table>
    </div>
    <?php if ($loans !== []): ?><div class="button-row"><button class="btn" type="submit" formaction="renew_loan.php">Renew Selected Loan</button><button class="btn btn-alt" type="submit" formaction="return_book.php">Return Selected Book</button></div><?php endif; ?>
</form>

<div class="link-row"><a href="borrow_history.php">View Borrowing History</a> | <a href="search_book.php">Search Books</a> | <a href="index.php">Back to menu</a></div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
