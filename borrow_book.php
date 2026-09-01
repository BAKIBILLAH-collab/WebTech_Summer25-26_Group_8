<?php
$pageTitle='CareShelf - Borrow Book';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/Model/app.php';
[$database,$conn]=getDatabase();
$userId=currentUserId($conn);
$bookId=(int)($_GET['book_id'] ?? $_POST['book_id'] ?? 0);
$message=''; $error='';

if($_SERVER['REQUEST_METHOD']==='POST'){
    $borrowDate=$_POST['borrow_date'] ?? date('Y-m-d');
    $dueDate=date('Y-m-d',strtotime($borrowDate.' +14 days'));

    $stmt=$conn->prepare("SELECT id,title,available_copies FROM books WHERE id=? LIMIT 1");
    $stmt->bind_param('i',$bookId); $stmt->execute();
    $book=$stmt->get_result()->fetch_assoc(); $stmt->close();

    $stmt=$conn->prepare("SELECT COUNT(*) AS c FROM borrow_history WHERE user_id=? AND return_date IS NULL");
    $stmt->bind_param('i',$userId); $stmt->execute();
    $count=(int)$stmt->get_result()->fetch_assoc()['c']; $stmt->close();

    if(!$book) $error='Book not found.';
    elseif((int)$book['available_copies']<=0) $error='This book is currently unavailable.';
    elseif($count>=7) $error='Borrowing limit reached (7 books).';
    else {
        $conn->begin_transaction();
        try {
            $stmt=$conn->prepare("UPDATE books SET available_copies=available_copies-1 WHERE id=? AND available_copies>0");
            $stmt->bind_param('i',$bookId); $stmt->execute();
            if($stmt->affected_rows!==1) throw new Exception('Book is no longer available.');
            $stmt->close();

            $stmt=$conn->prepare("INSERT INTO borrow_history (user_id,book_id,borrow_date,due_date,status,renewals_used,fine) VALUES (?,?,?,?,?,?,?)");
            $status='Active'; $renewals=0; $fine=0.00;
            $stmt->bind_param('iisssid',$userId,$bookId,$borrowDate,$dueDate,$status,$renewals,$fine);
            if(!$stmt->execute()) throw new Exception('Could not save borrowing record.');
            $stmt->close();

            $conn->commit();
            $database->close();
            header('Location: view_my_books.php?message='.urlencode('Book borrowed successfully. Record saved in borrow_history and available_copies updated in books.'));
            exit;
        } catch (Throwable $e) {
            $conn->rollback();
            $error=$e->getMessage();
        }
    }
}

$book=null;
if($bookId){
    $stmt=$conn->prepare("SELECT id,title,author,category,available_copies FROM books WHERE id=?");
    $stmt->bind_param('i',$bookId); $stmt->execute();
    $book=$stmt->get_result()->fetch_assoc(); $stmt->close();
}
$database->close();
?>
<h1 class="page-title">Borrow Book</h1>
<?php if($error): ?><div class="notice-box notice-danger">&#9888; <?php echo h($error); ?></div><?php endif; ?>
<?php if(!$book): ?><div class="notice-box notice-info">Select a book from <a href="search_book.php">Search Books</a>.</div><?php else: ?>
<div class="notice-box notice-info">This action saves a record in <strong>borrow_history</strong> and decreases <strong>books.available_copies</strong>.</div>
<form method="post">
<input type="hidden" name="book_id" value="<?php echo (int)$book['id']; ?>">
<table class="form-table">
<tr><td class="label">Title:</td><td><?php echo h($book['title']); ?></td></tr>
<tr><td class="label">Author:</td><td><?php echo h($book['author']); ?></td></tr>
<tr><td class="label">Category:</td><td><?php echo h($book['category']); ?></td></tr>
<tr><td class="label">Available Copies:</td><td><?php echo (int)$book['available_copies']; ?></td></tr>
<tr><td class="label"><label for="borrow_date">Borrow Date:</label></td><td><input type="date" id="borrow_date" name="borrow_date" value="<?php echo date('Y-m-d'); ?>" required></td></tr>
</table>
<div class="button-row"><button class="btn" type="submit">Confirm Borrow</button><a class="btn btn-alt" href="search_book.php">Cancel</a></div>
</form>
<?php endif; ?>
<div class="link-row"><a href="search_book.php">Back to Search</a> | <a href="index.php">Back to menu</a></div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
