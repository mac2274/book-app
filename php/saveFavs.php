<?php
header('Content-Type: application/json');

require_once '../config/config.db.php';
require_once '../config/lib.php';

// hier werden Daten vom FE (JS) geholt
$data = json_decode(file_get_contents('php://input'), true);

// wenn keine Daten enthalten:
if (!$data) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Keine Dateien empfangen'
    ]);
    exit;
}

try {
    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];
    }
    $affectedRows = saveToFavs($data); // Funktion zum Speichern der Bücher in Favs
    echo json_encode([
        'success' => true,
        'insertesRows' => $affectedRows,
        'message' => 'Du hast das Buch zu deinen Favouriten hinzugefügt!'
    ]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}