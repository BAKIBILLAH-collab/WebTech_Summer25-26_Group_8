<?php
$pageTitle = 'CareShelf - Renew Loan';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/Model/app.php';

[$database, $conn] = getDatabase();
$userId=currentUserId($conn);
$loanId=(int)($_GET['loan_id'] ?? $_POST['loan_id'] ?? 0);
$error=''; $success=''; $loan=null;

if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['confirm_renew'])) {
    $newDueDate=$_POST['new_due_date'] ?? '';
    $reason=trim($_POST['renewal_reason'] ?? '');
    $stmt=$conn->prepare("SELECT id,book_id,due_date,renewals_used,status FROM borrow_history WHERE id=? AND user_id=? AND return_date IS NULL LIMIT 1");
    $stmt->bind_param('ii',$loanId,$userId);$stmt->execute();$loan=$stmt->get_result()->fetch_assoc();$stmt->close();
    if(!$loan) $error='Loan record not found.';
    elseif((int)$loan['renewals_used']>=3) $error='Maximum 3 renewals have already been used.';
    elseif(strtotime($newDueDate)<=strtotime($loan['due_date'])) $error='New due date must be later than the current due date.';
    else {
        $stmt=$conn->prepare("UPDATE borrow_history SET due_date=?, renewals_used=renewals_used+1, status='Active' WHERE id=? AND user_id=?");
        $stmt->bind_param('sii',$newDueDate,$loanId,$userId);$stmt->execute();$stmt->close();
        $database->close(); header('Location: view_my_books.php?message='.urlencode('Loan renewed successfully and saved in borrow_history.')); exit;
    }
}

if(!$loan && $loanId>0){$stmt=$conn->prepare("SELECT bh.id,b.title,b.author,b.due_date,b.renewals_used,b.status FROM borrow_history bh JOIN books b ON b.id=bh.book_id WHERE bh.id=? AND bh.user_id=? AND bh.return_date IS NULL");$stmt->bind_param('ii',$loanId,$userId);$stmt->execute();$loan=$stmt->get_result()->fetch_assoc();$stmt->close();}
$database->close();
?>
<h1 class="page-title">Renew Loan</h1>
<?php if($error): ?><div class="notice-box notice-danger">&#9888; <?php echo h($error); ?></div><?php endif; ?>
<?php if(!$loan): ?><div class="notice-box notice-info">Select a borrowed book from <a href="view_my_books.php">My Books</a> first.</div><?php else: ?>
<div class="notice-box notice-info">Renewal updates the selected record in the <strong>borrow_history</strong> table. Maximum 3 renewals per book.</div>
<form method="post"><input type="hidden" name="loan_id" value="<?php echo (int)$loan['id']; ?>"><input type="hidden" name="confirm_renew" value="1">
<table class="form-table"><tr><td class="label">Book Title:</td><td><?php echo h($loan['title']); ?></td></tr><tr><td class="label">Author:</td><td><?php echo h($loan['author']); ?></td></tr><tr><td class="label">Current Due Date:</td><td><?php echo h($loan['due_date']); ?></td></tr><tr><td class="label"><label for="new_due_date">New Due Date:</label></td><td><input type="date" name="new_due_date" id="new_due_date" value="<?php echo h(date('Y-m-d',strtotime($loan['due_date'].' +14 days'))); ?>" required></td></tr><tr><td class="label">Renewals Used:</td><td><?php echo (int)$loan['renewals_used']; ?> / 3</td></tr><tr><td class="label"><label for="renewal_reason">Reason:</label></td><td><textarea name="renewal_reason" id="renewal_reason"></textarea></td></tr></table>
<div class="button-row"><button class="btn" type="submit">Confirm Renewal</button><a class="btn btn-alt" href="view_my_books.php">Cancel</a></div></form>
<?php endif; ?>
<div class="link-row"><a href="view_my_books.php">Back to My Books</a> | <a href="index.php">Back to menu</a></div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
