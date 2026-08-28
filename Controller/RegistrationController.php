<?php

require_once __DIR__ . '/../Model/UserModel.php';

$name = trim($_POST['full_name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$password = $_POST['password'] ?? '';
$membershipStatus = $_POST['membership_status'] ?? '';
$expiryDate = $_POST['expiry_date'] ?? '';
$registeredDate = $_POST['registered_date'] ?? '';

$expiryDateIsValid = $expiryDate === '' || DateTime::createFromFormat('Y-m-d', $expiryDate) !== false;
$registeredDateIsValid = $registeredDate === '' || DateTime::createFromFormat('Y-m-d', $registeredDate) !== false;

if (strlen($name) < 5 || !filter_var($email, FILTER_VALIDATE_EMAIL) || $phone === ''
    || strlen($password) < 8 || !in_array($membershipStatus, ['active', 'expired'], true)
    || !$expiryDateIsValid || !$registeredDateIsValid) {
    header('Location: ../View/register.php?error=invalid');
    exit;
}

$userModel = new UserModel();

if ($userModel->nameExists($name)) {
    header('Location: ../View/register.php?error=name_taken');
    exit;
}

try {
    $userModel->registerCustomer($name, $email, $phone, $password, $membershipStatus, $expiryDate);
} catch (PDOException $exception) {
    if ((int) $exception->errorInfo[1] === 1062) {
        header('Location: ../View/register.php?error=email_taken');
        exit;
    }

    throw $exception;
}

header('Location: ../View/login.php?registered=1');
exit;
