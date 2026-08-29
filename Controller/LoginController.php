<?php

require_once __DIR__ . '/../Model/UserModel.php';

session_start();

$name = trim($_POST['name'] ?? '');
$password = $_POST['password'] ?? '';
$remember = isset($_POST['remember']) && $_POST['remember'] === '1';

if ($name === '' || strlen($name) < 5 || strlen($password) < 8) {
    header('Location: ../View/login.php?error=invalid');
    exit;
}

$user = (new UserModel())->login($name, $password);

if ($user === null) {
    header('Location: ../View/login.php?error=failed');
    exit;
}

session_regenerate_id(true);
$_SESSION['logged_in'] = true;
$_SESSION['user_id'] = $user['user_id'];
$_SESSION['user_name'] = $user['name'];
$_SESSION['user_role'] = $user['role'];
$_SESSION['username'] = $user['name'];
$_SESSION['role'] = $user['role'];

if ($remember) {
    setcookie('remember_user', $name, time() + 60 * 60 * 24, '/');
} else {
    setcookie('remember_user', '', time() - 3600, '/');
}

$destination = match (strtolower((string) $user['role'])) {
    'admin' => '../View/admindashboard.php',
    'librarian' => '../View/indexx.php',
    default => '../View/index.php',
};

header('Location: ' . $destination);
exit;
