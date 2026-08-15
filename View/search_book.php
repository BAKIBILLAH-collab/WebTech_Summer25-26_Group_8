<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CareShelf - Search Book</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="wrapper">
        <div class="header-box">
            <h2>CareShelf Library Management System</h2>
        </div>

        <div class="topnav">
            <a href="index.php">Home</a>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        </div>

        <h1 class="page-title">Search Book</h1>

        <form action="borrow_book.php" method="post">
            <table class="form-table">
                <tr>
                    <td class="label"><label>Search:</label></td>
                    <td><input type="text" name="search" value="Programming"></td>
                    <td style="width: 180px;">
                        <select name="category">
                            <option>All</option>
                            <option>Technology</option>
                            <option>Science</option>
                            <option>History</option>
                            <option>Novel</option>
                        </select>
                    </td>
                    <td style="width: 150px;"><button class="btn" type="submit">Search</button></td>
                </tr>
            </table>
        </form>

        <table class="form-table" style="margin-top: 20px; border: 1px solid #ddd;">
            <tr style="background: #edf3ff;">
                <th>Title</th>
                <th>Author</th>
                <th>Category</th>
                <th>Available Copies</th>
                <th>Action</th>
            </tr>
            <tr>
                <td>PHP for Beginners</td>
                <td>John Smith</td>
                <td>Technology</td>
                <td>5</td>
                <td><button class="btn" type="button" onclick="window.location.href='borrow_book.php'">Borrow</button></td>
            </tr>
            <tr>
                <td>Modern JavaScript</td>
                <td>Emily Brown</td>
                <td>Technology</td>
                <td>3</td>
                <td><button class="btn" type="button" onclick="window.location.href='borrow_book.php'">Borrow</button></td>
            </tr>
            <tr>
                <td>World History</td>
                <td>David Lee</td>
                <td>History</td>
                <td>2</td>
                <td><button class="btn" type="button" onclick="window.location.href='borrow_book.php'">Borrow</button></td>
            </tr>
            <tr>
                <td>Billy Summers</td>
                <td>Stephen King</td>
                <td>Novel</td>
                <td>4</td>
                <td><button class="btn" type="button" onclick="window.location.href='borrow_book.php'">Borrow</button></td>
            </tr>
        </table>

        <div class="link-row">
            <a href="login.php">Back to Login</a> |
            <a href="index.php">Back to menu</a>
        </div>
    </div>
</body>
</html>
