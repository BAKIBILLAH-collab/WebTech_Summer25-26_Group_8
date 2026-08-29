<?php
require_once __DIR__ . '/../Model/model.php';
require_once __DIR__ . '/../Model/Session.php';
requireRole('Librarian');
$model=new FineModel();
$result=$model->getAllFinePayments();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Fine Payment Records</title>
    <link rel="stylesheet" href="style.css">
    <script src="../JS/ajax.js"></script>
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

        <h1 class="page-title">View Fine Payment Records</h1>

        <div class="search-box">
            <label for="search">Search by Customer ID:</label>
            <input type="text" id="search" name="search" onkeyup="SearchFinePayment()">
        </div>

        <div class="panel">
        <table class="data-table">
            <tr>
                <th>Customer ID</th>
                <th>Amount (Taka)</th>
                <th>Payment Method</th>
                <th>Payment Date</th>
                <th>Status</th>
            </tr>
            <tbody id="finetable">
                <?php
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["customer_id"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["amount"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["payment_method"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["payment_date"]) . "</td>";
                    echo "<td><span class='badge badge-active'>" . htmlspecialchars($row["status"]) . "</span></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        </div>

        <div class="link-row">
            <a href="finepayment.php">Pay a Fine</a> |
            <a href="index.php">Back to menu</a>
        </div>
    </div>
</body>
</html>