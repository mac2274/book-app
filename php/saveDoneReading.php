<?php
header('Content-Type: application/json');

require_once '../config/config.db.php';
require_once '../config/lib.php';

// hier werden Daten vom FE (JS) geholt
$data = json_decode(file_get_contents('php://input'), true);

if (!$data){
    http_response_code(400);
    echo json_encode([ 
        'success' => false,
        'message' => 'Keine Daten empfangen.'
    ]); 
}

try {
    $affectedRows = saveToDone($data); // Funktion zum Speichern der Bücher in doneReadings

    echo json_encode([ // was macht encode hier?
        'success' => true,
        'message' => 'Du hast das Buch in deine bereits-gelesen-Liste hinzugefügt!',
        'insertedRows' => $affectedRows
    ]);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}