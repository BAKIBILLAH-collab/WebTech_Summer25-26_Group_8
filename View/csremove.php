<?php
require_once __DIR__ . '/../Model/Session.php';
requireRole('Admin');
include "../Controller/customerremovevalidation.php";
?>

<!DOCTYPE html>
<html lang="en-US">

<head>

    <title>Remove Customer</title>

    <link rel="stylesheet" href="../Design/Style.css">

    <script>
        function validateCustomerSearch()
        {
            let search = document.getElementById("search").value.trim();
            let valid = true;
            let message = "";

            if(search.length == 0)
            {
                message += "Please Enter Customer Details to Search\n";
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

        <h1>Remove Customer</h1>

        <p class="subtitle">
            Search customer and remove the selected customer
        </p>

        <?php
        if(!empty($message))
        {
            echo $message;
        }
        ?>

        <form method="GET" onsubmit="return validateCustomerSearch()">

            <fieldset>

                <legend>Search Customer</legend>

                <table>
                    <tr>
                        <td> <label for="search"> Customer Details: </label></td>
                        <td> <input type="text" id="search" name="search" placeholder="ID, Name, Email or Phone">
                        <?php echo $search; ?>
                    </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <input type="submit" id="submit" value="SEARCH">
                        </td>
                    </tr>
                </table>

            </fieldset>

        </form>

        <br>

        <?php
        if($customers != null && $customers->num_rows > 0)
        {
        ?>
            <fieldset>

                <legend>Customer Details</legend>

                <table border="1">
                    <tr>
                        <th>Customer ID</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Membership Status</th>
                        <th>Membership Expiry</th>
                        <th>Registered Date</th>
                        <th>Action</th>
                    </tr>

                    <?php
                    while($customer = $customers->fetch_assoc())
                    {
                    ?>
                        <tr>
                            <td><?php echo $customer["customer_id"]; ?></td>
                            <td><?php echo $customer["full_name"]; ?></td>
                            <td><?php echo $customer["email"]; ?></td>
                            <td><?php echo $customer["phone_number"]; ?></td>
                            <td><?php echo $customer["membership_status"]; ?></td>
                            <td><?php echo $customer["membership_expiry_date"]; ?></td>
                            <td><?php echo $customer["registered_date"]; ?></td>
                            <td>
                                <form method="POST" onsubmit="return confirm('Are you sure you want to remove this customer?');">
                                    <input type="hidden" name="customer_id" value="<?php echo $customer["customer_id"]; ?>">
                                    <input type="submit" value="REMOVE">
                                </form>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </table>

            </fieldset>
        <?php
        }
        ?>

    </div>

</body>

<<<<<<< HEAD
</html>
=======
</html>
>>>>>>> 3daec0c419bcd9eeef9460ecf11a041a447284e6
