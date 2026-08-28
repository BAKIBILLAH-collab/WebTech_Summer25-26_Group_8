<?php

require_once __DIR__ . '/../Model/UserModel.php';

$name = trim($_POST['username'] ?? '');

if ($name === '') {
    echo 'Name Required';
    exit;
}

$userModel = new UserModel();
echo $userModel->nameExists($name) ? 'Name Already Taken' : 'Name Available';
