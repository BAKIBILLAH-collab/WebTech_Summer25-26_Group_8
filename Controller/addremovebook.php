<?php
require_once __DIR__ . '/../Model/model.php';
require_once __DIR__ . '/../Model/Session.php';
requireRole('Librarian', '../View/login.php');
$book_action="";
$bookid="";
$title="";
$author="";
$isbn="";
$category="";
$copies="";
$message="";
$valid=null;

if($_SERVER["REQUEST_METHOD"]=="POST")
    {
        $book_action=trim($_POST["book_action"] ?? "");
        $bookid=trim($_POST["bookid"] ?? "");
        $title=trim($_POST["title"] ?? "");
        $author=trim($_POST["author"] ?? "");
        $isbn=trim($_POST["isbn"] ?? "");
        $category=trim($_POST["category"] ?? "");
        $copies=trim($_POST["copies"] ?? "");

        $valid=true;
        if(empty($book_action)){
            $message .= "Action (Add/Remove) is Required. ";
            $valid=false;
        }

        if($valid && $book_action=="add")
            {
                if(empty($title)){
                    $message .= "Title is Required. ";
                    $valid=false;
                }
                if(empty($author)){
                    $message .= "Author is Required. ";
                    $valid=false;
                }
                if(empty($category)){
                    $message .= "Category is Required. ";
                    $valid=false;
                }
                if(empty($copies)){
                    $message .= "Total Copies is Required. ";
                    $valid=false;
                }
                elseif(!is_numeric($copies)){
                    $message .= "Total Copies must be a Number. ";
                    $valid=false;
                }
            }

        if($valid && $book_action=="remove")
            {
                if(empty($bookid)){
                    $message .= "Book ID is Required to Remove. ";
                    $valid=false;
                }
            }

        if($valid)
            {
                $model=new BookModel();
                if($book_action=="add")
                    {
                        $result=$model->addBook($title,$author,$category,$isbn,$copies);
                        if($result)
                            {
                                $message="Book Added Successfully! Book ID: ".$model->getLastInsertId();
                                $book_action=$bookid=$title=$author=$isbn=$category=$copies="";
                            }
                            else{
                                $message="Please try again";
                                $valid=false;
                            }
                    }
                elseif($book_action=="remove")
                    {
                        $exists=$model->checkBookExists($bookid);
                        if($exists->num_rows==0)
                            {
                                $message="Book ID Not Found!";
                                $valid=false;
                            }
                            else{
                                $result=$model->removeBook($bookid);
                                if($result)
                                    {
                                        $message="Book Removed Successfully!";
                                        $book_action=$bookid=$title=$author=$isbn=$category=$copies="";
                                    }
                                    else{
                                        $message="Please try again";
                                        $valid=false;
                                    }
                            }
                    }
            }
}
$msgClass = ($valid === true) ? "success" : (($valid === false) ? "error" : "");
?>