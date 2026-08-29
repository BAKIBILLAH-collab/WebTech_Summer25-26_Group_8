<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CareShelf - Register Account</title>
    <link rel="stylesheet" href="style.css">
    <script src="../JS/CheckUser.js"></script>
    <script src="../JS/validation.js"></script>
</head>
<body>
    <div class="wrapper">
        <div class="header-box">
            <h2>CareShelf Library Management System</h2>
        </div>

        <div class="topnav">
            <a href="index.php">Home</a>
            <a href="login.php">Login</a>
          
            <div class="membership-link">
                <a href="membership_required.php">Membership</a>
            </div>
        </div>

        <h1 class="page-title">Register Account</h1>

        <?php if (($_GET['error'] ?? '') === 'name_taken'): ?>
            <p class="form-error">This name is already registered.</p>
        <?php elseif (($_GET['error'] ?? '') === 'email_taken'): ?>
            <p class="form-error">This email is already registered.</p>
        <?php elseif (($_GET['error'] ?? '') === 'invalid'): ?>
            <p class="form-error">Please check the form values and try again.</p>
        <?php endif; ?>

        <form action="../Controller/RegistrationController.php" method="post" onsubmit="return validateRegistration()">
            <table class="form-table">
                <tr>
                    <td class="label"><label for="full_name">Full Name:</label></td>
                    <td><input id="full_name" type="text" name="full_name" value="" placeholder="Enter your full name" onkeyup="CheckUser()" required><br><span id="userresponse"></span></td>
                </tr>
                <tr>
                    <td class="label"><label for="email">Email:</label></td>
                    <td><input id="email" type="email" name="email" value="" placeholder="Enter your email" required></td>
                </tr>
                <tr>
                    <td class="label"><label for="phone">Phone Number:</label></td>
                    <td><input id="phone" type="text" name="phone" value="" placeholder="Enter your phone number" required></td>
                </tr>
                <tr>
                    <td class="label"><label for="password">Password:</label></td>
                    <td><input id="password" type="password" name="password" value="" placeholder="Create a password" required></td>
                </tr>
                <tr>
                    <td class="label"><label for="membership_status">Membership Status:</label></td>
                    <td>
                        <select id="membership_status" name="membership_status" required>
                            <option value="" selected disabled>Select membership status</option>
                            <option value="active">Active</option>
                            <option value="expired">Expired</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="label"><label for="expiry_date">Membership Expiry Date:</label></td>
                    <td><input id="expiry_date" type="date" name="expiry_date" value="" required></td>
                </tr>
                <tr>
                    <td class="label"><label for="registered_date">Registered Date:</label></td>
                    <td><input id="registered_date" type="date" name="registered_date" value="" required></td>
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
    <footer class="site-footer" role="contentinfo">
        <span>CareShelf Library Management System &copy; 2026</span>
        <span>Contact: +880 1XXX-XXXXXX</span>
        <a href="mailto:careshelf@example.com">careshelf@example.com</a>
    </footer>
</body>
</html>
