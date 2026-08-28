<?php
if (!isset($pageTitle)) {
    $pageTitle = 'CareShelf';
}
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
$userName = $_SESSION['user_name'] ?? 'User';
$userRole = $_SESSION['user_role'] ?? 'customer';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="wrapper">
        <div class="header-box">
            <h2>CareShelf Library Management System</h2>
        </div>

        <div class="topnav">
            <a href="index.php">Home</a>
            <a href="search_book.php">Search Books</a>
            <a href="view_my_books.php">My Books</a>
            <a href="../Controller/LogoutController.php">Logout</a>
            <div class="membership-link">
                <a href="membership_required.php">Membership</a>
            </div>
            <span class="user-label">
                <?php echo htmlspecialchars($userName, ENT_QUOTES, 'UTF-8'); ?>
                (<?php echo htmlspecialchars($userRole, ENT_QUOTES, 'UTF-8'); ?>)
            </span>
        </div>
