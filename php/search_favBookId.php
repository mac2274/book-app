<?php
// Test ob id gefunden wird!
require_once '../config/config.db.php';
require_once '../config/lib.php';

$stmt = $pdo->query("SELECT id FROM books_fav ORDER BY id ASC");
foreach ($stmt->fetchAll() as $row) {
    echo $row['id'] . "<br>";
}


// <?php
// // Test ob id gefunden wird!
// require_once '../config/config.db.php';
// require_once '../config/lib.php';

// $result = $mysqli->query("SELECT id FROM books_fav ORDER BY id ASC");
// while ($row = $result->fetch_assoc()) {
//     echo $row['id'] . "<br>";
// }