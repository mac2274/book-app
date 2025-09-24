<?php
require_once 'lib.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submitRegisterUser'])) {

    $name = $_POST['name'] ?? '';
    $surname = $_POST['surname'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['pwd'];

    if (empty($email) || empty($password)){
        echo 'Bitte Email und Passwort eingeben.';
    }

    if (emailExists($email)) {
        echo 'Diese Email ist bereits in Gebrauch. Bitte logge dich ein.';
        require '../pages/login.html';
    } else {
        registerUser($name, $surname, $email, $password);
        echo 'Registerierung erfolgt.<br>';
        echo 'Jetzt hier einloggen.<br>';
        require '../pages/login.html';
    }
} else {
    echo 'Die Registrierung ist fehlgeschlagen.';
}


?>