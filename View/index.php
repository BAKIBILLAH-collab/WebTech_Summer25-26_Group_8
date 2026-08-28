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
            <div class="card">
                <table class="card-table">
                    <tr><td><img class="card-icon" src="../Assets/search.svg" alt=""></td></tr>
                    <tr><td><br><h3>Search Book</h3><a href="search_book.php">Open</a></td></tr>
                </table>
            </div>
            <div class="card">
                <table class="card-table">
                    <tr><td class="card-icon-placeholder" aria-hidden="true"><br></td></tr>
                    <tr><td><br><h3>Payment Receipt</h3><a href="payment_receipt.php">Open</a></td></tr>
                </table>
            </div>
            <div class="card">
                <table class="card-table">
                    <tr><td class="card-icon-placeholder" aria-hidden="true"><br></td></tr>
                    <tr><td><br><h3>Borrow a Book</h3><a href="borrow_book.php">Open</a></td></tr>
                </table>
            </div>
        </div>
    </div>
    <footer class="site-footer" role="contentinfo">
        <span>CareShelf Library Management System &copy; 2026</span>
        <span>Contact: +880 1XXX-XXXXXX</span>
        <a href="mailto:careshelf@example.com">careshelf@example.com</a>
    </footer>
</body>
</html>
