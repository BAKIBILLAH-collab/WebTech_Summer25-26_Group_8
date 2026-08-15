<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CareShelf - Register Account</title>
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

        <h1 class="page-title">Register Account</h1>

        <form action="search_book.php" method="post">
            <table class="form-table">
                <tr>
                    <td class="label"><label>Full Name:</label></td>
                    <td><input type="text" name="full_name" value="Ayesha Rahman"></td>
                </tr>
                <tr>
                    <td class="label"><label>Email:</label></td>
                    <td><input type="email" name="email" value="ayesha@example.com"></td>
                </tr>
                <tr>
                    <td class="label"><label>Phone Number:</label></td>
                    <td><input type="text" name="phone" value="01712345678"></td>
                </tr>
                <tr>
                    <td class="label"><label>Password:</label></td>
                    <td><input type="password" name="password" value="123456"></td>
                </tr>
                <tr>
                    <td class="label"><label>Membership Status:</label></td>
                    <td>
                        <select name="membership_status">
                            <option>Active</option>
                            <option>Inactive</option>
                            <option>Pending</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="label"><label>Membership Expiry Date:</label></td>
                    <td><input type="date" name="expiry_date" value="2026-12-31"></td>
                </tr>
                <tr>
                    <td class="label"><label>Registered Date:</label></td>
                    <td><input type="date" name="registered_date" value="2026-08-16"></td>
                </tr>
            </table>

            <div class="button-row">
                <button class="btn" type="submit">Create Account</button>
                <button class="btn btn-alt" type="reset">Clear</button>
            </div>
        </form>

        <div class="link-row">
            <a href="login.php">Already have an account?</a> |
            <a href="index.php">Back to menu</a>
        </div>
    </div>
</body>
</html>
