<?php
require_once __DIR__ . '/../Model/Session.php';
requireRole('Admin');
include "../Controller/adbookvalidation.php";
?>

<!DOCTYPE html>
<html>

<head>

    <title>Add Book</title>

    <link rel="stylesheet" href="../Design/Style.css">

    <script>
        function validateBook()
        {
            let title = document.getElementById("title").value.trim();
            let author = document.getElementById("author").value.trim();
            let isbn = document.getElementById("isbn").value.trim();
            let category = document.getElementById("category").value.trim();
            let total_copies = document.getElementById("total_copies").value;
            let available_copies = document.getElementById("available_copies").value;
            let file = document.getElementById("file").value;

            let valid = true;
            let message = "";

            if(title.length == 0)
            {
                message += "Book Title is Required\n";
                valid = false;
            }

            if(author.length == 0)
            {
                message += "Author is Required\n";
                valid = false;
            }

            if(isbn.length == 0)
            {
                message += "ISBN is Required\n";
                valid = false;
            }

            if(category.length == 0)
            {
                message += "Category is Required\n";
                valid = false;
            }

            if(total_copies == "")
            {
                message += "Total Copies is Required\n";
                valid = false;
            }

            if(available_copies == "")
            {
                message += "Available Copies is Required\n";
                valid = false;
            }

            if(file == "")
            {
                message += "Book Image is Required\n";
                valid = false;
            }

            if(total_copies != "" && available_copies != "")
            {
                if(Number(available_copies) > Number(total_copies))
                {
                    message += "Available Copies cannot be greater than Total Copies\n";
                    valid = false;
                }
            }

            if(!valid)
            {
                alert(message);
            }

            return valid;
        }
    </script>

</head>

<body>

    <h1>Add Book</h1>

    <?php
    if(!empty($message))
    {
        echo "<p>$message</p>";
    }
    ?>

    <form method="POST" action="" enctype="multipart/form-data" onsubmit="return validateBook()">

        <fieldset>

            <legend>Book Information</legend>

            <table>
                <tr>
                    <td> <label for="title"> Title: </label></td>
                    <td> <input type="text" id="title" name="title">
                    <?php echo $title; ?>
                </td>
                </tr>

                <tr>
                    <td> <label for="author"> Author: </label></td>
                    <td> <input type="text" id="author" name="author">
                    <?php echo $author; ?>
                </td>
                </tr>

                <tr>
                    <td> <label for="isbn"> ISBN: </label></td>
                    <td> <input type="text" id="isbn" name="isbn">
                    <?php echo $isbn; ?>
                </td>
                </tr>

                <tr>
                    <td> <label for="category"> Category: </label></td>
                    <td> <input type="text" id="category" name="category">
                    <?php echo $category; ?>
                </td>
                </tr>

                <tr>
                    <td> <label for="total_copies"> Total Copies: </label></td>
                    <td> <input type="number" id="total_copies" name="total_copies" min="1">
                    <?php echo $total_copies; ?>
                </td>
                </tr>

                <tr>
                    <td> <label for="available_copies"> Available Copies: </label></td>
                    <td> <input type="number" id="available_copies" name="available_copies" min="0">
                    <?php echo $available_copies; ?>
                </td>
                </tr>

                <tr>
                    <td> <label for="file"> Book Image: </label></td>
                    <td> <input type="file" id="file" name="file">
                </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" id="submit" value="Add Book">
                        <input type="reset" id="reset">
                    </td>
                </tr>
            </table>

        </fieldset>

    </form>

</body>

</html>