<?php
header('Content-Type: application/json');

require_once 'config.db.php';
require_once 'lib.php';

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
    $affectedRows = saveToReads($data);
    echo json_encode([
        'success' => true,
        'message' => 'Das Buch wurde zu deiner noch-zu-lesende-Bücher - Liste hinzugefügt!',
        'insertedRows' => $affectedRows
    ]);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
 