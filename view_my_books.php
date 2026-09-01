<?php
$pageTitle = 'CareShelf - View My Books';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/Model/app.php';

[$database, $conn] = getDatabase();
$userId = currentUserId($conn);
$message = '';

if (isset($_GET['message'])) $message = $_GET['message'];

$stmt = $conn->prepare("SELECT bh.id, bh.book_id, b.title, b.author, bh.borrow_date, bh.due_date, bh.renewals_used, CASE WHEN bh.due_date < CURDATE() THEN 'Overdue' ELSE 'Active' END AS status, bh.fine FROM borrow_history bh JOIN books b ON b.id=bh.book_id WHERE bh.user_id=? AND bh.return_date IS NULL ORDER BY bh.due_date ASC");
$stmt->bind_param('i', $userId); $stmt->execute();
$loans = $stmt->get_result()->fetch_all(MYSQLI_ASSOC); $stmt->close();

$stmt = $conn->prepare("SELECT COUNT(*) AS c, COALESCE(SUM(fine),0) AS fine FROM borrow_history WHERE user_id=? AND return_date IS NULL");
$stmt->bind_param('i', $userId); $stmt->execute(); $summary = $stmt->get_result()->fetch_assoc(); $stmt->close();

$stmt = $conn->prepare("SELECT membership_status, expiry_date FROM users WHERE id=?");
$stmt->bind_param('i', $userId); $stmt->execute(); $user = $stmt->get_result()->fetch_assoc() ?: []; $stmt->close();
$database->close();
?>

<h1 class="page-title">View My Books</h1>
<?php if ($message): ?><div class="notice-box notice-success">&#10003; <?php echo h($message); ?></div><?php endif; ?>

<div class="summary-strip">
    <div class="summary-item"><span class="summary-value"><?php echo (int)$summary['c']; ?></span><span class="summary-label">Books Borrowed</span></div>
    <div class="summary-item"><span class="summary-value"><?php echo max(0, 7-(int)$summary['c']); ?></span><span class="summary-label">Slots Remaining</span></div>
    <div class="summary-item"><span class="summary-value"><?php echo h($user['membership_status'] ?? 'Inactive'); ?></span><span class="summary-label">Membership</span></div>
    <div class="summary-item"><span class="summary-value"><?php echo h($user['expiry_date'] ?? 'Not set'); ?></span><span class="summary-label">Expiry Date</span></div>
    <div class="summary-item summary-item-fine"><span class="summary-value fine-amount">BDT <?php echo number_format((float)$summary['fine'],2); ?></span><span class="summary-label">Total Fine Due</span></div>
</div>

<div class="table-wrap">
<table class="form-table book-table">
<tr><th>Select</th><th>Title</th><th>Author</th><th>Borrow Date</th><th>Due Date</th><th>Renewals</th><th>Status</th></tr>
<?php if (!$loans): ?>
<tr><td colspan="7" style="text-align:center;">No active borrowed books found. Borrow records can be added to the borrow_history table.</td></tr>
<?php else: foreach ($loans as $loan): ?>
<tr>
<td><input class="book-select" type="radio" name="loan_id" value="<?php echo (int)$loan['id']; ?>" form="loanActions" required></td>
<td><?php echo h($loan['title']); ?></td><td><?php echo h($loan['author']); ?></td>
<td><?php echo h($loan['borrow_date']); ?></td><td><?php echo h($loan['due_date']); ?></td>
<td><?php echo (int)$loan['renewals_used']; ?> / 3</td>
<td><span class="badge <?php echo $loan['status']==='Overdue'?'badge-danger':'badge-success'; ?>"><?php echo h($loan['status']); ?></span></td>
</tr>
<?php endforeach; endif; ?>
</table>
</div>

<form id="loanActions" method="get" action="renew_loan.php"></form>
<div class="button-row">
    <button class="btn" type="submit" form="loanActions" name="action" value="renew">Renew Selected Loan</button>
    <button class="btn btn-alt" type="submit" form="loanActions" formaction="return_book.php" name="action" value="return">Return Selected Book</button>
</div>

<div class="link-row"><a href="borrow_history.php">View Borrowing History</a> | <a href="search_book.php">Search Books</a> | <a href="index.php">Back to menu</a></div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
