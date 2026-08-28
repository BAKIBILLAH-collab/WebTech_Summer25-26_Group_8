<?php

include "../Model/db.php";
require_once __DIR__ . '/../Model/Session.php';
requireRole('Admin', '../View/index.php');

$search = "";
$message = "";
$customers = null;

if(isset($_GET["search"]))
{
    $search = trim($_GET["search"]);
    if(!empty($search))
    {
        $database = new db();
        $connection = $database->connection();
        $customers = $database->searchCustomer($connection,"customers",$search);

        if($customers->num_rows == 0)
        {
            $message = "Customer Not Found";
        }
    }
}



if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $customer_id = trim($_POST["customer_id"] ?? "");

    if(!empty($customer_id))
    {
        $database = new db();
        $connection = $database->connection();
        $result = $database->removeCustomer($connection,"customers",$customer_id);

        if($result)
        {
            echo "<script>
                    alert('Customer removed successfully!');
                    window.location.href = 'admindashboard.php';
                  </script>";
        }
        else
        {
            echo "<script>
                    alert('Customer could not be removed!');
                  </script>";
        }
    }
}

?>
