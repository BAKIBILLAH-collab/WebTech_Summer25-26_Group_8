<?php
$pageTitle = 'CareShelf - Overdue / Limit Alert';
require_once __DIR__ . '/includes/header.php';
?>

<h1 class="page-title">Overdue / Limit Alert</h1>

<div class="notice-box notice-danger">
    &#9888; Action Required: You cannot borrow or renew books at this time.
    Please resolve the issues below.
</div>

<div class="alert-section">
    <h3 class="alert-section-title">Overdue Books</h3>

    <div class="notice-box notice-info" style="text-align:left; font-weight:normal;">
        &#8505; Fine Rule:
        <strong>BDT 10/day</strong> for first 7 days overdue.
        After 7 days:
        <strong>BDT 20/day</strong> (double fine applies automatically).
    </div>

    <div class="table-wrap">
        <table class="form-table book-table">
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Due Date</th>
                <th>Days Overdue</th>
                <th>Fine Calculation</th>
                <th>Fine (BDT)</th>
            </tr>
            <tr>
                <td>Introduction to Web Technology</td>
                <td>Deitel &amp; Deitel</td>
                <td>2026-08-05</td>
                <td class="overdue-days">17 days</td>
                <td class="small-text">7&times;10 + 10&times;20</td>
                <td class="fine-amount">270.00</td>
            </tr>
            <tr>
                <td>Database Management Systems</td>
                <td>Ramakrishnan &amp; Gehrke</td>
                <td>2026-08-15</td>
                <td class="overdue-days">7 days</td>
                <td class="small-text">7&times;10</td>
                <td class="fine-amount">70.00</td>
            </tr>
        </table>
    </div>
</div>

<div class="alert-section">
    <h3 class="alert-section-title">Borrowing Limit Status</h3>

    <table class="form-table">
        <tr>
            <td class="label"><strong>Books Currently Borrowed:</strong></td>
            <td><span class="badge badge-danger">7 / 7 (Limit Reached)</span></td>
        </tr>
        <tr>
            <td class="label"><strong>Total Fine Due:</strong></td>
            <td><span class="fine-amount">BDT 340.00</span></td>
        </tr>
    </table>
</div>

<div class="button-row">
    <a href="return_book.php" class="btn">Return a Book</a>
    <a href="pay_membership.php" class="btn btn-warning">Pay Fine &amp; Renew</a>
</div>

<div class="link-row">
    <a href="view_my_books.php">View My Books</a> |
    <a href="index.php">Back to menu</a>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
