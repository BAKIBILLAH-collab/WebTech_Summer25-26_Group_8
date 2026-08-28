<?php

class db
{
    function connection()
    {
        $db_host = "localhost";
        $db_user = "root";
        $db_password = "";
        $db_name = "careshelf";

        $connection = new mysqli($db_host,$db_user,$db_password,$db_name);

        if($connection->connect_error)
        {
            die("Please Connect The Database");
        }

        return $connection;
    }

    function signup($connection, $tablename, $name, $password, $email, $role)
    {
        $sql = "INSERT INTO ".$tablename."
                (name, password, email, role)
                VALUES
                ('".$name."', '".$password."', '".$email."', '".$role."')";

        $result = $connection->query($sql);

        return $result;
    }


    function addCustomer($connection,$name,$email,$phone,$password,$status,$expiry,$registered)
    {
        $sql = "INSERT INTO customers
            (full_name, email, phone_number, password,
                 membership_status, membership_expiry_date, registered_date)
                VALUES
                ('".$name."', '".$email."', '".$phone."', '".$password."',
                 '".$status."', '".$expiry."', '".$registered."')";

        $result = $connection->query($sql);

        return $result;
    }


    function signin($connection, $tablename, $name, $password)
    {
        $sql = "SELECT * FROM ".$tablename."
                WHERE name='".$name."'
                AND password='".$password."'
                AND role='Admin'";

        $result = $connection->query($sql);

        return $result;
    }
    
    function searchCustomer($connection, $tablename, $search)
    {
    $sql = "SELECT * FROM ".$tablename."
            WHERE customer_id='".$search."'
            OR full_name='".$search."'
            OR email='".$search."'
            OR phone_number='".$search."'";

    $result = $connection->query($sql);

    return $result;
    }



    function removeCustomer($connection, $tablename, $customer_id)
    {
    $sql = "DELETE FROM ".$tablename."
            WHERE customer_id='".$customer_id."'";

    $result = $connection->query($sql);

    return $result;
    }
    function addBook($connection,$title,$author,$category,$isbn,$total_copies,$available_copies,$path)
    {
    $sql = "INSERT INTO books
            (title, author, category, isbn, total_copies, available_copies, pdf_path)
            VALUES
            ('".$title."', '".$author."', '".$category."', '".$isbn."',
             '".$total_copies."', '".$available_copies."', '".$path."')";

    $result = $connection->query($sql);
    return $result;
    }

    function searchBook($connection, $tablename, $search)
    {
    $sql = "SELECT * FROM ".$tablename."
            WHERE book_id='".$search."'
            OR title='".$search."'
            OR author='".$search."'
            OR category='".$search."'
            OR isbn='".$search."'";

    $result = $connection->query($sql);

    return $result;
    }



    function removeBook($connection, $tablename, $book_id)
    {
    $sql = "DELETE FROM ".$tablename."
            WHERE book_id='".$book_id."'";

    $result = $connection->query($sql);

    return $result;
    }
    function CheckUser($connection, $tablename, $username)
    {
        $sql="SELECT * FROM ".$tablename." WHERE name='".$username."'";
        $result=$connection->query($sql);
        return $result;
    }
}

?>