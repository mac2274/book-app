<?php
require_once '../config/lib.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submitRegisterUser'])) {

    $name = $_POST['name'] ?? '';
    $surname = $_POST['surname'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['pwd'];

    // Validieren
    if (empty($email) || empty($password)) {
        echo '<p class="text-red-500">Bitte Email und Passwort eingeben. </p>';
        require '../pages/register.html';
        exit;

    }
    // Passwort Validieren
    $errors = validatePassword($password);
    if (!empty($errors)) { 
        foreach ($errors as $error) {
            echo '<p class="text-red>' . htmlspecialchars($error) . '</p>';
        }
        require '../pages/register.php';
        exit;
    }
    // Email-Prüfung
    if (emailExists($email)) {
        echo '<p class="text-xl italic">Diese Email-Adresse wird bereits verwendet. Bitte wähle eine andere aus.</p>';
        require '../pages/register.php';
        exit;
    }
    // jetzt registrieren
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    registerUser($name, $surname, $email, $hashed_password);
    header('Location: ../pages/login.php');
    exit;
} else {
    require '../pages/register.php';
}

?>