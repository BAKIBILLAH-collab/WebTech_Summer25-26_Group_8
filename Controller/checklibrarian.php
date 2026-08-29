<?php
require_once __DIR__ . '/../Model/model.php';
require_once __DIR__ . '/../Model/Session.php';
requireRole('Librarian', '../View/login.php');
$username=$_POST["username"] ?? "";
if(!$username)
    {
        echo "";
    }
    else{
        $model=new LibrarianModel();
        $result=$model->getByUsername($username);
        if($result->num_rows>0)
            {
                $row=$result->fetch_assoc();
                echo "<span style='color:#1e7e42;'>Welcome, ".htmlspecialchars($row["name"])."</span>";
            }
            else{
                echo "<span style='color:#c0392b;'>Username Not Found</span>";
            }
    }
?>