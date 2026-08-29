<?php include "../Controller/addcustomer.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title> Add Customer</title>
    <link rel="stylesheet" href="style.css">
    <script src="../JS/ajax.js"></script>
    <script>
        function collect_data() {
            let cname = document.getElementById("cname").value.trim();
            let email = document.getElementById("email").value.trim();
            let phone = document.getElementById("phone").value.trim();
            let password = document.getElementById("password").value.trim();

            let valid = true;
            let message = "";
            if (cname.length < 5) { message += "Full Name Must be Atleast 5 Characters\n"; valid = false; }
            if (email.length < 1) { message += "Email is Required\n"; valid = false; }
            if (phone.length < 1) { message += "Phone is Required\n"; valid = false; }
            if (password.length < 5) { message += "Password Must be Atleast 5 Characters\n"; valid = false; }
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

        <h1 class="page-title">Add Customer</h1>
        <p class="required-note">* required field</p>
        <?php if (!empty($message)): ?>
        <p class="status-message <?= $msgClass ?>"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <form action="" method="post" onsubmit="return collect_data()">
            <div class="panel">
            <table class="form-table">
                <tr>
                    <td class="label"><label for="cname">Full Name:</label></td>
                    <td>
                        <input type="text" id="cname" name="cname" value="<?= htmlspecialchars($cname) ?>" onkeyup="CheckCustomerName()">
                        <span id="cnameresponse" class="id-response"></span>
                        <span class="star">*</span>
                    </td>
                </tr>
                <tr>
                    <td class="label"><label for="email">Email:</label></td>
                    <td><input type="text" id="email" name="email" value="<?= htmlspecialchars($email) ?>"> <span class="star">*</span></td>
                </tr>
                <tr>
                    <td class="label"><label for="phone">Phone Number:</label></td>
                    <td><input type="text" id="phone" name="phone" value="<?= htmlspecialchars($phone) ?>"> <span class="star">*</span></td>
                </tr>
                <tr>
                    <td class="label"><label for="password">Password:</label></td>
                    <td><input type="password" id="password" name="password"> <span class="star">*</span></td>
                </tr>
            </table>
            </div>
            <div class="button-row">
                <button class="btn" type="submit">Add Customer</button>
                <button class="btn btn-alt" type="reset">Cancel</button>
            </div>
        </form>

        <div class="link-row">
            <a href="index.php">Back to menu</a>
        </div>
    </div>
</body>
</html>