<?php

require_once 'lib.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['loginSubmit'])) {
    try {
        $email = $_POST['loginEmail'] ?? '';
        $pwd = $_POST['loginPwd'] ?? '';

        if (empty($email) || empty($pwd)) {
            echo 'Bitte Email und Passwort eingeben.';
        } else {
            echo 'Login war erfolgreich! <br>';
            echo '<strong>Hallo zurück, ' . $_SESSION['name'] . '!</strong><br>';
            require '../index.html'; // hier muss noch eine andere Seite her!  
            echo 'Du bist in deinem Journal, ' . $_SESSION['name'] . '.';
        }

        loginUser($email, $pwd);
    } catch (Exception $e) {
    }
}
