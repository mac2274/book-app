<?php
require 'config.lib.php';

if (isset($_POST['evaluation_book']) && isset($_SESSION['userId']))
    $userId = (int) $_SESSION['userId'];
    $bookId = (int) $_POST['bookId']; // aus dem HTML nehmen
    $eval = (int) $_POST['evaluation_book']; // 1 oder 0

try {
    $row = addEval($userId, $bookId, $eval);
    if ($rows > 0) {
        echo "Bewertung gespeichert!";
    } else {
        echo "Keine Bewertung gespeichert.";
    }
} catch (Exception $e) {
    echo "Fehler: " . $e->getMessage();
}
?>