<?php
require_once 'lib.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submitRegisterUser'])) {

    $name = $_POST['name'] ?? '';
    $surname = $_POST['surname'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['pwd'];

    registerUser($name, $surname, $email, $password);
} else {
    echo 'Kein Post geschickt.';
}

if ($email && $password) {
    require '../pages/login.html';
}
?>
