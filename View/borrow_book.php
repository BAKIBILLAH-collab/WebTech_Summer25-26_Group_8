<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CareShelf - Borrow Book</title>
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

        <h1 class="page-title">1.4 Borrow Book</h1>

        <form action="membership_required.php" method="post">
            <table class="form-table">
                <tr>
                    <td class="label"><label>Book Title:</label></td>
                    <td><input type="text" name="book_title" value="PHP for Beginners"></td>
                </tr>
                <tr>
                    <td class="label"><label>Author:</label></td>
                    <td><input type="text" name="author" value="John Smith"></td>
                </tr>
                <tr>
                    <td class="label"><label>Borrow Date:</label></td>
                    <td><input type="date" name="borrow_date" value="2026-08-16"></td>
                </tr>
                <tr>
                    <td class="label"><label>Due Date:</label></td>
                    <td><input type="date" name="due_date" value="2026-08-30"></td>
                </tr>
                <tr>
                    <td class="label"><label>Membership:</label></td>
                    <td><input type="text" name="membership" value="Active"></td>
                </tr>
            </table>

            <div class="button-row">
                <button class="btn" type="submit">Confirm Borrow</button>
                <button class="btn btn-alt" type="reset">Cancel</button>
            </div>
        </form>

        <div class="link-row">
            <a href="search_book.php">Back to Search</a> |
            <a href="index.php">Back to menu</a>
        </div>
    </div>
</body>
</html>
