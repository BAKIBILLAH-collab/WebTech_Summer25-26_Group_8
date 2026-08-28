<?php

include "../Model/db.php";
require_once __DIR__ . '/../Model/Session.php';
requireRole('Admin', '../View/index.php');

$name = "";
$password = "";
$email = "";
$role = "";
$message = "";

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $name = trim($_POST["fullname"] ?? "");
    $password = trim($_POST["password"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $role = trim($_POST["role"] ?? "");

    $valid = true;

    if(empty($name) || strlen($name) < 5)
    {
        $message .= "User Name Must be Valid (at least 5 char)<br>";
        $valid = false;
    }


    
    if(empty($password) || strlen($password) < 5)
    {
        $message .= "Password Must be Valid (at least 5 char)<br>";
        $valid = false;
    }

    if(empty($email))
    {
        $message .= "Email is required<br>";
        $valid = false;
    }
    elseif(!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        $message .= "Email Must be Valid<br>";
        $valid = false;
    }

    if(empty($role))
    {
        $message .= "Role Must be Selected<br>";
        $valid = false;
    }
    elseif($role != "Librarian" && $role != "Admin")
    {
        $message .= "Invalid Role Selected<br>";
        $valid = false;
    }

    if($valid)
    {
        $database = new db();
        $connection = $database->connection();
        $result = $database->signup($connection,"staff_accounts",$name,password_hash($password, PASSWORD_DEFAULT),$email,$role);

        if($result)
        {
          echo "<script>
            alert('Staff Account Created Successfully!');
            window.location.href = 'admindashboard.php';
          </script>";
        }
        else
        {
            $message = "Please try again";
        }
        $jsonfile = "../Model/adstaff.json";
        $users = [];

        if (file_exists($jsonfile))
        {
            $jsonData = file_get_contents($jsonfile);
            $users = json_decode($jsonData, true) ?? [];
        }

    $users[] = [
    'username'  => $name,
    'password'  => $password,
    'email'     => $email,
    'role'      => $role,
    'timestamp' => time()
      ];

    file_put_contents($jsonfile,json_encode($users, JSON_PRETTY_PRINT));
    }
}

<<<<<<< HEAD
?>
=======
?>
>>>>>>> 3daec0c419bcd9eeef9460ecf11a041a447284e6
