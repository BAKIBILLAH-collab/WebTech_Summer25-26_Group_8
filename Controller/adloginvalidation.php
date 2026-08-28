<?php

include "../Model/db.php";

session_start();

$name = "";
$password = "";
$message = "";
$remember = false;

if(isset($_COOKIE["remember_user"]))
{
    $name = $_COOKIE["remember_user"];
}

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $name = trim($_POST["adminname"] ?? "");
    $password = trim($_POST["password"] ?? "");
    $remember = isset($_POST["remember"]) && $_POST["remember"] == "1";
    $valid = true;

    if(empty($name) || strlen($name) < 5)
    {
        $message .= "User Name Must be Valid (at least 5 char).<br>";
        $valid = false;
    }

    if(empty($password) || strlen($password) < 5)
    {
        $message .= "Password Must be Valid (at least 5 char).<br>";
        $valid = false;
    }

    if($valid)
    {
        $database = new db();
        $connection = $database->connection();
        $result = $database->signin($connection,"staff_accounts",$name,$password);

        if($result !== false && $result->num_rows == 1)
        {
            $_SESSION["logged_in"] = true;
            $_SESSION["username"] = $name;
            $_SESSION["role"] = "Admin";


            
            if($remember)
            {
                setcookie("remember_user",$name,time() + (60 * 60 * 24 * 7),"/");
            }
            else
            {
                setcookie("remember_user","",time() - 3600,"/");
            }
            header("Location: ../View/admindashboard.php");
            exit();
        }
        else
        {
            $message = "Invalid Admin Username or Password.";
        }
    }
}

?>
