<?php
require_once 'lib.php';

echo 'hallo1';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submitRegisterUser'])) {

    echo 'hallo2';

    $name = $_POST['name'] ?? '';
    $surname = $_POST['surname'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['pwd'];

    registerUser($name, $surname, $email, $password);
} else {
    echo 'kein Post geschickt.';
}

?>
