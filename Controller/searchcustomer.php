<?php
require_once __DIR__ . '/../Model/model.php';
require_once __DIR__ . '/../Model/Session.php';
requireRole('Librarian', '../View/login.php');
$type=$_POST["type"] ?? "customer";
$search=$_POST["search"] ?? "";

if($type=="customer")
    {
        $model=new CustomerModel();
        $result = $search ? $model->searchCustomers($search) : $model->getAllCustomers();

        if($result->num_rows==0)
            {
                echo "<tr><td colspan='6' style='text-align:center;'>No Customers Found</td></tr>";
            }
            else{
                while($row=$result->fetch_assoc())
                    {
                        $badgeClass = ($row["membership_status"]=="active") ? "badge-active" : "badge-expired";
                        echo "<tr>";
                        echo "<td>".htmlspecialchars($row["customer_id"])."</td>";
                        echo "<td>".htmlspecialchars($row["full_name"])."</td>";
                        echo "<td>".htmlspecialchars($row["email"])."</td>";
                        echo "<td>".htmlspecialchars($row["phone_number"])."</td>";
                        echo "<td>".htmlspecialchars($row["membership_expiry_date"])."</td>";
                        echo "<td><span class='badge ".$badgeClass."'>".htmlspecialchars($row["membership_status"])."</span></td>";
                        echo "</tr>";
                    }
            }
    }
    elseif($type=="fine")
    {
        $model=new FineModel();
        $result = $search ? $model->searchFinePayments($search) : $model->getAllFinePayments();

        if($result->num_rows==0)
            {
                echo "<tr><td colspan='5' style='text-align:center;'>No Fine Payments Found</td></tr>";
            }
            else{
                while($row=$result->fetch_assoc())
                    {
                        echo "<tr>";
                        echo "<td>".htmlspecialchars($row["customer_id"])."</td>";
                        echo "<td>".htmlspecialchars($row["amount"])."</td>";
                        echo "<td>".htmlspecialchars($row["payment_method"])."</td>";
                        echo "<td>".htmlspecialchars($row["payment_date"])."</td>";
                        echo "<td><span class='badge badge-active'>".htmlspecialchars($row["status"])."</span></td>";
                        echo "</tr>";
                    }
            }
    }
?>