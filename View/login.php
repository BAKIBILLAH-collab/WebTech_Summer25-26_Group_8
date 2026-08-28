<?php

$error = $_GET['error'] ?? '';
$name = $_COOKIE['remember_user'] ?? '';
$remembered = isset($_COOKIE['remember_user']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CareShelf - Login</title>
    <link rel="stylesheet" href="style.css">
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
            <a href="register.php">Register</a>
            <div class="membership-link">
                <a href="membership_required.php">Membership</a>
            </div>
        </div>

        <h1 class="page-title">Login</h1>

        <?php if ($error === 'invalid'): ?>
            <p class="form-error">Name must be at least 5 characters and password must be at least 8 characters.</p>
        <?php elseif ($error === 'failed'): ?>
            <p class="form-error">Invalid name or password.</p>
        <?php elseif (isset($_GET['registered'])): ?>
            <p class="form-success">Registration successful. Please log in.</p>
        <?php endif; ?>

        <form class="login-form" action="../Controller/LoginController.php" method="post" onsubmit="return validateLogin()">
            <fieldset class="login-fieldset">
                <legend>Login Details</legend>
                <table class="form-table">
                    <tr>
                        <td class="label"><label for="name">Name:</label></td>
                        <td><input id="name" type="text" name="name" value="<?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?>" required></td>
                    </tr>
                    <tr>
                        <td class="label"><label for="password">Password:</label></td>
                        <td><input id="password" type="password" name="password" required></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><label class="remember-label"><input type="checkbox" name="remember" value="1" <?= $remembered ? 'checked' : '' ?>> <span>Remember Me</span></label></td>
                    </tr>
                </table>

                <div class="button-row">
                    <button class="btn" type="submit">Login</button>
                    <button class="btn btn-alt" type="reset">Reset</button>
                </div>
            </fieldset>
        </form>

        <div class="link-row">
            <a href="register.php">Create new account</a> |
            <a href="index.php">Back to menu</a>
        </div>
    </div>
</body>
</html>