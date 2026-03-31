<?php
header('Content-Type: application/json');

require_once '../config/config.db.php';
require_once '../config/lib.php';

try {
    // 1. bookId prüfen
    if (!isset($_POST['bookId'])) {
        throw new Exception("bookId fehlt");
    }
    $bookId = (int) $_POST['bookId'];

    // 2. existiert Buch?
    $stmt = $pdo->prepare("SELECT id FROM books_read WHERE id = ?");
    $stmt->execute([$bookId]);
    if ($stmt->rowCount() === 0) {
        throw new Exception("Buch existiert nicht!");
    }

    // 3. user eingeloggt?
    if (!isset($_SESSION['userId'])) {
        throw new Exception('Nicht eingeloggt!');
    }

    // 4. Bewertung vorhanden?
    if (!isset($_POST['evaluation_book'])) {
        throw new Exception('Bewertung fehlt!');
    }

    $userId = (int) $_SESSION['userId'];
    $eval = (int) $_POST['evaluation_book']; // 1 oder 0

    $row = addEvalDone($eval, $userId, $bookId);

    echo json_encode([
        "success" => true,
        "message" => "Bewertung gespeichert.",
        "rows" => $row
    ]);

} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}







