<?php
require_once __DIR__ . '/../Model/model.php';
require_once __DIR__ . '/../Model/Session.php';
requireRole('Librarian', '../View/login.php');
$cid="";
$cname="";
$expiry="";
$period="";
$amount="";
$method="";
$message="";
$valid=null;

if($_SERVER["REQUEST_METHOD"]=="POST")
    {
        $cid=trim($_POST["cid"] ?? "");
        $cname=trim($_POST["cname"] ?? "");
        $expiry=trim($_POST["expiry"] ?? "");
        $period=trim($_POST["period"] ?? "");
        $amount=trim($_POST["amount"] ?? "");
        $method=trim($_POST["method"] ?? "");

        $valid=true;
        if(empty($cid)){
            $message .= "Customer ID is Required. ";
            $valid=false;
        }
        if(empty($cname)){
            $message .= "Customer Name is Required. ";
            $valid=false;
        }
        if(empty($expiry)){
            $message .= "Current Expiry Date is Required. ";
            $valid=false;
        }
        if(empty($period)){
            $message .= "Renewal Period is Required. ";
            $valid=false;
        }
        if(empty($amount) || !is_numeric($amount)){
            $message .= "Valid Payment Amount is Required. ";
            $valid=false;
        }
        if(empty($method)){
            $message .= "Payment Method is Required. ";
            $valid=false;
        }

        if($valid)
            {
                $model=new CustomerModel();
                $exists=$model->checkCustomerExists($cid);
                if($exists->num_rows==0)
                    {
                        $message="Customer ID Not Found!";
                        $valid=false;
                    }
                    else{
                        $days = ($period=="6m") ? 180 : (($period=="1y") ? 365 : 730);
                        $newExpiry = date("Y-m-d", strtotime($expiry." + ".$days." days"));
                        $result=$model->renewMembership($cid,$newExpiry);
                        if($result)
                            {
                                $paymentModel=new MembershipPaymentModel();
                                $receipt_no="RCPT-".time();
                                $paymentModel->addPayment($cid,$amount,date("Y-m-d"),$newExpiry,$receipt_no,$method);
                                $message="Membership Renewed Successfully! New Expiry: ".$newExpiry." | Receipt: ".$receipt_no;
                                $cid=$cname=$expiry=$period=$amount=$method="";
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