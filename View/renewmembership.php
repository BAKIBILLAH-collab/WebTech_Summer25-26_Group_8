<?php include "../Controller/renewmembership.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Renew Membership</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function collect_data() {
            let cid = document.getElementById("cid").value.trim();
            let cname = document.getElementById("cname").value.trim();
            let expiry = document.getElementById("expiry").value.trim();
            let amount = document.getElementById("amount").value.trim();
            let method = document.getElementById("method").value.trim();

            let valid = true;
            let message = "";
            if (cid.length < 1) { message += "Customer ID is Required\n"; valid = false; }
            if (cname.length < 1) { message += "Customer Name is Required\n"; valid = false; }
            if (expiry.length < 1) { message += "Current Expiry Date is Required\n"; valid = false; }
            if (amount.length < 1) { message += "Payment Amount is Required\n"; valid = false; }
            if (method.length < 1) { message += "Payment Method is Required\n"; valid = false; }
            if (!valid) { alert(message); }
            return valid;
        }
    </script>
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

        <h1 class="page-title">Renew Customer Membership</h1>
        <p class="required-note">* required field</p>
        <?php if (!empty($message)): ?>
        <p class="status-message <?= $msgClass ?>"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <form action="" method="post" onsubmit="return collect_data()">
            <div class="panel">
            <table class="form-table">
                <tr>
                    <td class="label"><label for="cid">Customer ID:</label></td>
                    <td><input type="text" id="cid" name="cid" value="<?= htmlspecialchars($cid) ?>"> <span class="star">*</span></td>
                </tr>
                <tr>
                    <td class="label"><label for="cname">Customer Name:</label></td>
                    <td><input type="text" id="cname" name="cname" value="<?= htmlspecialchars($cname) ?>"> <span class="star">*</span></td>
                </tr>
                <tr>
                    <td class="label"><label for="expiry">Current Expiry Date:</label></td>
                    <td><input type="date" id="expiry" name="expiry" value="<?= htmlspecialchars($expiry) ?>"> <span class="star">*</span></td>
                </tr>
                <tr>
                    <td class="label"><label for="period">Renewal Period:</label></td>
                    <td>
                        <select id="period" name="period">
                            <option value="6m" <?= ($period == "6m") ? "selected" : "" ?>>6 Months</option>
                            <option value="1y" <?= ($period == "1y") ? "selected" : "" ?>>1 Year</option>
                            <option value="2y" <?= ($period == "2y") ? "selected" : "" ?>>2 Years</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="label"><label for="amount">Payment Amount (Taka):</label></td>
                    <td><input type="text" id="amount" name="amount" value="<?= htmlspecialchars($amount) ?>"> <span class="star">*</span></td>
                </tr>
                <tr>
                    <td class="label"><label for="method">Payment Method:</label></td>
                    <td>
                        <select id="method" name="method">
                            <option value="Cash" <?= ($method == "Cash") ? "selected" : "" ?>>Cash</option>
                            <option value="Bkash" <?= ($method == "Bkash") ? "selected" : "" ?>>Bkash</option>
                            <option value="Card" <?= ($method == "Card") ? "selected" : "" ?>>Card</option>
                        </select>
                    </td>
                </tr>
            </table>
            </div>
            <div class="button-row">
                <button class="btn" type="submit">Renew Membership</button>
                <button class="btn btn-alt" type="reset">Cancel</button>
            </div>
        </form>

        <div class="link-row">
            <a href="index.php">Back to menu</a>
        </div>
    </div>
</body>
</html>