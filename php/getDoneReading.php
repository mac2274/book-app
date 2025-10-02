<?php
require_once 'config.db.php';
require_once 'lib.php';

header('Content-Type: application/json');

$limit = $_GET['limit'] ?? 10;
$offset = $_GET['offset'] ?? 10;

try {
    // funktion zum Abruf neuer Bücher wird aufgerufen
    $books = getDoneReading((int)$limit, (int)$offset);
    echo json_encode($books);
    // echo print_r($books);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'message' => $e->getMessage()
    ]);
}
?>