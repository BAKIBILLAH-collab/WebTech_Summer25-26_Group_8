<?php

include "../Model/db.php";

$name = "";
$password = "";
$email = "";
$phone = "";
$status = "";
$expiry = "";
$registered = "";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $name = trim($_POST["full_name"] ?? "");
    $password = trim($_POST["password"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $phone = trim($_POST["phone"] ?? "");
    $status = trim($_POST["membership_status"] ?? "");
    $expiry = trim($_POST["membership_expiry"] ?? "");
    $registered = trim($_POST["registered_date"] ?? "");

    $valid = true;

    if(strlen($name) < 5)
    {
        $valid = false;
    }

    if(strlen($password) < 5)
    {
        $valid = false;
    }

    if(empty($email))
    {
        $valid = false;
    }

    if(empty($phone))
    {
        $valid = false;
    }

    if(empty($status))
    {
        $valid = false;
    }

    if(empty($expiry))
    {
        $valid = false;
    }

    if(empty($registered))
    {
        $valid = false;
    }


    if($valid)
    {
        $database = new db();
        $connection = $database->connection();
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $result = $database->addCustomer($connection,$name,$email,$phone,$hashedPassword,$status,$expiry,$registered);

        if($result)
        {
            echo "<script>
                    alert('Customer added successfully!');
                    window.location.href = 'admindashboard.php';
                  </script>";

            
        }
        else
        {
            echo "<script>
                    alert('Customer could not be added!');
                  </script>";
        }
        $jsonfile = "../Model/user.json";
        $users = [];

        if (file_exists($jsonfile))
       {
         $jsonData = file_get_contents($jsonfile);
         $users = json_decode($jsonData, true) ?? [];
       }

    $users[] = [
    'username'   => $name,
    'password'   => $hashedPassword,
    'email'      => $email,
    'phone'      => $phone,
    'status'     => $status,
    'expiry'     => $expiry,
    'registered' => $registered,
    'timestamp'  => time()
     ];

    file_put_contents($jsonfile,json_encode($users, JSON_PRETTY_PRINT));
    
    }
}

?>