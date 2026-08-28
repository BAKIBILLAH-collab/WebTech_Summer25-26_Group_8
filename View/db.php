<?php

class db
{
    private $connection;

    function connection()
    {
        $db_host = "localhost";
        $db_user = "root";
        $db_password = "";
        $db_name = "group8";

        $this->connection = new mysqli(
            $db_host,
            $db_user,
            $db_password,
            $db_name
        );

        if ($this->connection->connect_error) {
            die(
                "Database Connection Failed: " .
                $this->connection->connect_error
            );
        }

        $this->connection->set_charset("utf8mb4");

        return $this->connection;
    }

    function close()
    {
        if ($this->connection) {
            $this->connection->close();
        }
    }
}

?>
