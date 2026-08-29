<?php
require_once __DIR__ . '/../Model/model.php';
require_once __DIR__ . '/../Model/Session.php';
requireRole('Librarian', '../View/login.php');
$cname="";
$email="";
$phone="";
$password="";
$message="";
$valid=null;

if($_SERVER["REQUEST_METHOD"]=="POST")
    {
        $cname=trim($_POST["cname"] ?? "");
        $email=trim($_POST["email"] ?? "");
        $phone=trim($_POST["phone"] ?? "");
        $password=trim($_POST["password"] ?? "");

        $valid=true;
        if(empty($cname) || strlen($cname)<5){
            $message .= "Full Name Must be Atleast 5 Characters. ";
            $valid=false;
        }
        if(empty($email)){
            $message .= "Email is Required. ";
            $valid=false;
        }
        elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $message .= "Email is Invalid. ";
            $valid=false;
        }
        if(empty($phone)){
            $message .= "Phone is Required. ";
            $valid=false;
        }
        if(empty($password) || strlen($password)<5){
            $message .= "Password Must be Atleast 5 Characters. ";
            $valid=false;
        }

        if($valid)
            {
                $model=new CustomerModel();
                $exists=$model->checkNameExists($cname);
                if($exists->num_rows>0)
                    {
                        $message="This Name Already Exists!";
                        $valid=false;
                    }
                else
                    {
                        $expiry=date("Y-m-d", strtotime("+30 days"));
                        $result=$model->addCustomer($cname,$email,$phone,$password,$expiry);
                        if($result)
                            {
                                $message="Customer Added Successfully!";
                                $cname=$email=$phone=$password="";
                            }
                            else{
                                $message="Please try again";
                                $valid=false;
                            }
                    }
            }
}
$msgClass = ($valid === true) ? "success" : (($valid === false) ? "error" : "");
?>