<?php
$mysqli = new mysqli('127.0.0.1', 'root', 'jfE5bO@Pul1g:kZQ', 'booksApp');
 
if ($mysqli->connect_error) {
    throw new Exception('mysqli-Verbindungsfehler' . $mysqli->connect_error);
}
?>