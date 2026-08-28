<?php

session_start();

if (empty($_SESSION['logged_in'])) {
    header('Location: login.php');
    exit;
}

$userName = $_SESSION['user_name'] ?? 'User';
$userRole = $_SESSION['user_role'] ?? 'customer';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CareShelf </title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="wrapper">
        <div class="header-box">
            <h2>CareShelf Library Management System</h2>
        </div>

        <div class="topnav">
            <a href="index.php">Home</a>
            <a href="../Controller/LogoutController.php">Logout</a>
            <div class="membership-link">
                <a href="membership_required.php">Membership</a>
            </div>
            <span class="user-label">
                <?= htmlspecialchars($userName, ENT_QUOTES, 'UTF-8') ?>
                (<?= htmlspecialchars($userRole, ENT_QUOTES, 'UTF-8') ?>)
            </span>
        </div>

        <h1 class="page-title">Dashboard</h1>

        <div class="card-grid">
            <div class="card search-card">
                <div class="card-content">
                    <h3 class="search-label">
                        <span>Search Books</span>
                        <img class="card-icon" src="../Assets/search.svg" alt="Search Books">
                    </h3>
                    <a href="search_book.php">Search</a>
                </div>
            </div>
            <div class="card">
                <div class="card-content">
                    <h3>My Books</h3>
                    <a href="view_my_books.php">Open</a>
                </div>
            </div>
            <div class="card">
                <div class="card-content">
                    <h3>Membership</h3>
                    <a href="membership_required.php">Open</a>
                </div>
            </div>
            <div class="card">
                <div class="card-content">
                    <h3>Payment Receipt</h3>
                    <a href="payment_receipt_new.php">Open</a>
                </div>
            </div>
            <div class="card">
                <div class="card-content">
                    <h3>Borrow a Book</h3>
                    <a href="search_book.php">Open</a>
                </div>
            </div>
        </div>
    </div>
    <footer class="site-footer" role="contentinfo">
        <span>CareShelf Library Management System &copy; 2026</span>
        <span>Contact: +880 1792995852</span>
        <a href="mailto:careshelf@example.com">careshelf@gmail.com</a>
    </footer>
</body>
</html>
