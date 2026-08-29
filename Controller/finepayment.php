<?php
require_once __DIR__ . '/../Model/model.php';
require_once __DIR__ . '/../Model/Session.php';
requireRole('Librarian', '../View/login.php');
$cid="";
$amount="";
$method="";
$pdate="";
$message="";
$valid=null;

if($_SERVER["REQUEST_METHOD"]=="POST")
    {
        $cid=trim($_POST["cid"] ?? "");
        $amount=trim($_POST["amount"] ?? "");
        $method=trim($_POST["method"] ?? "");
        $pdate=trim($_POST["pdate"] ?? "");

        $valid=true;
        if(empty($cid)){
            $message .= "Customer ID is Required. ";
            $valid=false;
        }
        if(empty($amount)){
            $message .= "Amount is Required. ";
            $valid=false;
        }
        elseif(!is_numeric($amount)){
            $message .= "Amount must be a Number. ";
            $valid=false;
        }
        if(empty($method)){
            $message .= "Payment Method is Required. ";
            $valid=false;
        }
        if(empty($pdate)){
            $message .= "Payment Date is Required. ";
            $valid=false;
        }

        if($valid)
            {
                $model=new FineModel();
                $exists=$model->checkCustomerExists($cid);
                if($exists->num_rows==0)
                    {
                        $message="Customer ID Not Found!";
                        $valid=false;
                    }
                else
                    {
                        $result=$model->payFine($cid,$amount,$method,$pdate);
                        if($result)
                            {
                                $message="Fine Payment Recorded Successfully!";
                                $cid=$amount=$method=$pdate="";
                            }
                        else
                            {
                                $message="Please try again";
                                $valid=false;
                            }
                    }
            }
}
$msgClass = ($valid === true) ? "success" : (($valid === false) ? "error" : "");
?>