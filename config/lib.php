<?php

require_once 'config.db.php';

function registerUser($name, $surname, $email, $password)
{
    global $mysqli;

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO User (name, surname, email, pwd) VALUE(?,?,?,?)";
    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        throw new Exception('Fehlermeldung:' . $mysqli->error);
    }
    $stmt->bind_param('ssss', $name, $surname, $email, $hashedPassword);
    if (!$stmt->execute())
        throw new Exception('Fehlermeldung:' . $stmt->error);

    return $stmt->affected_rows;
}

function loginUser()
{
    global $mysqli;

    $sql = "SELECT name, surname, email, pwd FROM user WHERE email=?";
    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        throw new Exception('Fehler bei Datenbankaufbau:' . $mysqli->error);
    }
    $stmt->bind_param('s', $email);
    if (!$stmt->execute()) {
        throw new Exception('Fehlermeldung:' . $stmt->error);
    }
    $result = $stmt->get_result();

    echo 'hey1';

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        if (password_verify($_POST['loginPwd'], $$row['pwd'])){
            $_SESSION['userEmail'] = $row['email'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['loginDone'] = true;

            echo 'hey2';
        } 
    } else {
        echo 'User nicht gefunden!';
    }
}