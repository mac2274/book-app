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

    if ($result->num_rows === 1) {
        $getRow = $result->fetch_assoc();

        if (password_verify($pwd, $getRow['pwd'])) {
            $_SESSION['name'] = $getRow['name'];
            $_SESSION['email'] = $getRow['email'];
            $_SESSION['loginDone'] = true;

            return true;
        } else {
            return false; // passwörter stimmen nicht überein
        }
    } else {
        return false; // Email gibt es nicht nicht
    }
}

function saveToFavs($data)
{
    global $mysqli;
    // POST auslesen

    $title = $data['title'];
    $author = $data['author'];
    $subtitle = $data['subtitle'];
    $description = $data['description'];
    $cover = $data['cover'];
    //$list = $data['list'];

    $sql = 'INSERT INTO books_fav (title, author, subtitle, description, cover) VALUES(?,?,?,?,?)';
    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        throw new Exception('Fehler:' . $mysqli->error);
    }
    $stmt->bind_param('sssss', $title, $author, $subtitle, $description, $cover);
    if (!$stmt->execute()) {
        throw new Exception('Fehler: ' . $stmt->error);
    }
    return $stmt->affected_rows;
}

function saveToDone($data)
{
    global $mysqli;

    $title = $data['title'];
    $author = $data['author'];

    $sql = 'INSERT INTO books_read (title, author) VALUES(?,?)';
    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        throw new Exception('Fehlermeldung: ' . $mysqli->error);
    }
    $stmt->bind_param('ss', $title, $author);
    if (!$stmt->execute()) {
        throw new Exception('Fehlermeldung: ' . $stmt->error);
    }
    return $stmt->affected_rows;
}

function saveToReads($data)
{
    global $mysqli;

    $title = $data['title'];
    $author = $data['author'];
    $subtitle = $data['subtitle'];
    $description = $data['description'];
    $cover = $data['cover'];

    $sql = "INSERT INTO books_to_read (title, author, subtitle, description, cover) VALUES(?,?,?,?,?)";
    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        throw new Exception('Fehlermeldung:' . $mysqli->error);
    }
    $stmt->bind_param('sssss', $title, $author, $subtitle, $description, $cover);
    if (!$stmt->execute()) {
        throw new Exception('Fehlermeldung:' . $stmt->error);
    }
    return $stmt->affected_rows;
}

function showFavs()
{
    global $mysqli;
    $sql = "SELECT * FROM books_fav LIMIT 20";
    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        throw new Exception('Fehlermeldung:' . $mysqli->error);
    }
    if (!$stmt->execute()) {
        throw new Exception('Fehlermeldung: ' . $stmt->error);
    }
    $result = $stmt->get_result();

    // variablen lassen sich nicht in htmlspecialchars einfügen, ohne dass der inhalt nicht angezeigt wird
    // $title = $row['title'] ?? 'Kein Titel vorhanden';
    // $author = $row['author'] ?? 'Unbekannt';
    // $description = $row['description'] ?? 'Keine Bescreiben vorhanden.';

    $rows = $result->fetch_all(MYSQLI_ASSOC);

    foreach ($rows as $row) {
        // echo $row['0'].'1-ol<br>';
        // echo $row['1'].'2-titel<br>';
        // echo $row['2'].'3-autors<br>';
        //echo print_r($rows);
        echo '<li class="listContainer p-4">
                <div class="flex flex-col items-center"> 
                    <div class="flex flex-row">
                        <p class="text-center">
                            <button type="button" class="reveal_more border-1 bg-green-900 text-white rounded-3xl py-1 px-3 hover:bg-green-800 hover:text-orange-200 hover:transition ease-in-out duration-500" data-desc="' . $row['description'] . '">
                                <span class="italic text-xl">' . $row['title'] . '</span>
                            </button> 
                            <span class="text-sm"> - ' . $row['author'] . '</span>
                        </p>
                    </div>
                    <div class="flex pt-4 pb-4">
                        <img class="flex p-2 items-center" src="' . $row['cover'] . '" alt="Cover des Buchs">
                    </div>
                </div>    
                <hr>
            </li>';
    }
}

function showDoneReading()
{
    global $mysqli;
    $sql = "SELECT * FROM books_read LIMIT 10";
    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        throw new Exception('Fehlermeldung:' . $mysqli->error);
    }
    if (!$stmt->execute()) {
        throw new Exception('Fehlermeldung: ' . $stmt->error);
    }
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        echo '<li class="listContainer px-8">
                <div class="flex flex-col items-center py-4"> 
                    <div class="flex flex-row">
                        <p class="text-center">
                            <span class="italic text-xl">' . htmlspecialchars($row['title'] ?? 'Kein Titek') . '</span>
                            <span class="text-sm"> - ' . htmlspecialchars($row['author'] ?? 'Unbekannt') . '</span>
                        </p>
                    </div>
                </div>    
                <hr>
            </li>';
    }
}

function showToRead()
{
    global $mysqli;
    $sql = "SELECT * FROM books_to_read LIMIT 20";
    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        throw new Exception('Fehlermeldung:' . $mysqli->error);
    }
    if (!$stmt->execute()) {
        throw new Exception('Fehlermeldung: ' . $stmt->error);
    }
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        echo '<li class="listContainer p-4">
                <div class="flex flex-col items-center"> 
                    <div class="flex flex-row">
                        <p class="text-center">
                            <button type="button" class="reveal_more border-1 bg-green-900 text-white rounded-3xl py-1 px-3 hover:bg-green-800 hover:text-orange-200 hover:transition ease-in-out duration-500" data-desc="' . $row['description'] . '">
                                <span class="italic text-xl">' . $row['title'] . '</span>
                            </button> 
                            <span class="text-sm"> - ' . $row['author'] . '</span>
                        </p>
                    </div>
                    <div class="flex pt-4 pb-4">
                        <img class="flex p-2 items-center" src="' . $row['cover'] . '" alt="Cover des Buchs">
                    </div>
                </div>    
                <hr>
            </li>';
    }
}

function getDoneReading($limit, $offset)
{
    global $mysqli;

    $sql = "SELECT * FROM books_read LIMIT ? OFFSET ?";
    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        throw new Exception('Fehlermeldung:' . $mysqli->error);
    }
    $stmt->bind_param('ii', $limit, $offset);
    if (!$stmt->execute()){
        throw new Exception('Fehlermeldung: '. $stmt->error);
    }
    $result = $stmt->get_result();
    $rows = []; // Array erstellen zum Befüllen

    while ($row = $result->fetch_assoc()){
        $rows[] = $row; // fügt daten ins neue Array ein
    }
    return $rows; // Wiedergabe des Arrays
}