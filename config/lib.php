<?php
session_start();
require_once 'config.db.php';

function emailExists($email)
{
    global $pdo;

    $stmt = $pdo->prepare("SELECT id FROM users WHERE email=?");
    $stmt->execute([$email]);
    return $stmt->rowCount() > 0;
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
    global $pdo;

    // $hashedPassword = password_hash($password, PASSWORD_DEFAULT); wird in der Funktion zur Validirrung gesetzt

    # Hinzufügen vonneuen Usern
    $sql = "INSERT INTO users (name, surname, email, pwd) VALUES(?,?,?,?)";
    $stmt = $pdo->prepare($sql);

    return $stmt->execute([$name, $surname, $email, $password]);
}

function loginUser($email, $pwd)
{
    global $pdo;

    $sql = "SELECT id, name, email, pwd FROM users WHERE email=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $row = $stmt->fetch();

    if ($row) {
        if (password_verify($pwd, $row['pwd'])) {
            $_SESSION['name'] = $row['name'];
            $_SESSION['userId'] = $row['id'];
            $_SESSION['loginDone'] = true;
            return true;
        } else {
            echo 'Ein Fehler!';
            return false; // passwörter stimmen nicht überein
        }
    } else {
        echo 'Noch nicht Registriert!';
        return false; // Email gibt es nicht nicht
    }
}

function saveToFavs($data)
{
    global $pdo;
    // POST auslesen

    // Prüfen, ob User eingeloggt ist
    if (!isset($_SESSION['userId'])) {
        throw new Exception('User ist nicht eingeloggt.');
    }
    $userId = $_SESSION['userId']; // wenn eingeloggt, wird die userId genutzt für die Speicherung in listen des Users

    $sql = 'INSERT INTO books_fav (title, author, subtitle, description, cover, user_id) VALUES(?,?,?,?,?,?)';
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        $data['title'],
        $data['author'],
        $data['subtitle'],
        $data['description'],
        $data['cover'],
        $userId
    ]);
}

function saveToDone($data)
{
    global $pdo;

    // Prüfen, ob User eingeloggt ist
    if (!isset($_SESSION['userId'])) {
        throw new Exception('User ist nicht eingeloggt.');
    }
    $userId = $_SESSION['userId']; // wenn eingeloggt, wird die userId genutzt für die Speicherung in listen des Users

    $sql = 'INSERT INTO books_read (title, author, cover, user_id) VALUES(?,?,?,?)';
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        $data['title'],
        $data['author'],
        $data['cover'],
        $userId
    ]);
}

function saveToReads($data)
{
    global $pdo;

    // Prüfen, ob User eingeloggt ist
    if (!isset($_SESSION['userId'])) {
        throw new Exception('User ist nicht eingeloggt.');
    }
    $userId = $_SESSION['userId']; // wenn eingeloggt, wird die userId genutzt für die Speicherung in listen des Users

    $sql = "INSERT INTO books_to_read (title, author, subtitle, description, cover, userId) VALUES(?,?,?,?,?,?)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        $data['title'],
        $data['author'],
        $data['subtitle'],
        $data['description'],
        $data['cover'],
        $userId
    ]);
}

function showFavs()
{
    global $pdo;

    // $userId aus login nehmen, um Userlisten zu zeigen  
    $userId = $_SESSION['userId'];

    $sql = "SELECT * FROM books_fav WHERE userId=? LIMIT 10";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$userId]);
    $rows = $stmt->fetchAll();

    if (count($rows) === 0) { // wenn keine Bücher da, Nachricht mit ZurückButton
        echo '<p class="text-center py-4">Es sind noch keine Bücher hinzugefügt worden.</p>
                <div class="flex w-full justify-end">
                    <a href="../pages/bookShelf.php"
                        class="backButton fixed bottom-10 right-4 bg-black border-transparent border-1 text-white rounded-4xl p-2 hover:bg-green-200 hover:text-black hover:border-black  duration-500">
                        zurück</a>
                </div>';
        return;
    }

    foreach ($rows as $row) {

        echo '<li class="listContainer w-100 p-4">
                <div class="flex flex-col justify-center items-center gap-y-4"> 
                    <p class="flex flex-col text-center gap-y-2">
                        <span class="font-bold text-sm italic text-xl"> ' . htmlspecialchars($row['title']) . ' </span>
                        <span class="text-sm"> - ' . htmlspecialchars($row['author']) . ' - </span>
                    </p>
                    <div class="flex flex-col items-center">
                        <button type="button" class="reveal_more my-1 border-1 rounded-3xl py-1 px-2 hover:bg-green-800 hover:text-white hover:transition hover:ease-in-out hover:duration-500" data-desc="' . htmlspecialchars($row['description']) . '">
                            Beschreibung  
                        </button>
                    </div>     
                    <img class="flex pb-8 items-center" src="' . htmlspecialchars($row['cover']) . '" alt="Cover des Buchs">

                    <div>
                            <div class="evaluate_container flex flex-col items-center mb-8 z-0">
                                <div class="flex gap-4 w-100 justify-center">
                                    <form action="saveFavRating.php" method="POST" class="flex flex-row gap-4 justify-center w-100">
                                        <label>
                                            <input type="hidden" name="bookId" value="' . htmlspecialchars($row['id']) . '">
                                        </label>
                                        <div class="flex flex-row gap-4 justify-center w-full">
                                            <label class="thumb_like flex flex-col items-center">
                                                <input type="radio" value="1" name="evalution_book" class="like hidden">
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
                                            <label class="thumb_dislike flex flex-col items-center">
                                                <input type="radio" value="0" name="evalution_book" class="dislike hidden">
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
                                    </form>          
                                </div>
                            </div>
                    </div>
                </div>    
                <hr>
            </li>';
    }
}

