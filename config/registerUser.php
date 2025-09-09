<?php
require_once 'lib.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submitRegisterUser'])) {

    $name = $_POST['name'] ?? '';
    $surname = $_POST['surname'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['pwd'];

    if (emailExists($email)) {
        echo 'Diese Email-Adresse wird bereits verwendet.';
    } else {
        registerUser($name, $surname, $email, $password);
    }
} else {
    echo 'Die Registrierung ist fehlgeschlagen.';
}

if ($email && $password) {
    require '../pages/login.html';
}
?>