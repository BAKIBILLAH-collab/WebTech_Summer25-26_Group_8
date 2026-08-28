<?php
require_once __DIR__ . '/../Model/Session.php';
requireRole('Admin');
include "../Controller/staffvalidation.php";
?>

<!DOCTYPE html>
<html lang="en-US">

<head>

    <script src="../JS/CheckUser.js"></script>

    <title>Manage Staff Accounts</title>

    <link rel="stylesheet" href="../Design/Style.css">

    <script>
        function validateStaff()
        {
            let fullname = document.getElementById("fullname").value.trim();
            let email = document.getElementById("email").value.trim();
            let password = document.getElementById("password").value.trim();
            let role = document.getElementById("role").value;

            let valid = true;
            let message = "";

            if(fullname.length < 5)
            {
                message += "Full Name Should be at least 5 Characters\n";
                valid = false;
            }

            if(email.length == 0)
            {
                message += "Email is Required\n";
                valid = false;
            }

            if(password.length < 5)
            {
                message += "Password Must be at least 5 Characters\n";
                valid = false;
            }

            if(role == "")
            {
                message += "Role is Required\n";
                valid = false;
            }

            if(!valid)
            {
                alert(message);
            }

            return valid;
        }
    </script>

</head>

<body>

    <div class="header">
        <h2>CareShelf Admin Portal</h2>
    </div>

    <div class="topnav">

        <a href="admindashboard.php">Dashboard</a>
        <a href="add-customer.php">Customers Add</a>
        <a href="csremove.php">Customers Remove</a>
        <a href="addstaff.php">Staff Add</a>
        <a href="../Controller/LogoutController.php">Logout</a>

    </div>

    <div class="container">

        <h1>Manage Staff Accounts</h1>

        <p class="subtitle">
            Create and manage Librarian and Admin accounts
        </p>

        <?php
        if(!empty($message))
        {
            echo $message;
        }
        ?>

        <form method="POST" onsubmit="return validateStaff()">

            <fieldset>

                <legend>Add Staff Account</legend>

                <table>
                    <tr>
                        <td> <label for="fullname"> Full Name: </label></td>
                        <td> <input type="text" id="fullname" name="fullname" onkeyup="CheckUser()">
                        <?php echo $fullname ?? ''; ?>
                        <span id="userresponse"></span>
                    </td>
                    </tr>

                    <tr>
                        <td> <label for="email"> Email: </label></td>
                        <td> <input type="text" id="email" name="email">
                        <?php echo $email ?? ''; ?>
                    </td>
                    </tr>

                    <tr>
                        <td> <label for="password"> Give Password: </label></td>
                        <td> <input type="password" id="password" name="password">
                    </td>
                    </tr>

                    <tr>
                        <td> <label for="role"> Role: </label></td>
                        <td>
                            <select id="role" name="role">
                                <option value="">Select Role</option>
                                <option value="Librarian">Librarian</option>
                                <option value="Admin">Admin</option>
                            </select>
                            <?php echo $role ?? ''; ?>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <input type="submit" id="submit" name="submit" value="CREATE ACCOUNT">
                            <input type="reset" id="reset">
                        </td>
                    </tr>
                </table>

            </fieldset>

        </form>

    </div>

</body>

</html>