function showDoneReading()
{
    global $pdo;

    // $userId aus login nehmen, um Userlisten zu zeigen  
    $userId = $_SESSION['userId'];

    $sql = "SELECT * FROM books_read WHERE userId=? LIMIT 10";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$userId]);
    $rows = $stmt->fetchAll();
    if (count($rows) === 0) { // wenn keine Bücher da, Nachricht mit BackButton
        echo '<p class="text-center py-4">Es sind noch keine Bücher hinzugefügt worden.</p>
                <div class="flex w-full justify-end">
                    <a href="../pages/bookShelf.php"
                        class="backButton fixed bottom-10 right-4 bg-black border-transparent border-1 text-white rounded-4xl p-2 hover:bg-green-200 hover:text-black hover:border-black  duration-500">
                    zurück</a>
                </div>';
        return;
    }

    foreach ($rows as $row) {
        echo '<li class="listContainer w-100 px-4">
                <div class="flex flex-row gap-x-4 gap-y-4 justify-center items-center py-4 gap-y-2"> 
                    <p class="flex flex-col w-100 text-center">
                        <span class="italic text-xl">' . htmlspecialchars($row['title'] ?? 'Kein Titel') . '</span>
                        <span class="text-sm">- ' . htmlspecialchars($row['author'] ?? 'Unbekannt') . ' - </span>
                    </p>
                
                    <img class="pb-8 " src="' . htmlspecialchars($row['cover']) . '">
                </div>  

                <div>
                    <div class="evaluate_container flex flex-col items-center mb-8 z-0">
                        <div class="flex gap-4 w-100 justify-center">
                            <form action="saveDoneReadingRating.php" method="POST" class="flex flex-row gap-4 justify-center w-100">
                                 <label>
                                    <input type="hidden" name="bookId" value="' . htmlspecialchars($row['id']) . '">
                                </label>
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
                            </form>
                        </div>
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

    $sql = "SELECT * FROM books_to_read WHERE userId=? LIMIT 10";
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
    global $pdo;
    // $userId aus login nehmen, um Userlisten zu zeigen  
    $userId = $_SESSION['userId'];
    $limit = (int) $limit;
    $offset = (int) $offset;

    $sql = "SELECT * FROM books_read WHERE userId=? LIMIT ? OFFSET ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$userId, $limit, $offset]);
    return $stmt->fetchAll();
}

function getFavs($limit, $offset)
{
    global $pdo;
    // $userId aus login nehmen, um Userlisten zu zeigen  
    $userId = $_SESSION['userId'];

    $limit = (int) $limit;
    $offset = (int) $offset;

    $sql = "SELECT * FROM books_fav WHERE userId=? LIMIT ? OFFSET ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$userId, $limit, $offset]);
    
    return $stmt->fetchAll();
}

function getToBeRead($limit, $offset)
{
    global $pdo;
    // $userId aus login nehmen, um Userlisten zu zeigen  
    $userId = $_SESSION['userId'];
    $limit = (int) $limit;
    $offset = (int) $offset;

    $sql = "SELECT * FROM books_to_read WHERE userId=? LIMIT ? OFFSET ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$userId, $limit, $offset]);

    return $stmt->fetchAll();   
}

function addEvalFav($eval, $userId, $bookId)
{
    global $pdo;

    // 1. Prüfen, ob das Buch zum eingeloggten User gehört
    $stmt = $pdo->prepare("SELECT id FROM books_fav WHERE id = ? AND userId = ?");
    $stmt->execute([ $userId, $bookId]);

    if ($stmt->rowCount() === 0) {
        throw new Exception("Dieses Buch gehört nicht zu diesem Nutzeer.");
    };

    // 2. Wenn alles passt, Bewertung speichern
    $sql = 'INSERT INTO eval_books (evaluation, userId, bookId) VALUES(?,?,?)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$eval, $userId, $bookId]);
    return $stmt->rowCount();
}

function addEvalDone($eval, $userId, $bookId)
{
    global $mysqli;

    // Prüfen, ob das Buch zum eingeloggten User gehört
    $stmt = $mysqli->prepare("SELECT id FROM books_read WHERE id = ? AND userId = ?");
    $stmt->bind_param("ii", $bookId, $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        throw new Exception("Dieses Buch gehört nicht zu diesem User.");
    }

    // Wenn alles passt, Bewertung speichern
    $sql = 'INSERT INTO eval_books (evaluation, user_id, bookId) VALUES(?,?,?)';
    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        throw new Exception('Fehlermeldung: ' . $mysqli->error);
    }
    $stmt->bind_param('iii', $eval, $userId, $bookId);
    if (!$stmt->execute()) {
        throw new Exception('Fehlermeldung: ' . $stmt->error);
    }
    return $stmt->affected_rows;
}