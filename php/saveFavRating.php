<?php
header('Content-Type: application/json');

require_once '../config/config.db.php';
require_once '../config/lib.php';

try {
    // 1. bookId check
    if (!isset($_POST['bookId'])) {
        throw new Exception(('bookId fehlt!'));
    }
    $book_id = (int) $_POST['bookId']; // aus dem HTML nehmen

    $stmt = $pdo->prepare("SELECT id FROM books_fav WHERE id = ?");
    $stmt->execute([$book_id]);

    // 2. Existiert das Buch wirklich in der DB?
    if ($stmn->rowCount() === 0) {
        throw new Exception("Buch existiert nicht!");
    }

    // 3. Ist der User eingeloggt?
    if (!isset($_SESSION['userID'])) {
        throw new Exception('Nicht eingeloggt!');
    }

    // 4. Gibtes eine Bewertung
    if (!isset($_POST['evaluation_book'])) {
        throw new Exception('Bewertung fehlt!');
    }

    // Hier wird die Bewertung des Buchs gespeichert anhand Variablen
    $user_id = (int) $_SESSION['user_id']; // aus Session
    $eval = (int) $_POST['evaluation_book']; // 1 oder 0

    $row = addEvalFav($eval, $user_id, $book_id);

    echo json_encode([
        "success" => true,
        "message" => "Bewertung gespeichert",
        "rows" => $row 
    ]);

} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}




