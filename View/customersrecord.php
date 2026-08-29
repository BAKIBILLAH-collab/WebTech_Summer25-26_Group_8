<?php
require_once __DIR__ . '/../Model/model.php';
require_once __DIR__ . '/../Model/Session.php';
requireRole('Librarian');
$model=new CustomerModel();
$result=$model->getAllCustomers();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Customer Records</title>
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

        <h1 class="page-title">View Customer Records</h1>

        <div class="search-box">
            <label for="search">Search by Name or Customer ID:</label>
            <input type="text" id="search" name="search" onkeyup="SearchCustomer()">
        </div>

        <div class="panel">
        <table class="data-table">
            <tr>
                <th>Customer ID</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Expiry Date</th>
                <th>Status</th>
            </tr>
            <tbody id="customertable">
                <?php
                while ($row = $result->fetch_assoc()) {
                    $badgeClass = ($row["membership_status"] == "active") ? "badge-active" : "badge-expired";
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["customer_id"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["full_name"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["phone_number"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["membership_expiry_date"]) . "</td>";
                    echo "<td><span class='badge " . $badgeClass . "'>" . htmlspecialchars($row["membership_status"]) . "</span></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        </div>

        <div class="link-row">
            <a href="indexx.php">Back to menu</a>
        </div>
    </div>
</body>
</html>