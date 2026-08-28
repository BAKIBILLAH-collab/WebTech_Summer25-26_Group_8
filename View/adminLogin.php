<?php
header('Location: login.php');
exit;
?>

<!DOCTYPE html>
<html lang="en-US">

<head>

    <title>Admin Login</title>

    <link rel="stylesheet" href="../Design/Style.css">

    <script>
        function validateLogin()
        {
            let adminname = document.getElementById("adminname").value.trim();
            let password = document.getElementById("password").value.trim();

            let valid = true;
            let message = "";

            if(adminname.length == 0)
            {
                message += "Admin Username is Required\n";
                valid = false;
            }

            if(password.length == 0)
            {
                message += "Password is Required\n";
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
        <a href="admin_login.php" class="active">Admin Login</a>
    </div>

    <div class="container">

        <h1>Admin Login</h1>

        <?php
        if($message)
        {
            echo "<p style='color: red;'>$message</p>";
        }
        ?>

        <form method="post" action="" onsubmit="return validateLogin()">

            <fieldset>

                <legend>Admin Credentials</legend>

                <table>
                    <tr>
                        <td> <label for="adminname"> Admin Username: </label></td>
                        <td> <input type="text" id="adminname" name="adminname">
                        <?php echo $name; ?>
                    </td>
                    </tr>

                    <tr>
                        <td> <label for="password"> Password: </label></td>
                        <td> <input type="password" id="password" name="password">
                    </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <input type="checkbox" id="remember" name="remember" value="1" <?php echo (!empty($_COOKIE["remember_user"])) ? "checked" : ""; ?>>
                            <label for="remember"> Remember Me </label>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <input type="submit" id="submit" name="submit" value="LOG IN">
                            <input type="reset" id="reset">
                        </td>
                    </tr>
                </table>

            </fieldset>

        </form>

    </div>

</body>

<<<<<<< HEAD
</html>
=======
</html>
>>>>>>> 3daec0c419bcd9eeef9460ecf11a041a447284e6
