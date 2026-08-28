<?php

include "../Model/db.php";

$search = "";
$message = "";
$books = null;

if(isset($_GET["search"]))
{
    $search = trim($_GET["search"]);

    if(!empty($search))
    {
        $database = new db();
        $connection = $database->connection();
        $books = $database->searchBook($connection,"books",$search);

        if($books->num_rows == 0)
        {
            $message = "Book Not Found";
        }
    }
}


if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $book_id = trim($_POST["book_id"] ?? "");

    if(!empty($book_id))
    {
        $database = new db();
        $connection = $database->connection();
        $result = $database->removeBook($connection,"books",$book_id);

        if($result)
        {
            echo "<script>
                    alert('Book removed successfully!');
                    window.location.href = 'admindashboard.php';
                  </script>";

            exit();
        }
        else
        {
            echo "<script>
                    alert('Book could not be removed!');
                  </script>";
        }
    }
}

?>