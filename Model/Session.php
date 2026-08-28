<?php

function requireLogin(): void
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    if (empty($_SESSION['logged_in'])) {
        header('Location: login.php');
        exit;
    }
}

function requireRole(string $role, string $redirect = 'index.php'): void
{
    requireLogin();

    if (strcasecmp((string) ($_SESSION['user_role'] ?? $_SESSION['role'] ?? ''), $role) !== 0) {
        header('Location: ' . $redirect);
        exit;
    }
}
