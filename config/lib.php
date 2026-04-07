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
    if (strlen($password) < 8) {
        $errorMessage[] = "Passwort muss mindestens 8 Zeichen lang sein";
    }
    if (!preg_match('/[A-Z]/', $password)) {
        $errorMessage[] = "Passwort muss mindestens einen Großbuchstaben enthalten";
    }
    if (!preg_match('/[a-z]/', $password)) {
        $errorMessage[] = "Passwort muss mindestens einen Kleinbuchstaben enthalten";
    }
    if (!preg_match('/\d/', $password)) {
        $errorMessage[] = "Passwort muss mindestens eine Zahl enthalten";
    }
    if (!preg_match('/[@$!%*?&]/', $password)) {
        $errorMessage[] = "Passwort muss mindestens ein Sonderzeichen (@$!%*?&) enthalten";
    }
    return $errorMessage;
}

function registerUser($name, $surname, $email, $password)
{
    global $pdo;

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
            $_SESSION['user_id'] = $row['id'];  // ← immer klein 'd'
            $_SESSION['loginDone'] = true;
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function saveToFavs($data)
{
    global $pdo;

    if (!isset($_SESSION['user_id'])) {
        throw new Exception('User ist nicht eingeloggt.');
    }
    $user_id = $_SESSION['user_id'];

    // Prüfung, ob Buch bereits hinzugefügt
    $check = $pdo->prepare("SELECT id FROM books_fav WHERE title=? AND user_id=?");
    $check->execute([$data['title'], $user_id]);
    if ($check->rowCount() > 0) {
        throw new Exception('Buch ist bereuts in der Liste vorhanden.');
    }

    $sql = 'INSERT INTO books_fav (title, author, subtitle, description, cover, user_id) VALUES(?,?,?,?,?,?)';
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        $data['title'],
        $data['author'],
        $data['subtitle'],
        $data['description'],
        $data['cover'],
        $user_id
    ]);
}

function saveToDone($data)
{
    global $pdo;

    if (!isset($_SESSION['user_id'])) {
        throw new Exception('User ist nicht eingeloggt.');
    }
    $user_id = $_SESSION['user_id'];

    $sql = 'INSERT INTO books_read (title, author, cover, user_id) VALUES(?,?,?,?)';
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        $data['title'],
        $data['author'],
        $data['cover'],
        $user_id
    ]);
}

function saveToReads($data)
{
    global $pdo;

    if (!isset($_SESSION['user_id'])) {
        throw new Exception('User ist nicht eingeloggt.');
    }
    $user_id = $_SESSION['user_id'];

    $sql = 'INSERT INTO books_to_read (title, author, subtitle, description, cover, "userID") VALUES(?,?,?,?,?,?)';
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        $data['title'],
        $data['author'],
        $data['subtitle'],
        $data['description'],
        $data['cover'],
        $user_id
    ]);
}

