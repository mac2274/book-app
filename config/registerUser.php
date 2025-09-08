<?php

require_once 'config.db.php';

if (isset($_SERVER['REQUEST_METHOD']) === 'POST' && isset($_POST['submitRegisterUSer'])){
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';

    if ($name && $email){
        $password = $_POST['pwd'];
    }

    registerUser($name, $surname, $email, $hashedPassword);
};
