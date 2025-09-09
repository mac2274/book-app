<?php

require_once 'lib.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['loginSubmit'])) {
    try {
        $email = $_POST['loginEmail'] ?? '';
        $pwd = $_POST['loginPwd'] ?? '';

        if (empty($email) || empty($pwd)){
            echo 'Bitte füllen Sie alle Felder aus.';
        }

        loginUser($email, $pwd);
    } catch (Exception $e) {

    }
}
