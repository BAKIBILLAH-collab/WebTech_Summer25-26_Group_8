<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CareShelf - Membership Required</title>
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

        <h1 class="page-title">Membership Required Alert</h1>

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
</body>
</html>
