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

    $sql = "SELECT id, name, email, pwd FROM user WHERE email=?";
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

        // var_dump($getRow['pwd']);
        // var_dump($pwd);
        // var_dump(password_verify($pwd, $getRow['pwd']));

        if (password_verify($pwd, $getRow['pwd'])) {
            $_SESSION['name'] = $getRow['name'];
            $_SESSION['userId'] = $getRow['id'];
            $_SESSION['loginDone'] = true;

            return true;
        } else {
            echo 'hallo1';
            return false; // passwörter stimmen nicht überein
        }
    } else {
        echo 'hallo2';
        return false; // Email gibt es nicht nicht
    }
}
function saveToFavs($data)
{
    global $mysqli;
    // POST auslesen

    // Prüfen, ob User eingeloggt ist
    if (!isset($_SESSION['userId'])) {
        throw new Exception('User ist nicht eingeloggt.');
    }
    $userId = $_SESSION['userId']; // wenn eingeloggt, wird die userId genutzt für die Speicherung in listen des Users

    $title = $data['title'];
    $author = $data['author'];
    $subtitle = $data['subtitle'];
    $description = $data['description'];
    $cover = $data['cover'];

    $sql = 'INSERT INTO books_fav (title, author, subtitle, description, cover, userId) VALUES(?,?,?,?,?,?)';
    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        throw new Exception('Fehler:' . $mysqli->error);
    }
    $stmt->bind_param('sssssi', $title, $author, $subtitle, $description, $cover, $userId);
    if (!$stmt->execute()) {
        throw new Exception('Fehler: ' . $stmt->error);
    }
    return $stmt->affected_rows;
}
function saveToDone($data)
{
    global $mysqli;

    // Prüfen, ob User eingeloggt ist
    if (!isset($_SESSION['userId'])) {
        throw new Exception('User ist nicht eingeloggt.');
    }
    $userId = $_SESSION['userId']; // wenn eingeloggt, wird die userId genutzt für die Speicherung in listen des Users

    $title = $data['title'];
    $author = $data['author'];
    $cover = $data['cover'];

    $sql = 'INSERT INTO books_read (title, author, cover, userId) VALUES(?,?,?,?)';
    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        throw new Exception('Fehlermeldung: ' . $mysqli->error);
    }
    $stmt->bind_param('sssi', $title, $author, $cover, $userId);
    if (!$stmt->execute()) {
        throw new Exception('Fehlermeldung: ' . $stmt->error);
    }
    return $stmt->affected_rows;
}
function saveToReads($data)
{
    global $mysqli;

    // Prüfen, ob User eingeloggt ist
    if (!isset($_SESSION['userId'])) {
        throw new Exception('User ist nicht eingeloggt.');
    }
    $userId = $_SESSION['userId']; // wenn eingeloggt, wird die userId genutzt für die Speicherung in listen des Users

    $title = $data['title'];
    $author = $data['author'];
    $subtitle = $data['subtitle'];
    $description = $data['description'];
    $cover = $data['cover'];

    $sql = "INSERT INTO books_to_read (title, author, subtitle, description, cover, userId) VALUES(?,?,?,?,?,?)";
    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        throw new Exception('Fehlermeldung:' . $mysqli->error);
    }
    $stmt->bind_param('sssssi', $title, $author, $subtitle, $description, $cover, $userId);
    if (!$stmt->execute()) {
        throw new Exception('Fehlermeldung:' . $stmt->error);
    }
    return $stmt->affected_rows;
}
function showFavs()
{
    global $mysqli;

    // $userId aus login nehmen, um Userlisten zu zeigen  
    $userId = $_SESSION['userId'];

    $sql = "SELECT * FROM books_fav WHERE userID=? LIMIT 10";
    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        throw new Exception('Fehlermeldung:' . $mysqli->error);
    }
    $stmt->bind_param('i', $userId);
    if (!$stmt->execute()) {
        throw new Exception('Fehlermeldung: ' . $stmt->error);
    }
    $result = $stmt->get_result();

    $rows = $result->fetch_all(MYSQLI_ASSOC);

    foreach ($rows as $row) {

        echo '<li class="listContainer p-4">
                <div class="flex flex-col justify-center items-center"> 
                    <p class="flex flex-col text-center gap-y-2">
                        <span class="font-bold text-sm italic text-xl"> ' . $row['title'] . ' </span>
                        <span class="text-sm"> - ' . $row['author'] . ' - </span>
                    </p>
                    <div class="flex flex-col items-center">
                        <button type="button" class="reveal_more my-1 border-1 rounded-3xl py-1 px-2 hover:bg-green-800 hover:text-white hover:transition hover:ease-in-out hover:duration-500" data-desc="' . $row['description'] . '">
                            Beschreibung  
                        </button>
                    </div>     
                    <img class="flex pt-4 pb-8 items-center" src="' . $row['cover'] . '" alt="Cover des Buchs">

                    <div>
                        <form class="flex flex-row mb-8">
                            <div class="evalutate_container flex gap-x-4">
                                <div class="flex items-center">
                                    <label for="like" class="thumb flex flex-col items-center">
                                        <input type="radio" value="like" name="evalution_book" class="like hidden">
                                        <img src="../src/img/thumbs-up-solid-empty.svg" class="likeImg w-10" alt="Dieses Buch gefällt mir!">
                                        <span>Das Buch gefällt mir!</span>
                                    </label>
                                </div>    
                                <div class="flex justify-center">
                                    <label for="dislike" class="thumb flex flex-col items-center">
                                        <input type="radio" value="dislike" name="evalution_book" class="dislike hidden">
                                        <img src="../src/img/thumbs-up-solid-empty.svg" class="w-10 rotate-180" alt="Dieses Buch gefällt mir nicht!">
                                        <span>Das Buch gefällt mir nicht.</span>
                                    </label>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>    
                <hr>
            </li>';
    }
}
function showDoneReading()
{
    global $mysqli;

    // $userId aus login nehmen, um Userlisten zu zeigen  
    $userId = $_SESSION['userId'];

    $sql = "SELECT * FROM books_read WHERE userID=? LIMIT 10";
    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        throw new Exception('Fehlermeldung:' . $mysqli->error);
    }
    $stmt->bind_param('i', $userId);
    if (!$stmt->execute()) {
        throw new Exception('Fehlermeldung: ' . $stmt->error);
    }
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        echo '<li class="listContainer px-8">
                <div class="flex flex-row gap-x-4 justify-between items-center py-4 gap-y-2"> 
                    <p class="flex flex-col w-100 text-center">
                        <span class="italic text-xl">' . htmlspecialchars($row['title'] ?? 'Kein Titel') . '</span>
                        <span class="text-sm">- ' . htmlspecialchars($row['author'] ?? 'Unbekannt') . ' - </span>
                    </p>
                
                    <img class=" pt-4 pb-8 " src="' . htmlspecialchars($row['cover']) . '">
                </div>    
                <hr>
            </li>';
    }
}
function showToRead()
{
    global $mysqli;

    // $userId aus login nehmen, um Userlisten zu zeigen  
    $userId = $_SESSION['userId'];

    $sql = "SELECT * FROM books_to_read WHERE userID=? LIMIT 10";
    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        throw new Exception('Fehlermeldung:' . $mysqli->error);
    }
    $stmt->bind_param('i', $userId);
    if (!$stmt->execute()) {
        throw new Exception('Fehlermeldung: ' . $stmt->error);
    }
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        echo '<li class="listContainer p-4">
                <div class="flex flex-col items-center"> 
                    <p class="flex flex-col text-center gap-y-2">
                        <span class="italic text-xl">' . $row['title'] . '</span>
                        <span class="text-sm"> - ' . $row['author'] . ' - </span>
                    </p>
                    <div class="flex flex-col items-center">
                        <button type="button" class="reveal_more border-1 bg-green-900 text-white rounded-3xl py-1 px-2 hover:bg-green-800 hover:text-orange-200 hover:transition ease-in-out duration-500" data-desc="' . $row['description'] . '">
                            Beschreibung
                        </button> 
                    </div>
                    <div class="flex">
                        <img class="flex pt-4 pb-8 items-center" src="' . $row['cover'] . '" alt="Cover des Buchs">
                    </div>
                </div>    
                <hr>
            </li>';
    }
}
function getDoneReading($limit, $offset) // Weitere Daten aus db liefern per Button-Klick
{
    global $mysqli;
    // $userId aus login nehmen, um Userlisten zu zeigen  
    $userId = $_SESSION['userId'];

    $sql = "SELECT * FROM books_read WHERE userId=? LIMIT ? OFFSET ?";
    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        throw new Exception('Fehlermeldung:' . $mysqli->error);
    }
    $stmt->bind_param('iii', $userId, $limit, $offset);
    if (!$stmt->execute()) {
        throw new Exception('Fehlermeldung: ' . $stmt->error);
    }
    $result = $stmt->get_result();
    $rows = []; // Array erstellen zum Befüllen

    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    return $rows; // Wiedergabe des Arrays
}
function getFavs($limit, $offset)
{
    global $mysqli;
    // $userId aus login nehmen, um Userlisten zu zeigen  
    $userId = $_SESSION['userId'];

    $limit = (int) $limit;
    $offset = (int) $offset;

    $sql = "SELECT * FROM books_fav WHERE userId=? LIMIT ? OFFSET ?";
    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        throw new Exception('Fehlermeldung:' . $mysqli->error);
    }
    $stmt->bind_param('iii', $userId, $limit, $offset);
    if (!$stmt->execute()) {
        throw new Exception('Fehlermeldung: ' . $stmt->error);
    }
    $result = $stmt->get_result();
    $rows = []; // Array erstellen zum Befüllen

    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    return $rows; // Wiedergabe des Arrays
}
function getToBeRead($limit, $offset)
{
    global $mysqli;
    // $userId aus login nehmen, um Userlisten zu zeigen  
    $userId = $_SESSION['userId'];

    $sql = "SELECT * FROM books_to_read WHERE userId=? LIMIT ? OFFSET ?";
    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        throw new Exception('Fehlermeldung: ' . $mysqli->error);
    }
    $stmt->bind_param('iii', $userId, $limit, $offset);
    if (!$stmt->execute()) {
        throw new Exception('Fehlermedung: ' . $stmt->error);
    }
    $result = $stmt->get_result();
    $rows = [];

    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    return $rows;
}

