<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CareShelf - Payment Receipt</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="wrapper">
        <div class="header-box">
            <h2>CareShelf Library Management System</h2>
        </div>

        <div class="topnav">
            <a href="index.php">Home</a>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        </div>

        <h1 class="page-title">Payment Receipt</h1>

        <div class="receipt-box">
            <table class="form-table">
                <tr>
                    <td class="label"><strong>Customer:</strong></td>
                    <td>Ayesha Rahman</td>
                </tr>
                <tr>
                    <td class="label"><strong>Payment Date:</strong></td>
                    <td>2026-08-16</td>
                </tr>
                <tr>
                    <td class="label"><strong>Plan:</strong></td>
                    <td>Annual Membership</td>
                </tr>
                <tr>
                    <td class="label"><strong>Amount:</strong></td>
                    <td>$120.00</td>
                </tr>
                <tr>
                    <td class="label"><strong>Payment Method:</strong></td>
                    <td>Bkash</td>
                </tr>
                <tr>
                    <td class="label"><strong>Expiry Date:</strong></td>
                    <td>2027-08-16</td>
                </tr>
            </table>
        </div>

        <div class="button-row">
            <form action="index.php" method="post">
                <button class="btn" type="submit">Finish</button>
            </form>
        </div>

        <div class="link-row">
            <a href="membership_required.php">Back to membership alert</a> |
            <a href="index.php">Back to menu</a>
        </div>
    </div>
</body>
</html>
