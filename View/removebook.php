<?php
require_once __DIR__ . '/../Model/Session.php';
requireRole('Admin');
include "../Controller/bookremovevalidation.php";
?>

<!DOCTYPE html>
<html lang="en-US">

<head>

    <title>Remove Book</title>

    <link rel="stylesheet" href="../Design/Style.css">

    <script>
        function validateBookSearch()
        {
            let search = document.getElementById("search").value.trim();
            let valid = true;
            let message = "";

            if(search.length == 0)
            {
                message += "Please Enter Book Details to Search\n";
                valid = false;
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

    <div class="header">
        <h2>CareShelf Admin Portal</h2>
    </div>

    <div class="topnav">
        <a href="admindashboard.php">Dashboard</a>
        <a href="add-book.php">Books Add</a>
        <a href="bookremove.php">Books Remove</a>
        <a href="add-customer.php">Customers Add</a>
        <a href="csremove.php">Customers Remove</a>
        <a href="addstaff.php">Staff Add</a>
        <a href="../Controller/LogoutController.php">Logout</a>
    </div>

    <div class="container">

        <h1>Remove Book</h1>

        <p class="subtitle">
            Search book and remove the selected book
        </p>

        <?php
        if(!empty($message))
        {
            echo $message;
        }
        ?>

        <form method="GET" onsubmit="return validateBookSearch()">

            <fieldset>

                <legend>Search Book</legend>

                <table>
                    <tr>
                        <td> <label for="search"> Book Details: </label></td>
                        <td> <input type="text" id="search" name="search" placeholder="ID, Title, Author, Category or ISBN">
                        <?php echo $search; ?>
                    </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <input type="submit" id="submit" value="SEARCH">
                        </td>
                    </tr>
                </table>

            </fieldset>

        </form>

        <br>

        <?php
        if($books != null && $books->num_rows > 0)
        {
        ?>
            <fieldset>

                <legend>Book Details</legend>

                <table border="1">
                    <tr>
                        <th>Book ID</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Category</th>
                        <th>ISBN</th>
                        <th>Total Copies</th>
                        <th>Available Copies</th>
                        <th>Action</th>
                    </tr>

                    <?php
                    while($book = $books->fetch_assoc())
                    {
                    ?>
                        <tr>
                            <td><?php echo $book["book_id"]; ?></td>
                            <td><?php echo $book["title"]; ?></td>
                            <td><?php echo $book["author"]; ?></td>
                            <td><?php echo $book["category"]; ?></td>
                            <td><?php echo $book["isbn"]; ?></td>
                            <td><?php echo $book["total_copies"]; ?></td>
                            <td><?php echo $book["available_copies"]; ?></td>
                            <td>
                                <form method="POST" onsubmit="return confirm('Are you sure you want to remove this book?');">
                                    <input type="hidden" name="book_id" value="<?php echo $book["book_id"]; ?>">
                                    <input type="submit" value="REMOVE">
                                </form>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </table>

            </fieldset>
        <?php
        }
        ?>

    </div>

</body>

<<<<<<< HEAD
</html>
=======
</html>
>>>>>>> 3daec0c419bcd9eeef9460ecf11a041a447284e6
