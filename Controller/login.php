<?php
include "../Model/model.php";
session_start();
$username="";
$message="";
$valid=null;

if($_SERVER["REQUEST_METHOD"]=="POST")
    {
        $username=trim($_POST["username"] ?? "");
        $password=trim($_POST["password"] ?? "");

        $valid=true;
        if(empty($username) || strlen($username)<5){
            $message .= "Username Must be Valid (atleast 5 char). ";
            $valid=false;
        }
        if(empty($password) || strlen($password)<5){
            $message .= "Password Must be Valid (atleast 5 char). ";
            $valid=false;
        }

        if($valid)
            {
                $model=new LibrarianModel();
                $result=$model->checkLogin($username,$password);
                if($result->num_rows==1)
                    {
                        $row=$result->fetch_assoc();
                        $_SESSION["librarian_logged_in"]=true;
                        $_SESSION["librarian_username"]=$row["username"];
                        $_SESSION["librarian_name"]=$row["name"];
                        header("Location: index.php");
                        exit;
                    }
                    else{
                        $message="Invalid Username or Password";
                        $valid=false;
                    }
            }
}
$msgClass = ($valid === true) ? "success" : (($valid === false) ? "error" : "");
?>