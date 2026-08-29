<?php include "../Controller/approvereturn.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title> Approve Book Return</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function collect_data() {
            let bookid = document.getElementById("bookid").value.trim();
            let cid = document.getElementById("cid").value.trim();
            let idate = document.getElementById("idate").value.trim();
            let rdate = document.getElementById("rdate").value.trim();
            let conditions = document.getElementsByName("condition");
            let conditionChecked = false;
            for (let i = 0; i < conditions.length; i++) {
                if (conditions[i].checked) { conditionChecked = true; }
            }

            let valid = true;
            let message = "";
            if (bookid.length < 1) { message += "Book ID is Required\n"; valid = false; }
            if (cid.length < 1) { message += "Customer ID is Required\n"; valid = false; }
            if (idate.length < 1) { message += "Issue Date is Required\n"; valid = false; }
            if (rdate.length < 1) { message += "Return Date is Required\n"; valid = false; }
            if (!conditionChecked) { message += "Book Condition is Required\n"; valid = false; }
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

        <h1 class="page-title">Approve Book Return</h1>
        <p class="required-note">* required field</p>
        <?php if (!empty($message)): ?>
        <p class="status-message <?= $msgClass ?>"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <form action="" method="post" onsubmit="return collect_data()">
            <div class="panel">
            <table class="form-table">
                <tr>
                    <td class="label"><label for="bookid">Book ID:</label></td>
                    <td><input type="text" id="bookid" name="bookid" value="<?= htmlspecialchars($bookid) ?>"> <span class="star">*</span></td>
                </tr>
                <tr>
                    <td class="label"><label for="cid">Customer ID:</label></td>
                    <td><input type="text" id="cid" name="cid" value="<?= htmlspecialchars($cid) ?>"> <span class="star">*</span></td>
                </tr>
                <tr>
                    <td class="label"><label for="idate">Issue Date:</label></td>
                    <td><input type="date" id="idate" name="idate" value="<?= htmlspecialchars($idate) ?>"> <span class="star">*</span></td>
                </tr>
                <tr>
                    <td class="label"><label for="rdate">Return Date:</label></td>
                    <td><input type="date" id="rdate" name="rdate" value="<?= htmlspecialchars($rdate) ?>"> <span class="star">*</span></td>
                </tr>
                <tr>
                    <td class="label"><label>Book Condition:</label></td>
                    <td>
                        <input type="radio" id="good" name="condition" value="good" <?= ($condition == "good") ? "checked" : "" ?>>
                        <label for="good">Good</label>
                        <input type="radio" id="damaged" name="condition" value="damaged" <?= ($condition == "damaged") ? "checked" : "" ?>>
                        <label for="damaged">Damaged</label>
                        <input type="radio" id="lost" name="condition" value="lost" <?= ($condition == "lost") ? "checked" : "" ?>>
                        <label for="lost">Lost</label>
                        <span class="star">*</span>
                    </td>
                </tr>
                <tr>
                    <td class="label"><label for="fine">Fine Amount (Taka):</label></td>
                    <td><input type="text" id="fine" name="fine" value="<?= htmlspecialchars($fine) ?>"></td>
                </tr>
            </table>
            </div>
            <div class="button-row">
                <button class="btn" type="submit">Approve Return</button>
                <button class="btn btn-alt" type="reset">Cancel</button>
            </div>
        </form>

        <div class="link-row">
            <a href="indexx.php">Back to menu</a>
        </div>
    </div>
</body>
</html>