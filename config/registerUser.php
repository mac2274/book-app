<?php
require_once 'lib.php';

if (isset($_SERVER['REQUEST_METHOD']) === 'POST' && isset($_POST['submitRegisterUSer'])) {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';


    if ($name && $email) {
        $password = $_POST['pwd'];

        registerUser($name, $surname, $email, $hashedPassword);
    } else {
        echo 'Registrierung hat nicht geklappt.';
    }
} else {
    echo 'kein Post geschickt.';
}

