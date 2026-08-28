<?php

session_start();

$_SESSION = [];

if (ini_get('session.use_cookies')) {
    $sessionCookie = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $sessionCookie['path'],
        $sessionCookie['domain'],
        $sessionCookie['secure'],
        $sessionCookie['httponly']
    );
}

setcookie('remember_user', '', time() - 3600, '/');
session_destroy();

header('Location: ../View/login.php');
exit;