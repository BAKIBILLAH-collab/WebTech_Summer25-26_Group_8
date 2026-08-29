<?php
require_once __DIR__ . '/../Model/Session.php';
requireRole('Admin');
?>
<!DOCTYPE html>
<html lang="en-US">

<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../Design/Style.css">
</head>

<body>

    <div class="header">
        <h2>CareShelf Admin Portal</h2>
    </div>

    <div class="topnav">
        <a href="admindashboard.php">Admin Dashboard</a> 
        <a href="../Controller/LogoutController.php">Logout</a>
    </div>

    <div class="container">

        <h1>Admin Dashboard</h1>

        <p>Welcome, Admin!</p>

        <fieldset>
            <legend>Staff Management</legend>

            <a href="addstaff.php">
                <button type="button">Add Staff</button>
            </a>

        </fieldset>

        <br>

        <fieldset>
            <legend>Customer Management</legend>

            <a href="add-customer.php">
                <button type="button">Add Customer</button>
            </a>

            <a href="csremove.php">
                <button type="button">Remove Customer</button>
            </a>

        </fieldset>

        <br>

        <fieldset>
            <legend>Book Management</legend>

            <a href="addbook.php">
                <button type="button">Add Book</button>
            </a>

            <a href="removebook.php">
                <button type="button">Remove Book</button>
            </a>

        </fieldset>

        <br>

       

            </form>

        </fieldset>

    </div>

</body>

</html>
