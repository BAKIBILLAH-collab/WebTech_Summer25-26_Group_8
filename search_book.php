<?php
$pageTitle = 'CareShelf - Search Books';
require_once __DIR__ . '/includes/header.php';
?>

<h1 class="page-title">Search Books</h1>

<div class="notice-box notice-info">
    Search books by title, author or category from the library database.
</div>

<div class="search-panel">
    <input type="text" id="bookSearch" placeholder="Search by title, author or category..." autocomplete="off">
    <button type="button" class="btn" id="searchButton">Search</button>
</div>

<p id="ajaxStatus" class="ajax-status">Click Search to load books from the database.</p>
<div id="bookResults" class="ajax-results"></div>

<div class="button-row">
    <a class="btn" href="add_book.php">Add New Book</a>
</div>

<div class="link-row">
    <a href="index.php">Back to menu</a>
</div>

<script src="JS/ajax_books.js"></script>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
