<?php

$pageTitle = 'CareShelf - Home';

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/Model/app.php';

[$database, $conn] = getDatabase();
$userId = currentUserId($conn);

$quick = ['membership_status'=>'Inactive','expiry_date'=>null,'borrowed'=>0,'fine'=>0];
$stmt = $conn->prepare("SELECT membership_status, expiry_date FROM users WHERE id=?");
$stmt->bind_param('i', $userId); $stmt->execute();
$userQuick = $stmt->get_result()->fetch_assoc(); $stmt->close();
if ($userQuick) { $quick['membership_status']=$userQuick['membership_status']; $quick['expiry_date']=$userQuick['expiry_date']; }
$stmt = $conn->prepare("SELECT COUNT(*) AS borrowed, COALESCE(SUM(fine),0) AS fine FROM borrow_history WHERE user_id=? AND return_date IS NULL");
$stmt->bind_param('i', $userId); $stmt->execute();
$q = $stmt->get_result()->fetch_assoc(); $stmt->close();
$quick['borrowed']=(int)$q['borrowed']; $quick['fine']=(float)$q['fine'];
$database->close();

?>

<section class="hero-section">

    <div class="hero-content">

        <span class="hero-tag">
            Group 8 Library Project
        </span>

        <h1>
            Welcome to CareShelf
        </h1>

        <p>
            A simple and organized library management system
            for borrowing, returning and managing books.
        </p>

        <div class="button-row hero-buttons">

            <a href="view_my_books.php" class="btn">
                View My Books
            </a>

            <a href="borrow_history.php" class="btn btn-alt">
                Borrowing History
            </a>

        </div>

    </div>

</section>

<section class="dashboard-section">

    <h2 class="section-title">
        Library Services
    </h2>

    <div class="card-grid">

        <div class="card">

            <div class="card-symbol">📚</div>

            <h3>My Books</h3>

            <p>
                View your currently borrowed books,
                due dates and renewal status.
            </p>

            <a href="view_my_books.php">
                View Books
            </a>

        </div>

        <div class="card">

            <div class="card-symbol">↩</div>

            <h3>Return Book</h3>

            <p>
                Return a borrowed book and
                check applicable overdue fines.
            </p>

            <a href="return_book.php">
                Return Book
            </a>

        </div>

        <div class="card">

            <div class="card-symbol">🔄</div>

            <h3>Renew Loan</h3>

            <p>
                Extend an eligible book loan
                for an additional 14 days.
            </p>

            <a href="renew_loan.php">
                Renew Loan
            </a>

        </div>

        <div class="card">

            <div class="card-symbol">💳</div>

            <h3>Membership</h3>

            <p>
                Activate or renew your membership
                and complete a payment.
            </p>

            <a href="pay_membership.php">
                Membership
            </a>

        </div>

        <div class="card">

            <div class="card-symbol">🧾</div>

            <h3>Borrowing History</h3>

            <p>
                Review returned, active and
                overdue borrowing records.
            </p>

            <a href="borrow_history.php">
                View History
            </a>

        </div>

        <div class="card">

            <div class="card-symbol">⚠</div>

            <h3>Overdue Alert</h3>

            <p>
                Check overdue books, borrowing
                limits and outstanding fines.
            </p>

            <a href="overdue_alert.php">
                Check Alert
            </a>

        </div>


        <div class="card">
            <div class="card-symbol">🔎</div>
            <h3>Search Books</h3>
            <p>Search the library catalogue using AJAX and load matching records directly from the database.</p>
            <a href="search_book.php">Search Books</a>
        </div>

    </div>

</section>

<section class="quick-section">
    <div class="quick-box">
        <div><span class="quick-label">Current Membership</span><strong><?php echo h($quick['membership_status']); ?></strong></div>
        <div><span class="quick-label">Books Borrowed</span><strong><?php echo $quick['borrowed']; ?> / 7</strong></div>
        <div><span class="quick-label">Fine Due</span><strong class="fine-amount">BDT <?php echo number_format($quick['fine'],2); ?></strong></div>
        <div><span class="quick-label">Membership Expiry</span><strong><?php echo h($quick['expiry_date'] ?: 'Not set'); ?></strong></div>
    </div>
</section>

<?php

require_once __DIR__ . '/includes/footer.php';

?>