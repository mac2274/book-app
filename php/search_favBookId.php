<?php
// Test ob id gefunden wird!
require_once '../config/config.db.php';
require_once '../config/lib.php';

$result = $mysqli->query("SELECT id FROM books_fav ORDER BY id ASC");
while ($row = $result->fetch_assoc()) {
    echo $row['id'] . "<br>";
}
