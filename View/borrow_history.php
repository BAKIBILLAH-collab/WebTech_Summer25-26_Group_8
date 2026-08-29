<?php
$pageTitle = 'CareShelf - Borrowing History';
require_once __DIR__ . '/../Model/Session.php';
requireLogin();
require_once __DIR__ . '/../Model/LoanModel.php';

$allowedStatuses = ['all', 'returned', 'overdue', 'active'];
$status = in_array($_GET['status'] ?? 'all', $allowedStatuses, true) ? $_GET['status'] : 'all';
$fromDate = trim($_GET['from_date'] ?? '');
$toDate = trim($_GET['to_date'] ?? '');
$isDate = static fn (string $date): bool => $date === '' || DateTime::createFromFormat('Y-m-d', $date) !== false;
$fromDate = $isDate($fromDate) ? ($fromDate !== '' ? $fromDate : null) : null;
$toDate = $isDate($toDate) ? ($toDate !== '' ? $toDate : null) : null;
$history = (new LoanModel())->getHistory((int) ($_SESSION['user_id'] ?? 0), $status, $fromDate, $toDate);
?>
<?php require_once __DIR__ . '/includes/header.php'; ?>

<h1 class="page-title">Borrowing History</h1>
<form action="borrow_history.php" method="get">
    <table class="form-table"><tr>
        <td class="label"><label for="status">Filter by Status:</label></td><td><select name="status" id="status">
            <?php foreach ($allowedStatuses as $option): ?><option value="<?= $option ?>" <?= $status === $option ? 'selected' : '' ?>><?= ucfirst($option) ?></option><?php endforeach; ?>
        </select></td>
        <td class="label"><label for="from_date">From Date:</label></td>
        <td><input type="date" name="from_date" id="from_date" value="<?= htmlspecialchars((string) $fromDate, ENT_QUOTES, 'UTF-8') ?>"></td>
        <td class="label"><label for="to_date">To Date:</label></td>
        <td><input type="date" name="to_date" id="to_date" value="<?= htmlspecialchars((string) $toDate, ENT_QUOTES, 'UTF-8') ?>"></td>
        <td><button class="btn" type="submit">Filter</button></td>
    </tr></table>
</form>

<div class="table-wrap content-section"><table class="form-table book-table">
    <tr><th>#</th><th>Title</th><th>Author</th><th>Category</th><th>Borrow Date</th><th>Return Date</th><th>Fine (BDT)</th><th>Status</th></tr>
    <?php foreach ($history as $number => $loan): ?>
        <?php $loanStatus = ucfirst((string) $loan['status']); ?>
        <tr><td><?= $number + 1 ?></td>
        <td><?= htmlspecialchars($loan['title'], ENT_QUOTES, 'UTF-8') ?></td>
        <td><?= htmlspecialchars($loan['author'], ENT_QUOTES, 'UTF-8') ?></td>
        <td><?= htmlspecialchars($loan['category'], ENT_QUOTES, 'UTF-8') ?></td>
        <td><?= htmlspecialchars($loan['borrow_date'], ENT_QUOTES, 'UTF-8') ?></td>
        <td><?= htmlspecialchars((string) ($loan['return_date'] ?? '-'), ENT_QUOTES, 'UTF-8') ?></td>
        <td><?= number_format((float) $loan['fine'], 2) ?></td>
        <td><span class="badge <?= $loanStatus === 'Returned' ? 'badge-success' : ($loanStatus === 'Overdue' ? 'badge-danger' : 'badge-warning') ?>"><?= $loanStatus ?></span></td>
    </tr>
    <?php endforeach; ?>
    <?php if ($history === []): ?><tr><td colspan="8" class="empty-state">No borrowing history matched your filters.</td></tr><?php endif; ?>
</table></div>

<div class="link-row"><a href="view_my_books.php">View Currently Borrowed</a> | <a href="index.php">Back to menu</a></div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
