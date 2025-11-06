<?php
require_once '../config/config.db.php';
require_once '../config/lib.php';

$bookId = (int) $_POST['bookId'];
$stmt = $mysqli->prepare("SELECT id FROM books_fav WHERE id = $bookId");
if (!$stmt){
    throw new Exception('Fehler bei der Datenbankverbindung:' . $mysqli->error);
}
$stmt->bind_param('i', $bookId);
if(!$stmt->execute()) {
    throw new Exception('Fehler:' . $stmt->error);
}
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    die("Buch existiert nicht!");
}

if (isset($_POST['evaluation_book']) && isset($_SESSION['userId'])) {
    $userId = (int) $_SESSION['userId'];
    $bookId = (int) $_POST['bookId']; // aus dem HTML nehmen
    $eval = (int) $_POST['evaluation_book']; // 1 oder 0

    try {
        $row = addEvalFav($eval, $userId, $bookId);
        if ($row > 0) {
            echo "Bewertung gespeichert!";
        } else {
            echo "Keine Bewertung gespeichert.";
        }

    } catch (Exception $e) {
        echo "Fehler: " . $e->getMessage();
    }
}


