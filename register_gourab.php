<?php
$pageTitle = 'CareShelf - Register Account';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/Model/app.php';

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    [$database, $conn] = getDatabase();

    $fullName = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $studentId = trim($_POST['student_id'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $password = $_POST['password'] ?? '';
    $membershipStatus = $_POST['membership_status'] ?? 'Inactive';
    $expiryDate = $_POST['expiry_date'] ?? null;
    $registeredDate = $_POST['registered_date'] ?? date('Y-m-d');
    $username = $email !== '' ? $email : strtolower(preg_replace('/[^a-zA-Z0-9]+/', '_', $fullName));

    $check = $conn->prepare("SELECT id FROM users WHERE username = ? LIMIT 1");
    $check->bind_param('s', $username);
    $check->execute();
    $exists = $check->get_result()->fetch_assoc();
    $check->close();

    if ($exists) {
        $error = 'An account with this email/username already exists.';
    } elseif ($fullName === '' || $email === '' || $password === '') {
        $error = 'Full name, email and password are required.';
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (username,password,full_name,email,phone,student_id,address,membership_status,expiry_date,registered_date) VALUES (?,?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param('ssssssssss', $username, $hash, $fullName, $email, $phone, $studentId, $address, $membershipStatus, $expiryDate, $registeredDate);
        if ($stmt->execute()) {
            $_SESSION['user_id'] = $stmt->insert_id;
            $message = 'Account created and saved in the users table. User ID: ' . $stmt->insert_id;
        } else {
            $error = 'Unable to save account: ' . $conn->error;
        }
        $stmt->close();
    }
    $database->close();
}
?>

<h1 class="page-title">Register Account</h1>
<?php if ($message): ?><div class="notice-box notice-success">&#10003; <?php echo h($message); ?></div><?php endif; ?>
<?php if ($error): ?><div class="notice-box notice-danger">&#9888; <?php echo h($error); ?></div><?php endif; ?>

<form method="post">
    <table class="form-table">
        <tr><td class="label"><label for="full_name">Full Name:</label></td><td><input type="text" name="full_name" id="full_name" value="" required></td></tr>
        <tr><td class="label"><label for="email">Email:</label></td><td><input type="email" name="email" id="email" value="" required></td></tr>
        <tr><td class="label"><label for="phone">Phone Number:</label></td><td><input type="text" name="phone" id="phone" value=""></td></tr>
        <tr><td class="label"><label for="student_id">Student ID:</label></td><td><input type="text" name="student_id" id="student_id" value=""></td></tr>
        <tr><td class="label"><label for="address">Address:</label></td><td><textarea name="address" id="address"></textarea></td></tr>
        <tr><td class="label"><label for="password">Password:</label></td><td><input type="password" name="password" id="password" value="" required></td></tr>
        <tr><td class="label"><label for="membership_status">Membership Status:</label></td><td><select name="membership_status" id="membership_status"><option value="Active">Active</option><option value="Inactive">Inactive</option><option value="Pending">Pending</option></select></td></tr>
        <tr><td class="label"><label for="expiry_date">Membership Expiry Date:</label></td><td><input type="date" name="expiry_date" id="expiry_date" value=""></td></tr>
        <tr><td class="label"><label for="registered_date">Registered Date:</label></td><td><input type="date" name="registered_date" id="registered_date" value="<?php echo date('Y-m-d'); ?>"></td></tr>
    </table>
    <div class="button-row"><button class="btn" type="submit">Create Account</button><button class="btn btn-alt" type="reset">Clear</button></div>
</form>
<div class="link-row"><a href="index.php">Back to menu</a></div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
