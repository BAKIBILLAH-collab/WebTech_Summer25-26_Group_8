<?php
$pageTitle = 'CareShelf - Return Book';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/Model/app.php';

[$database,$conn]=getDatabase(); $userId=currentUserId($conn); $loanId=(int)($_GET['loan_id'] ?? $_POST['loan_id'] ?? 0); $error=''; $loan=null;

if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['confirm_return'])){
    $returnDate=$_POST['return_date'] ?? date('Y-m-d'); $condition=$_POST['condition'] ?? 'good';
    $stmt=$conn->prepare("SELECT bh.id,bh.book_id,bh.due_date,bh.return_date FROM borrow_history bh WHERE bh.id=? AND bh.user_id=? AND bh.return_date IS NULL LIMIT 1");$stmt->bind_param('ii',$loanId,$userId);$stmt->execute();$loan=$stmt->get_result()->fetch_assoc();$stmt->close();
    if(!$loan) $error='Loan record not found.'; else {
        $daysOverdue=max(0,(int)((strtotime($returnDate)-strtotime($loan['due_date']))/86400));
        $fine=$daysOverdue<=7?$daysOverdue*10:(7*10)+(($daysOverdue-7)*20);
        if($condition==='damaged') $fine+=200;
        if($condition==='lost') $fine+=500;
        $status='Returned';
        $conn->begin_transaction();
        try {
            $stmt=$conn->prepare("UPDATE borrow_history SET return_date=?, fine=?, status=? WHERE id=? AND user_id=? AND return_date IS NULL");
            $stmt->bind_param('sdsii',$returnDate,$fine,$status,$loanId,$userId);
            if(!$stmt->execute() || $stmt->affected_rows!==1) throw new Exception('Could not update the borrow_history record.');
            $stmt->close();
            if($condition !== 'lost') {
                $stmt=$conn->prepare("UPDATE books SET available_copies=available_copies+1 WHERE id=?");
                $stmt->bind_param('i',$loan['book_id']);
                if(!$stmt->execute()) throw new Exception('Could not update the book inventory.');
                $stmt->close();
            }
            $conn->commit();
            $database->close(); header('Location: view_my_books.php?message='.urlencode('Book returned and the borrow_history/books records were updated.')); exit;
        } catch(Throwable $e) {
            $conn->rollback();
            $error=$e->getMessage();
        }
    }
}
if(!$loan && $loanId>0){$stmt=$conn->prepare("SELECT bh.id,bh.book_id,b.title,b.author,bh.borrow_date,bh.due_date FROM borrow_history bh JOIN books b ON b.id=bh.book_id WHERE bh.id=? AND bh.user_id=? AND bh.return_date IS NULL");$stmt->bind_param('ii',$loanId,$userId);$stmt->execute();$loan=$stmt->get_result()->fetch_assoc();$stmt->close();}
$database->close();
?>
<h1 class="page-title">Return Book</h1>
<?php if($error): ?><div class="notice-box notice-danger">&#9888; <?php echo h($error); ?></div><?php endif; ?>
<?php if(!$loan): ?><div class="notice-box notice-info">Select a borrowed book from <a href="view_my_books.php">My Books</a> first.</div><?php else: ?>
<form method="post"><input type="hidden" name="loan_id" value="<?php echo (int)$loan['id']; ?>"><input type="hidden" name="confirm_return" value="1"><table class="form-table">
<tr><td class="label">Book Title:</td><td><?php echo h($loan['title']); ?></td></tr><tr><td class="label">Author:</td><td><?php echo h($loan['author']); ?></td></tr><tr><td class="label">Borrow Date:</td><td><?php echo h($loan['borrow_date']); ?></td></tr><tr><td class="label">Due Date:</td><td><?php echo h($loan['due_date']); ?></td></tr>
<tr><td class="label"><label for="return_date">Return Date:</label></td><td><input type="date" name="return_date" id="return_date" value="<?php echo date('Y-m-d'); ?>" required></td></tr>
<tr><td class="label"><label for="conditionSelect">Book Condition:</label></td><td><select name="condition" id="conditionSelect"><option value="good">Good</option><option value="damaged">Damaged — Extra BDT 200</option><option value="lost">Lost — BDT 500 replacement charge</option></select></td></tr>
</table><div class="notice-box notice-info">Fine is calculated from the selected return date: BDT 10/day for the first 7 overdue days, then BDT 20/day.</div><div class="button-row"><button class="btn" type="submit">Confirm Return</button><a class="btn btn-alt" href="view_my_books.php">Cancel</a></div></form>
<?php endif; ?>
<div class="link-row"><a href="view_my_books.php">Back to My Books</a> | <a href="index.php">Back to menu</a></div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
