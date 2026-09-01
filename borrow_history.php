<?php
$pageTitle = 'CareShelf - Borrowing History';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/Model/app.php';

[$database, $conn] = getDatabase();
$userId = currentUserId($conn);
$status = $_GET['status'] ?? 'all';
$fromDate = $_GET['from_date'] ?? '';
$toDate = $_GET['to_date'] ?? '';

$sql = "SELECT bh.id,b.title,b.author,b.category,bh.borrow_date,bh.return_date,bh.fine, CASE WHEN bh.return_date IS NOT NULL THEN 'Returned' WHEN bh.due_date < CURDATE() THEN 'Overdue' ELSE 'Active' END AS status FROM borrow_history bh JOIN books b ON b.id=bh.book_id WHERE bh.user_id=?";
$params = [$userId]; $types = 'i';
if (in_array($status, ['returned','overdue','active'], true)) { $sql .= " AND LOWER(bh.status)=?"; $params[]=$status; $types.='s'; }
if ($fromDate !== '') { $sql .= " AND bh.borrow_date>=?"; $params[]=$fromDate; $types.='s'; }
if ($toDate !== '') { $sql .= " AND bh.borrow_date<=?"; $params[]=$toDate; $types.='s'; }
$sql .= " ORDER BY bh.borrow_date DESC, bh.id DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params); $stmt->execute(); $rows=$stmt->get_result()->fetch_all(MYSQLI_ASSOC); $stmt->close(); $database->close();
?>
<h1 class="page-title">Borrowing History</h1>
<form action="borrow_history.php" method="get"><table class="form-table"><tr>
<td class="label"><label for="status">Filter by Status:</label></td><td><select name="status" id="status"><option value="all" <?php echo $status==='all'?'selected':''; ?>>All</option><option value="returned" <?php echo $status==='returned'?'selected':''; ?>>Returned</option><option value="overdue" <?php echo $status==='overdue'?'selected':''; ?>>Overdue</option><option value="active" <?php echo $status==='active'?'selected':''; ?>>Active</option></select></td>
<td class="label"><label for="from_date">From Date:</label></td><td><input type="date" name="from_date" id="from_date" value="<?php echo h($fromDate); ?>"></td>
<td class="label"><label for="to_date">To Date:</label></td><td><input type="date" name="to_date" id="to_date" value="<?php echo h($toDate); ?>"></td><td><button class="btn" type="submit">Filter</button></td>
</tr></table></form>
<div class="table-wrap content-section"><table class="form-table book-table"><tr><th>#</th><th>Title</th><th>Author</th><th>Category</th><th>Borrow Date</th><th>Return Date</th><th>Fine (BDT)</th><th>Status</th></tr>
<?php if (!$rows): ?><tr><td colspan="8" style="text-align:center;">No database records found.</td></tr><?php else: foreach($rows as $i=>$row): ?><tr><td><?php echo $i+1; ?></td><td><?php echo h($row['title']); ?></td><td><?php echo h($row['author']); ?></td><td><?php echo h($row['category']); ?></td><td><?php echo h($row['borrow_date']); ?></td><td><?php echo h($row['return_date'] ?: '—'); ?></td><td><?php echo number_format((float)$row['fine'],2); ?></td><td><span class="badge <?php echo strtolower($row['status'])==='returned'?'badge-success':(strtolower($row['status'])==='overdue'?'badge-danger':'badge-warning'); ?>"><?php echo h($row['status']); ?></span></td></tr><?php endforeach; endif; ?>
</table></div>
<div class="link-row"><a href="view_my_books.php">View Currently Borrowed</a> | <a href="index.php">Back to menu</a></div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
