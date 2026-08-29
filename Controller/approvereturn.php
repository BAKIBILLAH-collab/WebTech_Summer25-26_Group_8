<?php
require_once __DIR__ . '/../Model/model.php';
require_once __DIR__ . '/../Model/Session.php';
requireRole('Librarian', '../View/login.php');
$bookid="";
$cid="";
$idate="";
$rdate="";
$condition="";
$fine="";
$message="";
$valid=null;

if($_SERVER["REQUEST_METHOD"]=="POST")
    {
        $bookid=trim($_POST["bookid"] ?? "");
        $cid=trim($_POST["cid"] ?? "");
        $idate=trim($_POST["idate"] ?? "");
        $rdate=trim($_POST["rdate"] ?? "");
        $condition=trim($_POST["condition"] ?? "");
        $fine=trim($_POST["fine"] ?? "");
        if(empty($fine)){
            $fine="0";
        }

        $valid=true;
        if(empty($bookid)){
            $message .= "Book ID is Required. ";
            $valid=false;
        }
        if(empty($cid)){
            $message .= "Customer ID is Required. ";
            $valid=false;
        }
        if(empty($idate)){
            $message .= "Issue Date is Required. ";
            $valid=false;
        }
        if(empty($rdate)){
            $message .= "Return Date is Required. ";
            $valid=false;
        }
        if(empty($condition)){
            $message .= "Book Condition is Required. ";
            $valid=false;
        }
        if(!is_numeric($fine)){
            $message .= "Fine Amount must be a Number. ";
            $valid=false;
        }

        if($valid)
            {
                $model=new ReturnModel();
                $result=$model->approveReturn($bookid,$cid,$idate,$rdate,$condition,$fine);
                if($result)
                    {
                        $message="Book Return Approved Successfully!";
                        $bookid=$cid=$idate=$rdate=$condition=$fine="";
                    }
                else
                    {
                        $message="Please try again";
                        $valid=false;
                    }
            }
}
$msgClass = ($valid === true) ? "success" : (($valid === false) ? "error" : "");
?>