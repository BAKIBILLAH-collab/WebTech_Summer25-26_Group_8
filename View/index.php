<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CareShelf </title>
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
            <div class="membership-link">
                <a href="membership_required.php">Membership</a>
            </div>
        </div>

        <h1 class="page-title">Dashboard</h1>

        <div class="card-grid">
            <div class="card">
                <span class="card-icon card-icon-placeholder" aria-hidden="true"></span>
                <h3>Login</h3>
                <a href="login.php">Open</a>
            </div>
            <div class="card">
                <span class="card-icon card-icon-placeholder" aria-hidden="true"></span>
                <h3>Register Account</h3>
                <a href="register.php">Open</a>
            </div>
            <div class="card">
                <img class="card-icon" src="../Assets/search.svg" alt="">
                <h3>Search Book</h3>
                <a href="search_book.php">Open</a>
            </div>
            <div class="card">
                <span class="card-icon card-icon-placeholder" aria-hidden="true"></span>
                <h3>Payment Receipt</h3>
                <a href="payment_receipt.php">Open</a>
            </div>
        </div>
    </div>
</body>
</html>
