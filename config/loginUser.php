<?php

require_once 'lib.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST)) {
    $email = $_POST['loginEmail'] ?? '';

    loginUser();
}