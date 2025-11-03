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

function validatePassword($password)
{
    $errorMessage = [];
    // Mindestlänge
    if (strlen($password) < 8) {
        $$errorMessage[] = "Passwort muss mindestens 8 Zeichen lang sein";
    }
    // Großbuchstaben
    if (!preg_match('/[A-Z]/', $password)) {
        $$errorMessage[] = "Passwort muss mindestens einen Großbuchstaben enthalten";
    }
    // Kleinbuchstaben  
    if (!preg_match('/[a-z]/', $password)) {
        $$errorMessage[] = "Passwort muss mindestens einen Kleinbuchstaben enthalten";
    }
    // Zahlen
    if (!preg_match('/\d/', $password)) {
        $$errorMessage[] = "Passwort muss mindestens eine Zahl enthalten";
    }
    // Sonderzeichen
    if (!preg_match('/[@$!%*?&]/', $password)) {
        $$errorMessage[] = "Passwort muss mindestens ein Sonderzeichen (@$!%*?&) enthalten";
    }
    return $$errorMessage;
}

function registerUser($name, $surname, $email, $password)
{
    global $mysqli;

    // $hashedPassword = password_hash($password, PASSWORD_DEFAULT); wird in der Funktion zur Validirrung gesetzt

    # Hinzufügen vonneuen Usern
    $sql = "INSERT INTO user (name, surname, email, pwd) VALUES(?,?,?,?)";
    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        throw new Exception('Fehlermeldung:' . $mysqli->error);
    }
    $stmt->bind_param('ssss', $name, $surname, $email, $password);
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
    if ($result->num_rows === 0){ // wenn keine Bücher da, Nachricht mit ZurückButton
        echo '<p class="text-center py-4">Es sind noch keine Bücher hinzugefügt worden.</p>
                <div class="flex w-full justify-end">
                    <a href="../pages/bookShelf.php"
                        class="backButton fixed bottom-10 right-4 bg-black border-transparent border-1 text-white rounded-4xl p-2 hover:bg-green-200 hover:text-black hover:border-black  duration-500">
                        zurück</a>
                </div>';
        return;
    }

    $rows = $result->fetch_all(MYSQLI_ASSOC); // direkt das Array holen

    foreach ($rows as $row) {

        echo '<li class="listContainer w-100 p-4">
                <div class="flex flex-col justify-center items-center gap-y-4"> 
                    <p class="flex flex-col text-center gap-y-2">
                        <span class="font-bold text-sm italic text-xl"> ' . $row['title'] . ' </span>
                        <span class="text-sm"> - ' . $row['author'] . ' - </span>
                    </p>
                    <div class="flex flex-col items-center">
                        <button type="button" class="reveal_more my-1 border-1 rounded-3xl py-1 px-2 hover:bg-green-800 hover:text-white hover:transition hover:ease-in-out hover:duration-500" data-desc="' . $row['description'] . '">
                            Beschreibung  
                        </button>
                    </div>     
                    <img class="flex pb-8 items-center" src="' . $row['cover'] . '" alt="Cover des Buchs">

                    <div>
                        <form class="flex flex-row mb-8">
                            <div class="evaluate_container flex flex-col items-center z-0">
                                <div class="flex gap-4 w-100>
                                <label for="like" class="thumb_like flex flex-col items-center">
                                    <input type="radio" value="like" name="evalution_book" class="like hidden">
                                    <svg class="likeSvgEmpty w-9 hover:text-green-600 transition-colors duration-500" 
                                        fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path d="M1 21h4V9H1v12zm22-11c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32c0-.41-.17-.79-.44-1.06L14.17 1 7.59 7.59C7.22 7.95 7 8.45 7 9v10c0 1.1.9 2 2 2h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-2z"/>
                                    </svg>
                                    <svg class="likeSvgFilled w-9 hidden text-green-600"
                                        fill="currentColor" viewBox="0 0 24 24">
                                        <desc>Dieses Buch gefällt mir!</desc>
                                        <path d="M1 21h4V9H1v12zm22-11c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32c0-.41-.17-.79-.44-1.06L14.17 1 7.59 7.59C7.22 7.95 7 8.45 7 9v10c0 1.1.9 2 2 2h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-2z"/>
                                    </svg>
                                </label>
                                <label for="dislike" class="thumb_dislike flex flex-col items-center">
                                    <input type="radio" value="like" name="evalution_book" class="dislike hidden">
                                    <svg class="dislikeSvgEmpty rotate-180 w-9 hover:text-red-600 transition-colors duration-500" 
                                        fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path d="M1 21h4V9H1v12zm22-11c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32c0-.41-.17-.79-.44-1.06L14.17 1 7.59 7.59C7.22 7.95 7 8.45 7 9v10c0 1.1.9 2 2 2h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-2z"/>
                                    </svg>
                                    <svg class="dislikeSvgFilled rotate-180 w-9 hidden text-red-600"
                                        fill="currentColor" viewBox="0 0 24 24">
                                        <desc>Dieses Buch gefällt mir nicht.</desc>
                                        <path d="M1 21h4V9H1v12zm22-11c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32c0-.41-.17-.79-.44-1.06L14.17 1 7.59 7.59C7.22 7.95 7 8.45 7 9v10c0 1.1.9 2 2 2h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-2z"/>
                                    </svg>
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
    if ($result->num_rows === 0) { // wenn keine Bücher da, Nachricht mit BackButton
        echo '<p class="text-center py-4">Es sind noch keine Bücher hinzugefügt worden.</p>
                <div class="flex w-full justify-end">
                    <a href="../pages/bookShelf.php"
                        class="backButton fixed bottom-10 right-4 bg-black border-transparent border-1 text-white rounded-4xl p-2 hover:bg-green-200 hover:text-black hover:border-black  duration-500">
                    zurück</a>
                </div>';
        return; 
    }

    while ($row = $result->fetch_assoc()) {
        echo '<li class="listContainer w-100 px-4">
                <div class="flex flex-row gap-x-4 gap-y-4 justify-center items-center py-4 gap-y-2"> 
                    <p class="flex flex-col w-100 text-center">
                        <span class="italic text-xl">' . htmlspecialchars($row['title'] ?? 'Kein Titel') . '</span>
                        <span class="text-sm">- ' . htmlspecialchars($row['author'] ?? 'Unbekannt') . ' - </span>
                    </p>
                
                    <img class="pb-8 " src="' . htmlspecialchars($row['cover']) . '">
                </div>  

                <div>
                    <form class="flex flex-row justify-center mb-8">
                        <div class="evaluate_container flex flex-col items-center z-0">
                            <div class="flex gap-4 w-100>
                                <label for="like" class="thumb_like flex flex-col items-center">
                                    <input type="radio" value="like" name="evalution_book" class="like hidden">
                                    <svg class="likeSvgEmpty w-9 hover:text-green-600 transition-colors duration-500" 
                                        fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path d="M1 21h4V9H1v12zm22-11c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32c0-.41-.17-.79-.44-1.06L14.17 1 7.59 7.59C7.22 7.95 7 8.45 7 9v10c0 1.1.9 2 2 2h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-2z"/>
                                    </svg>
                                    <svg class="likeSvgFilled w-9 hidden text-green-600"
                                        fill="currentColor" viewBox="0 0 24 24">
                                        <desc>Dieses Buch gefällt mir!</desc>
                                        <path d="M1 21h4V9H1v12zm22-11c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32c0-.41-.17-.79-.44-1.06L14.17 1 7.59 7.59C7.22 7.95 7 8.45 7 9v10c0 1.1.9 2 2 2h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-2z"/>
                                    </svg>
                                </label>
                                <label for="dislike" class="thumb_dislike flex flex-col items-center">
                                    <input type="radio" value="like" name="evalution_book" class="dislike hidden">
                                    <svg class="dislikeSvgEmpty rotate-180 w-9 hover:text-red-600 transition-colors duration-500" 
                                        fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path d="M1 21h4V9H1v12zm22-11c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32c0-.41-.17-.79-.44-1.06L14.17 1 7.59 7.59C7.22 7.95 7 8.45 7 9v10c0 1.1.9 2 2 2h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-2z"/>
                                    </svg>
                                    <svg class="dislikeSvgFilled rotate-180 w-9 hidden text-red-600"
                                        fill="currentColor" viewBox="0 0 24 24">
                                        <desc>Dieses Buch gefällt mir nicht.</desc>
                                        <path d="M1 21h4V9H1v12zm22-11c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32c0-.41-.17-.79-.44-1.06L14.17 1 7.59 7.59C7.22 7.95 7 8.45 7 9v10c0 1.1.9 2 2 2h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-2z"/>
                                    </svg>
                                </label>              
                            </div>
                        </div>
                    </form>
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
    if ($result->num_rows === 0) { // wenn keine Bücher da, dann wird Nachricht mit BackButton angezeigt
        echo '<p class="text-center py-4 ftext-xl">Es sind noch keine Bücher hinzugefügt worden.</p>
                <div class="flex w-full justify-end">
                    <a href="../pages/bookShelf.php"
                        class="backButton fixed bottom-10 right-4 bg-black border-transparent border-1 text-white rounded-4xl p-2 hover:bg-green-200 hover:text-black hover:border-black  duration-500">
                    zurück</a>
                </div>';
        return; 
    }

    while ($row = $result->fetch_assoc()) {
        echo '<li class="listContainer w-100 p-4">
                <div class="flex flex-col items-center gap-y-4"> 
                    <p class="flex flex-col text-center gap-y-2">
                        <span class="italic text-xl">' . htmlspecialchars($row['title']) . '</span>
                        <span class="text-sm"> - ' . htmlspecialchars($row['author']) . ' - </span>
                    </p>
                    <div class="flex flex-col items-center">
                        <button type="button" class="reveal_more border-black border-1 text-black rounded-3xl py-1 px-2 hover:bg-green-800 hover:text-white hover:transition ease-in-out duration-500" data-desc="' . htmlspecialchars($row['description']) . '">
                            Beschreibung
                        </button> 
                    </div>
                    <div class="flex">
                        <img class="flex pb-8 items-center" src="' . htmlspecialchars($row['cover']) . '" alt="Cover des Buchs">
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
    $noRow = '';

    while ($row = $result->fetch_assoc()) {
        if ($row < 1) {
            $noRow = 'Es sind noch keine Bücher hinzugefügt worden.';
        } else {
            $rows[] = $row;
        }
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