function showFavs($user_id) // Vorher muss $user_id = $_SESSION['user_id'] sein!
{
    global $pdo;

    $sql = 'SELECT * FROM books_fav WHERE user_id=? LIMIT 10';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id]);
    $rows = $stmt->fetchAll();

    if (count($rows) === 0) {
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
                                            <svg class="likeSvgEmpty w-9 hover:text-green-600 transition-colors duration-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                                <path d="M1 21h4V9H1v12zm22-11c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32c0-.41-.17-.79-.44-1.06L14.17 1 7.59 7.59C7.22 7.95 7 8.45 7 9v10c0 1.1.9 2 2 2h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-2z"/>
                                            </svg>
                                            <svg class="likeSvgFilled w-9 hidden text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M1 21h4V9H1v12zm22-11c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32c0-.41-.17-.79-.44-1.06L14.17 1 7.59 7.59C7.22 7.95 7 8.45 7 9v10c0 1.1.9 2 2 2h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-2z"/>
                                            </svg>
                                        </label>
                                        <label class="thumb_dislike flex flex-col items-center">
                                            <input type="radio" value="0" name="evalution_book" class="dislike hidden">
                                            <svg class="dislikeSvgEmpty rotate-180 w-9 hover:text-red-600 transition-colors duration-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                                <path d="M1 21h4V9H1v12zm22-11c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32c0-.41-.17-.79-.44-1.06L14.17 1 7.59 7.59C7.22 7.95 7 8.45 7 9v10c0 1.1.9 2 2 2h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-2z"/>
                                            </svg>
                                            <svg class="dislikeSvgFilled rotate-180 w-9 hidden text-red-600" fill="currentColor" viewBox="0 0 24 24">
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

function showDoneReading($user_id)
{
    global $pdo;

    $sql = 'SELECT * FROM books_read WHERE user_id=? LIMIT 10';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id]);
    $rows = $stmt->fetchAll();

    if (count($rows) === 0) {
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
                <div class="flex flex-row gap-x-4 gap-y-4 justify-center items-center py-4"> 
                    <p class="flex flex-col w-100 text-center">
                        <span class="italic text-xl">' . htmlspecialchars($row['title'] ?? 'Kein Titel') . '</span>
                        <span class="text-sm">- ' . htmlspecialchars($row['author'] ?? 'Unbekannt') . ' - </span>
                    </p>
                    <img class="pb-8" src="' . htmlspecialchars($row['cover']) . '">
                </div>  
                <div>
                    <div class="evaluate_container flex flex-col items-center mb-8 z-0">
                        <div class="flex gap-4 w-100 justify-center">
                            <form action="saveDoneReadingRating.php" method="POST" class="flex flex-row gap-4 justify-center w-100">
                                <label>
                                    <input type="hidden" name="bookId" value="' . htmlspecialchars($row['id']) . '">
                                </label>
                                <div class="flex justify-center gap-4 w-100">
                                    <label for="like" class="thumb_like flex flex-col items-center">
                                        <input type="radio" value="1" name="evalution_book" class="like hidden">
                                        <svg class="likeSvgEmpty w-9 hover:text-green-600 transition-colors duration-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                            <path d="M1 21h4V9H1v12zm22-11c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32c0-.41-.17-.79-.44-1.06L14.17 1 7.59 7.59C7.22 7.95 7 8.45 7 9v10c0 1.1.9 2 2 2h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-2z"/>
                                        </svg>
                                        <svg class="likeSvgFilled w-9 hidden text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                            <desc>Dieses Buch gefällt mir!</desc>
                                            <path d="M1 21h4V9H1v12zm22-11c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32c0-.41-.17-.79-.44-1.06L14.17 1 7.59 7.59C7.22 7.95 7 8.45 7 9v10c0 1.1.9 2 2 2h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-2z"/>
                                        </svg>
                                    </label>
                                    <label for="dislike" class="thumb_dislike flex flex-col items-center">
                                        <input type="radio" value="0" name="evalution_book" class="dislike hidden">
                                        <svg class="dislikeSvgEmpty rotate-180 w-9 hover:text-red-600 transition-colors duration-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                            <path d="M1 21h4V9H1v12zm22-11c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32c0-.41-.17-.79-.44-1.06L14.17 1 7.59 7.59C7.22 7.95 7 8.45 7 9v10c0 1.1.9 2 2 2h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-2z"/>
                                        </svg>
                                        <svg class="dislikeSvgFilled rotate-180 w-9 hidden text-red-600" fill="currentColor" viewBox="0 0 24 24">
                                            <desc>Dieses Buch gefällt mir nicht.</desc>
                                            <path d="M1 21h4V9H1v12zm22-11c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32c0-.41-.17-.79-.44-1.06L14.17 1 7.59 7.59C7.22 7.95 7 8.45 7 9v10c0 1.1.9 2 2 2h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-2z"/>
                                        </svg>
                                    </label>              
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <hr>
            </li>';
    }
}

function showToRead($user_id)
{
    global $pdo;

    $sql = 'SELECT * FROM books_to_read WHERE user_id=? LIMIT 10';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id]);
    $rows = $stmt->fetchAll();

    if (count($rows) === 0) {
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

function getDoneReading($user_id, $limit, $offset)
{
    global $pdo;

    $limit = (int) $limit;
    $offset = (int) $offset;

    $sql = 'SELECT * FROM books_read WHERE user_id=? LIMIT ? OFFSET ?';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id, $limit, $offset]);
    return $stmt->fetchAll();
}

function getFavs($user_id, $limit, $offset)
{
    global $pdo;

    $limit = (int) $limit;
    $offset = (int) $offset;

    $sql = 'SELECT * FROM books_fav WHERE user_id=? LIMIT ? OFFSET ?';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id, $limit, $offset]);
    return $stmt->fetchAll();
}

function getToBeRead($limit, $offset)
{
    global $pdo;

    $user_id = $_SESSION['user_id'];
    ;
    $limit = (int) $limit;
    $offset = (int) $offset;

    $sql = 'SELECT * FROM books_to_read WHERE user_id=? LIMIT ? OFFSET ?';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id, $limit, $offset]);
    return $stmt->fetchAll();
}

function addEvalFav($eval, $user_id, $book_id)
{
    global $pdo;

    $stmt = $pdo->prepare('SELECT id FROM books_fav WHERE id = ? AND user_id = ?');
    $stmt->execute([$book_id, $user_id]);

    if ($stmt->rowCount() === 0) {
        throw new Exception("Dieses Buch gehört nicht zu diesem User.");
    }

    $sql = 'INSERT INTO eval_books (evaluation, user_id, book_id) VALUES(?,?,?)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$eval, $user_id, $book_id]);
    return $stmt->rowCount();
}

function addEvalDone($eval, $user_id, $book_id)
{
    global $pdo;

    $stmt = $pdo->prepare('SELECT id FROM books_read WHERE id = ? AND "user_id" = ?');
    $stmt->execute([$book_id, $user_id]);

    if ($stmt->rowCount() === 0) {
        throw new Exception("Dieses Buch gehört nicht zu diesem User.");
    }

    $sql = 'INSERT INTO eval_books (evaluation, user_id, book_id) VALUES(?,?,?)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$eval, $user_id, $book_id]);
    return $stmt->rowCount();
}
