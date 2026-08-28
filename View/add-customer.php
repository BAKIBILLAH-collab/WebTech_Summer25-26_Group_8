<?php
require_once __DIR__ . '/../Model/Session.php';
requireRole('Admin');
include "../Controller/adcsvalidation.php";
?>

<!DOCTYPE html>
<html>

<head>
    <title>Add Customer</title>
    <link rel="stylesheet" href="../Design/Style.css">

    <script>
        function collect_data()
        {
            let name = document.getElementById("name").value.trim();
            let password = document.getElementById("password").value.trim();
            let email = document.getElementById("email").value.trim();
            let phone = document.getElementById("phone").value.trim();
            let expiry = document.getElementById("expiry").value;
            let registered = document.getElementById("registered").value;

            let valid = true;
            let message = "";

            if(name.length < 5)
            {
                message += "User Name Should be 5 Char\n";
                valid = false;
            }

            if(password.length < 5)
            {
                message += "Password Must be 5 Char\n";
                valid = false;
            }

            if(email.length == 0)
            {
                message += "Email is Required\n";
                valid = false;
            }

            if(phone.length == 0)
            {
                message += "Phone Number is Required\n";
                valid = false;
            }

            if(expiry == "")
            {
                message += "Membership Expiry Date is Required\n";
                valid = false;
            }

            if(registered == "")
            {
                message += "Registered Date is Required\n";
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

    <h1>Add Customer</h1>

    <form method="post" action="" onsubmit="return collect_data()">

        <fieldset>

            <legend>Customer Information</legend>

            <table>
                <tr>
                    <td> <label for="name"> Full Name: </label></td>
                    <td> <input type="text" id="name" name="full_name">
                    <?php echo $name; ?>
                </td>
                </tr>

                <tr>
                    <td> <label for="email"> Email: </label></td>
                    <td> <input type="email" id="email" name="email">
                    <?php echo $email; ?>
                </td>
                </tr>

                <tr>
                    <td> <label for="phone"> Phone Number: </label></td>
                    <td> <input type="text" id="phone" name="phone">
                    <?php echo $phone; ?>
                </td>
                </tr>

                <tr>
                    <td> <label for="password"> Password: </label></td>
                    <td> <input type="password" id="password" name="password">
                    <?php echo $password; ?>
                </td>
                </tr>

                <tr>
                    <td> <label for="membership_status"> Membership Status: </label></td>
                    <td>
                        <select id="membership_status" name="membership_status">
                            <option value="">Select Status</option>
                            <option value="active">Active</option>
                            <option value="expired">Expired</option>
                        </select>
                        <?php echo $membership_status; ?>
                    </td>
                </tr>

                <tr>
                    <td> <label for="expiry"> Membership Expiry Date: </label></td>
                    <td> <input type="date" id="expiry" name="membership_expiry">
                    <?php echo $expiry; ?>
                </td>
                </tr>

                <tr>
                    <td> <label for="registered"> Registered Date: </label></td>
                    <td> <input type="date" id="registered" name="registered_date">
                    <?php echo $registered; ?>
                </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" id="submit" value="Add Customer">
                        <input type="reset" id="reset">
                    </td>
                </tr>
            </table>

        </fieldset>

    </form>

</body>

<<<<<<< HEAD
</html>
=======
</html>
>>>>>>> 3daec0c419bcd9eeef9460ecf11a041a447284e6
