<?php

function requireLogin(): void
{
    session_start();

    if (empty($_SESSION['logged_in'])) {
        header('Location: login.php');
        exit;
    }
}
