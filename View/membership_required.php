<?php

require_once __DIR__ . '/../Model/Session.php';
requireLogin();
require_once __DIR__ . '/../Model/UserModel.php';

$userId = (int)($_SESSION['user_id'] ?? 0);
$userName = $_SESSION['user_name'] ?? '';
$userModel = new UserModel();
$customer = $userId > 0 ? $userModel->getCustomerById($userId) : $userModel->getCustomerByName($userName);

$isActive = isset($customer['membership_status'])
    && strtolower((string) $customer['membership_status']) === 'active'
    && (!empty($customer['membership_expiry_date']) && $customer['membership_expiry_date'] >= date('Y-m-d'));
$status = $customer['membership_status'] ?? 'inactive';
$expiryDate = $customer['membership_expiry_date'] ?? 'Not available';
$registeredDate = $customer['registered_date'] ?? 'Not available';
$phone = $customer['phone_number'] ?? 'Not available';
$email = $customer['email'] ?? 'Not available';
$fullName = $customer['full_name'] ?? $userName;
$statusText = $isActive ? 'Active' : 'Inactive';
$needsRenewal = !$isActive;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CareShelf - Membership Status</title>
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

        <h1 class="page-title">Membership Status</h1>

        <div class="notice-box <?= $isActive ? 'notice-success' : 'notice-danger' ?>">
            <?= $isActive
                ? 'Your membership is active and you can borrow books.'
                : 'Your membership is inactive. You need an active membership to borrow this book.'; ?>
        </div>

        <div class="membership-status-wrap receipt-box">
            <table class="membership-status-list form-table">
                <tr>
                    <td class="label"><strong>Full Name:</strong></td>
                    <td><?= htmlspecialchars($fullName, ENT_QUOTES, 'UTF-8') ?></td>
                </tr>
                <tr>
                    <td class="label"><strong>Email:</strong></td>
                    <td><?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?></td>
                </tr>
                <tr>
                    <td class="label"><strong>Phone:</strong></td>
                    <td><?= htmlspecialchars($phone, ENT_QUOTES, 'UTF-8') ?></td>
                </tr>
                <tr>
                    <td class="label"><strong>Status:</strong></td>
                    <td><span class="badge <?= $isActive ? 'badge-success' : 'badge-danger' ?>"><?= htmlspecialchars($statusText, ENT_QUOTES, 'UTF-8') ?></span></td>
                </tr>
                <tr>
                    <td class="label"><strong>Membership Status:</strong></td>
                    <td><?= htmlspecialchars($status, ENT_QUOTES, 'UTF-8') ?></td>
                </tr>
                <tr>
                    <td class="label"><strong>Expiry Date:</strong></td>
                    <td><?= htmlspecialchars($expiryDate, ENT_QUOTES, 'UTF-8') ?></td>
                </tr>
                <tr>
                    <td class="label"><strong>Registered Date:</strong></td>
                    <td><?= htmlspecialchars($registeredDate, ENT_QUOTES, 'UTF-8') ?></td>
                </tr>
            </table>
        </div>

        <?php if ($needsRenewal): ?>
            <form action="pay_membership.php" method="post">
                <div class="button-row">
                    <button class="btn" type="submit">Renew Membership</button>
                </div>
            </form>
        <?php endif; ?>

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
