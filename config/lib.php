<?php
session_start();
require_once 'config.db.php';

function emailExists($email)
{
    global $mysqli;

    # Doppelte Emails prüfen
    $stmt = "SELECT id FROM user WHERE email=?";
    $stmt = $mysqli->prepare($stmt);
    if (!$stmt) {
        throw new Exception('Fehlermeldung:' . $mysqli->error);
    }
    $stmt->bind_param('s', $email);
    if (!$stmt->execute())
        throw new Exception('Fehlermeldung:' . $stmt->error);
    $result = $stmt->get_result();
    return $result->num_rows > 0;
}

function registerUser($name, $surname, $email, $password)
{
    global $mysqli;

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    # Hinzufügen vonneuen Usern
    $sql = "INSERT INTO user (name, surname, email, pwd) VALUES(?,?,?,?)";
    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        throw new Exception('Fehlermeldung:' . $mysqli->error);
    }
    $stmt->bind_param('ssss', $name, $surname, $email, $hashedPassword);
    if (!$stmt->execute())
        throw new Exception('Fehlermeldung:' . $stmt->error);

    return $stmt->affected_rows;
}

function loginUser($email, $pwd)
{
    global $mysqli;

    $sql = "SELECT name, email, pwd FROM user WHERE email=?";
    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        throw new Exception('Datenbankfehler: ' . $mysqli->error);
    }
    $stmt->bind_param('s', $email);
    if (!$stmt->execute()) {
        throw new Exception('Datenbankfehler: ' . $stmt->error);
    }

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $getRow = $result->fetch_assoc();

        if (password_verify($pwd, $getRow['pwd'])) {
            $_SESSION['name'] = $getRow['name'];
            $_SESSION['email'] = $getRow['email'];
            $_SESSION['loginDone'] = true;

        }
    } else {
        echo 'Passwörter stimmen nicht überein.';
    }
}