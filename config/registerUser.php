<?php

require_once 'config.db.php';

if (isset($_SERVER['REQUEST_METHOD'])==='POST' && isset($_POST['submitRegisterUSer'])){
    $name = $_POST['name'];
    $surname= $ $_POST['surname'];
    $email = $_POST['email'];
    $password= $ $_POST['pwd'];
    
    registerUser();
};
