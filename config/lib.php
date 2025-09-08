<?php

function registerUser($name, $surname, $email, $password){
    global $mysqli;
 
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    $sql = "INSERT INTO User (name, surname, email, password) VALUE(?,?,?,?)";
    $stmt = $mysqli->prepare($sql);
    if (!$stmt){
        throw new Exception('Fehlermeldung:'.$mysqli->error);
    }
    $stmt->bind_param('ssss', $name, $surname, $email, $hashedPassword);
    if (!$stmt->execute())
        throw new Exception('Fehlermeldung:'. $stmt->error);

    return $stmt->affected_rows;
}