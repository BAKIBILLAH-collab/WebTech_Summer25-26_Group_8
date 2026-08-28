<?php

include "../Model/db.php";

$name = trim($_POST["name"] ?? "");

if ($name === "")
{
    echo "Username Required";
}
$database = new db();
$connection = $database->connection();
$result = $database->CheckUser($connection,"staff_accounts",$name);

if ($result->num_rows > 0)
{
    echo "<span style='color:red;'>This name is already taken</span>";
}
else
{
    echo "<span style='color:green;'>Name available</span>";
}



?>