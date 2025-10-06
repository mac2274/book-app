<?php
require_once '../config/lib.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submitRegisterUser'])) {

    $name = $_POST['name'] ?? '';
    $surname = $_POST['surname'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['pwd'];

    if (empty($email) || empty($password)) {
        echo '<p class"text-red-500">Bitte Email und Passwort eingeben. </p>';
        require '../pages/register.html';
    } elseif (emailExists($email)) {
        echo '<p class"text-red-500">Diese Email ist bereits in Gebrauch. Bitte wähle eine andere aus. </p>';
        require '../pages/register.html';
    } else {
        registerUser($name, $surname, $email, $password);
        header('Location: ../pages/login.php');
    }
} else {
    echo '<p class"text-red-500">Die Registrierung ist fehlgeschlagen.</p>';
}


?>