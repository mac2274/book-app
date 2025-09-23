<?php

require_once 'lib.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['loginSubmit'])) {
    try {
        $email = $_POST['loginEmail'] ?? '';
        $pwd = $_POST['loginPwd'] ?? '';

        if (empty($email) || empty($pwd)) {
            echo 'Bitte Email und Passwort eingeben.';
        } else {
            echo '<p class="text-center">Login war erfolgreich! <br>
            <strong>Du bist in deinem Journal, ' . $_SESSION['name'] . '.<strong></p>';
            require '../pages/bookSearch.html'; 
        }

        loginUser($email, $pwd);
    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
}
