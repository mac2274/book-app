<?php
$mysqli = new mysqli('db', 'root', 'test', 'booksApp');
 
if ($mysqli->connect_error) {
    throw new Exception('mysqli-Verbindungsfehler' . $mysqli->connect_error);
}
?>