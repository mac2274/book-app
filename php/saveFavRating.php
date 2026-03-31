<?php
header('Content-Type: application/json');

require_once '../config/config.db.php';
require_once '../config/lib.php';

try {
    // 1. bookId check
    if (!isset($_POST['bookId'])) {
        throw new Exception(('bookId fehlt!'));
    }
    $bookId = (int) $_POST['bookId']; // aus dem HTML nehmen

    $stmt = $pdo->prepare("SELECT id FROM books_fav WHERE id = ?");
    $stmt->execute([$bookId]);

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
    $userID = (int) $_SESSION['userID']; // aus Session
    $eval = (int) $_POST['evaluation_book']; // 1 oder 0

    $row = addEvalFav($eval, $userID, $bookId);

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




