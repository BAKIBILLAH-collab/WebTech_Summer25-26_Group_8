<?php

include "../Model/db.php";
require_once __DIR__ . '/../Model/Session.php';
requireRole('Admin', '../View/index.php');

$title = "";
$author = "";
$isbn = "";
$category = "";
$total_copies = "";
$available_copies = "";
$message = "";

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $title = trim($_POST["title"] ?? "");
    $author = trim($_POST["author"] ?? "");
    $isbn = trim($_POST["isbn"] ?? "");
    $category = trim($_POST["category"] ?? "");
    $total_copies = trim($_POST["total_copies"] ?? "");
    $available_copies = trim($_POST["available_copies"] ?? "");

    $file = $_FILES["file"] ?? null;

    $valid = true;

    if(empty($title) || strlen($title) < 2)
    {
        $message .= "Book Title Must be Valid (at least 2 char)<br>";
        $valid = false;
    }

    if(empty($author) || strlen($author) < 2)
    {
        $message .= "Author Name Must be Valid (at least 2 char)<br>";
        $valid = false;
    }

    if(empty($isbn))
    {
        $message .= "ISBN is required<br>";
        $valid = false;
    }

    if(empty($category))
    {
        $message .= "Category is required<br>";
        $valid = false;
    }

    if($total_copies === "")
    {
        $message .= "Total Copies is required<br>";
        $valid = false;
    }
    elseif($total_copies < 1)
    {
        $message .= "Total Copies Must be at least 1<br>";
        $valid = false;
    }

    if($available_copies === "")
    {
        $message .= "Available Copies is required<br>";
        $valid = false;
    }
    elseif($available_copies < 0)
    {
        $message .= "Available Copies cannot be negative<br>";
        $valid = false;
    }
    elseif($available_copies > $total_copies)
    {
        $message .= "Available Copies cannot be greater than Total Copies<br>";
        $valid = false;
    }

    if($file == null || $file["error"] != 0)
    {
        $message .= "Book Image is required<br>";
        $valid = false;
    }


    if($valid)
    {
        
        $uploaddirectory = __DIR__ . "/../Uploads/";
        $filename = basename($file["name"]);
        $filePath = $uploaddirectory . $filename;

        if(move_uploaded_file($file["tmp_name"], $filePath))
        {
            
            $path = "../Uploads/" . $filename;
        }
        else
        {
            $message = "File could not be uploaded";
            $valid = false;
        }
        
        if($valid)
        {
            $database = new db();
            $connection = $database->connection();
            $result = $database->addBook($connection,$title,$author,$category,$isbn,$total_copies,$available_copies,$path);

            if($result)
            {
                echo "<script>
                    alert('Book Added Successfully!');
                    window.location.href = 'admindashboard.php';
                </script>";
            }
            else
            {
                $message = "Please try again";
            }
            $jsonfile = "../Model/adbook.json";
            $books = [];

             if(file_exists($jsonfile))
            {
              $jsonData = file_get_contents($jsonfile);
              $books = json_decode($jsonData, true) ?? [];
            }

            $books[] = [
            'title'            => $title,
            'author'           => $author,
            'isbn'             => $isbn,
            'category'         => $category,
            'total_copies'     => $total_copies,
            'available_copies' => $available_copies,
            'path'             => $path,
            'timestamp'        => time()
            ];

     file_put_contents($jsonfile,json_encode($books, JSON_PRETTY_PRINT));
       }
    }
}

<<<<<<< HEAD
?>
=======
?>
>>>>>>> 3daec0c419bcd9eeef9460ecf11a041a447284e6
