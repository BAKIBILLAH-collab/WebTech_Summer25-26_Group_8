<?php include "../Controller/addremovebook.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title> Add/Remove Book</title>
    <link rel="stylesheet" href="style.css">
    <script src="../JS/ajax.js"></script>
    <script>
        function collect_data() {
            let bookid = document.getElementById("bookid").value.trim();
            let actions = document.getElementsByName("book_action");
            let actionChecked = false;
            for (let i = 0; i < actions.length; i++) {
                if (actions[i].checked) { actionChecked = true; }
            }

            let valid = true;
            let message = "";
            if (!actionChecked) { message += "Please Select Add or Remove\n"; valid = false; }
            if (bookid.length < 1) { message += "Book ID is Required\n"; valid = false; }
            if (!valid) { alert(message); }
            return valid;
        }
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="header-box">
            <h2>Library Management System</h2>
        </div>
        <div class="topnav">
            <a href="addremovebook.php">Add/Remove Book</a>
            <a href="customersrecord.php">View Customer Records</a>
            <a href="addcustomer.php">Add Customer</a>
            <a href="renewmembership.php">Renew Membership</a>
            <a href="approvebookreturn.php">Approve Book Return</a>
            <a href="finepayment.php">Fine Payment</a>
            <a href="finepaymentrecord.php">Fine Records</a>
            <a href="../Controller/LogoutController.php">Logout</a>
        </div>

        <h1 class="page-title">Add / Remove Book</h1>
        <p class="required-note">* Book ID needed only for Remove (auto-generated on Add)</p>
        <?php if (!empty($message)): ?>
        <p class="status-message <?= $msgClass ?>"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <form action="" method="post" onsubmit="return collect_data()">
            <div class="panel">
            <table class="form-table">
                <tr>
                    <td colspan="2">
                        <input type="radio" id="add" name="book_action" value="add" <?= ($book_action == "add") ? "checked" : "" ?>>
                        <label for="add">Add Book</label>
                        <input type="radio" id="remove" name="book_action" value="remove" <?= ($book_action == "remove") ? "checked" : "" ?>>
                        <label for="remove">Remove Book</label>
                        <span class="star">*</span>
                    </td>
                </tr>
                <tr>
                    <td class="label"><label for="bookid">Book ID:</label></td>
                    <td>
                        <input type="text" id="bookid" name="bookid" value="<?= htmlspecialchars($bookid) ?>" onkeyup="CheckBookID()">
                        <span id="bookidresponse" class="id-response"></span>
                        <span class="star">*</span>
                    </td>
                </tr>
                <tr>
                    <td class="label"><label for="title">Title:</label></td>
                    <td><input type="text" id="title" name="title" value="<?= htmlspecialchars($title) ?>"></td>
                </tr>
                <tr>
                    <td class="label"><label for="author">Author:</label></td>
                    <td><input type="text" id="author" name="author" value="<?= htmlspecialchars($author) ?>"></td>
                </tr>
                <tr>
                    <td class="label"><label for="isbn">ISBN:</label></td>
                    <td><input type="text" id="isbn" name="isbn" value="<?= htmlspecialchars($isbn) ?>"></td>
                </tr>
                <tr>
                    <td class="label"><label for="category">Category:</label></td>
                    <td>
                        <select id="category" name="category">
                            <option value="fiction" <?= ($category == "fiction") ? "selected" : "" ?>>Fiction</option>
                            <option value="non_fiction" <?= ($category == "non_fiction") ? "selected" : "" ?>>Non-Fiction</option>
                            <option value="academic" <?= ($category == "academic") ? "selected" : "" ?>>Academic</option>
                            <option value="reference" <?= ($category == "reference") ? "selected" : "" ?>>Reference</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="label"><label for="copies">Total Copies:</label></td>
                    <td><input type="text" id="copies" name="copies" value="<?= htmlspecialchars($copies) ?>"></td>
                </tr>
            </table>
            </div>
            <div class="button-row">
                <button class="btn" type="submit">Confirm</button>
                <button class="btn btn-alt" type="reset">Cancel</button>
            </div>
        </form>

        <div class="link-row">
            <a href="index.php">Back to menu</a>
        </div>
    </div>
</body>
</html>