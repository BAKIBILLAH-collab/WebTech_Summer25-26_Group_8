<?php
$pageTitle = 'CareShelf - Register Account';
require_once __DIR__ . '/includes/header.php';
?>

<h1 class="page-title">Register Account</h1>

<form action="search_book.php" method="post">
    <table class="form-table">
        <tr>
            <td class="label"><label for="full_name">Full Name:</label></td>
            <td>
                <input
                    type="text"
                    name="full_name"
                    id="full_name"
                    value="Gourab Saha"
                    required
                >
            </td>
        </tr>

        <tr>
            <td class="label"><label for="email">Email:</label></td>
            <td>
                <input
                    type="email"
                    name="email"
                    id="email"
                    value="gourabsaha2468@gmail.com"
                    required
                >
            </td>
        </tr>

        <tr>
            <td class="label"><label for="phone">Phone Number:</label></td>
            <td>
                <input
                    type="text"
                    name="phone"
                    id="phone"
                    value="01987654321"
                >
            </td>
        </tr>

        <tr>
            <td class="label"><label for="student_id">Student ID:</label></td>
            <td>
                <input
                    type="text"
                    name="student_id"
                    id="student_id"
                    value="CSE-2022-0148"
                    placeholder="e.g. CSE-2022-XXXX"
                >
            </td>
        </tr>

        <tr>
            <td class="label"><label for="address">Address:</label></td>
            <td>
                <textarea
                    name="address"
                    id="address"
                    placeholder="Enter your full address..."
                >Comilla, Chittagong, Bangladesh</textarea>
            </td>
        </tr>

        <tr>
            <td class="label"><label for="password">Password:</label></td>
            <td>
                <input
                    type="password"
                    name="password"
                    id="password"
                    value="Password"
                    required
                >
            </td>
        </tr>

        <tr>
            <td class="label"><label for="membership_status">Membership Status:</label></td>
            <td>
                <select name="membership_status" id="membership_status">
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                    <option value="Pending">Pending</option>
                </select>
            </td>
        </tr>

        <tr>
            <td class="label"><label for="expiry_date">Membership Expiry Date:</label></td>
            <td>
                <input
                    type="date"
                    name="expiry_date"
                    id="expiry_date"
                    value="2026-09-22"
                >
            </td>
        </tr>

        <tr>
            <td class="label"><label for="registered_date">Registered Date:</label></td>
            <td>
                <input
                    type="date"
                    name="registered_date"
                    id="registered_date"
                    value="2026-08-22"
                >
            </td>
        </tr>
    </table>

    <div class="button-row">
        <button class="btn" type="submit">Create Account</button>
        <button class="btn btn-alt" type="reset">Clear</button>
    </div>
</form>

<div class="link-row">
    <a href="login.php">Already have an account?</a> |
    <a href="index.php">Back to menu</a>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
