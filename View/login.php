<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CareShelf - Login</title>
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

        <h1 class="page-title">Login</h1>

        <form action="search_book.php" method="post">
            <table class="form-table">
                <tr>
                    <td class="label"><label>Email:</label></td>
                    <td><input type="email" name="email" value="name@gmail.com"></td>
                </tr>
                <tr>
                    <td class="label"><label>Password:</label></td>
                    <td><input type="password" name="password" value="********"></td>
                </tr>
            </table>

            <div class="button-row">
                <button class="btn" type="submit">Login</button>
                <button class="btn btn-alt" type="reset">Reset</button>
            </div>
        </form>

        <div class="link-row">
            <a href="register.php">Create new account</a> |
            <a href="index.php">Back to menu</a>
        </div>
    </div>
</body>
</html>
