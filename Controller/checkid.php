<?php
require_once __DIR__ . '/../Model/model.php';
require_once __DIR__ . '/../Model/Session.php';
requireRole('Librarian', '../View/login.php');
$type=$_POST["type"] ?? "";
$value=$_POST["value"] ?? "";

if(!$value)
    {
        echo "";
    }
    elseif($type=="customer")
    {
        $model=new CustomerModel();
        $result=$model->checkCustomerExists($value);
        if($result->num_rows>0)
            {
                echo "<span style='color:#c0392b;'>Customer ID Already Taken</span>";
            }
            else{
                echo "<span style='color:#1e7e42;'>Customer ID Available</span>";
            }
    }
    elseif($type=="book")
    {
        $model=new BookModel();
        $result=$model->checkBookExists($value);
        if($result->num_rows>0)
            {
                echo "<span style='color:#c0392b;'>Book ID Already Taken</span>";
            }
            else{
                echo "<span style='color:#1e7e42;'>Book ID Available</span>";
            }
    }
    elseif($type=="customername")
    {
        $model=new CustomerModel();
        $result=$model->checkNameExists($value);
        if($result->num_rows>0)
            {
                echo "<span style='color:#c0392b;'>This Name Already Exists</span>";
            }
            else{
                echo "<span style='color:#1e7e42;'>Name Available</span>";
            }
    }
?>