<?php
require_once __DIR__ . '/../Model/Session.php';
requireRole('Librarian');

$librarianName = $_SESSION['user_name'] ?? 'Librarian';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Librarian Menu</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="wrapper">
        <div class="header-box">
            <h2>Library Management System</h2>
        </div>
        <div class="topnav">
            <a href="addremovebook.php">Add/Remove Book</a>
            <a href="customersrecord.php">View Customer Records</a>
            <a href="addcustomer.php">Add Customer</a>
            <a href="renewmembership.php">Renew Membership</a>
            <a href="approvebookreturn.php">Approve Book Return</a>
            <a href="finepayment.php">Fine Payment</a>
            <a href="finepaymentrecord.php">Fine Records</a>
            <a href="../Controller/LogoutController.php">Logout</a>
        </div>

        <h1 class="page-title">Librarian Menu</h1>
        <p style="text-align:center;">Welcome, <?= htmlspecialchars($librarianName, ENT_QUOTES, 'UTF-8') ?>. Select an option below to continue.</p>

        <div class="panel">
        <table class="form-table">
            <tr>
                <td class="label">Customers</td>
                <td>
                    <a href="addcustomer.php">Add Customer</a> |
                    <a href="customersrecord.php">View Customer Records</a> |
                    <a href="renewmembership.php">Renew Membership</a>
                </td>
            </tr>
            <tr>
                <td class="label">Books</td>
                <td>
                    <a href="addremovebook.php">Add / Remove Book</a>
                </td>
            </tr>
            <tr>
                <td class="label">Returns</td>
                <td>
                    <a href="approvebookreturn.php">Approve Book Return</a> |
                    <a href="finepayment.php">Fine Payment</a> |
                    <a href="finepaymentrecord.php">Fine Records</a>
                </td>
            </tr>
        </table>
        </div>
    </div>
</body>
</html>