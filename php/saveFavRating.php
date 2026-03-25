<?php
require_once '../config/config.db.php';
require_once '../config/lib.php';

header('Content-Type: application/json');

try {
    if (!isset($_POST['bookId'])) {
        throw new Exception(('bookId fehlt!'));
    }
    $bookId = (int) $_POST['bookId']; // aus dem HTML nehmen

    $stmt = $mysqli->prepare("SELECT id FROM books_fav WHERE id = ?");
    if (!$stmt) {
        throw new Exception('Fehler bei der Datenbankverbindung:' . $mysqli->error);
    }
    $stmt->bind_param('i', $bookId);
    if (!$stmt->execute()) {
        throw new Exception('Fehler:' . $stmt->error);
    }
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        throw new Exception("Buch existiert nicht!");
    }

    if (!isset($_SESSION['userId'])) {
        throw new Exception('Nicht eingeloggt!');
    }

    if (!isset($_POST['evaluation_book'])) {
        throw new Exception('Bewertung fehlt!');
    }

    $userId = (int) $_SESSION['userId']; // aus Session
    $eval = (int) $_POST['evaluation_book']; // 1 oder 0

    $row = addEvalFav($eval, $userId, $bookId);
    
    echo json_encode([
        "success" => true,
        "message" => "Bewertung gespeichert",
        "rows" => $rows
    ]);

} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}




