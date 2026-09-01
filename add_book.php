<?php
$pageTitle = 'CareShelf - Add Book';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/Model/app.php';

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    [$database, $conn] = getDatabase();

    $title = trim($_POST['title'] ?? '');
    $author = trim($_POST['author'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $copies = max(0, (int)($_POST['available_copies'] ?? 1));

    if ($title === '' || $author === '') {
        $error = 'Title and author are required.';
    } else {
        $stmt = $conn->prepare("INSERT INTO books (title, author, category, available_copies) VALUES (?,?,?,?)");
        $stmt->bind_param('sssi', $title, $author, $category, $copies);
        if ($stmt->execute()) {
            $message = 'Book saved successfully. Book ID: ' . $stmt->insert_id;
        } else {
            $error = 'Unable to save the book: ' . $conn->error;
        }
        $stmt->close();
    }
    $database->close();
}
?>

<h1 class="page-title">Add New Book</h1>

<?php if ($message): ?><div class="notice-box notice-success">&#10003; <?php echo h($message); ?></div><?php endif; ?>
<?php if ($error): ?><div class="notice-box notice-danger">&#9888; <?php echo h($error); ?></div><?php endif; ?>

<form method="post">
    <table class="form-table">
        <tr><td class="label"><label for="title">Title:</label></td><td><input id="title" name="title" required></td></tr>
        <tr><td class="label"><label for="author">Author:</label></td><td><input id="author" name="author" required></td></tr>
        <tr><td class="label"><label for="category">Category:</label></td><td><input id="category" name="category"></td></tr>
        <tr><td class="label"><label for="available_copies">Available Copies:</label></td><td><input type="number" id="available_copies" name="available_copies" value="1" min="0" required></td></tr>
    </table>
    <div class="button-row"><button class="btn" type="submit">Save Book</button><a class="btn btn-alt" href="search_book.php">Cancel</a></div>
</form>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
