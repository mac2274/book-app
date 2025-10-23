 <?php
require_once '../config/config.db.php';
require_once '../config/lib.php';

header('Content-Type: application/json');

$limit = $_GET['limit'] ?? 10;
$offset = $_GET['offset'] ?? 10;

try{
    $books = getToBeRead($limit, $offset);
    echo json_encode($books);
} catch (Exception $e){
    http_response_code(500);
    echo json_encode([
        'message' => $e->getMessage()
    ]);
}
?>