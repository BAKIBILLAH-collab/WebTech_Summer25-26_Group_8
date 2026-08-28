<?php

require_once __DIR__ . '/../Model/Session.php';
requireLogin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CareShelf - Membership</title>
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
        </div>

        <h1 class="page-title">Membership</h1>

        <div class="notice-box">
            Your membership is inactive. You need an active membership to borrow this book.
        </div>

        <form action="payment_receipt.php" method="post">
            <div class="button-row">
                <button class="btn" type="submit">Renew Membership</button>
            </div>
        </form>

        <div class="link-row">
            <a href="search_book.php">Go back to search</a> |
            <a href="index.php">Back to menu</a>
        </div>
    </div>
    <footer class="site-footer" role="contentinfo">
        <span>CareShelf Library Management System &copy; 2026</span>
        <span>Contact: +880 1XXX-XXXXXX</span>
        <a href="mailto:careshelf@example.com">careshelf@example.com</a>
    </footer>
</body>
</html>
