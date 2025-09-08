<?php
$mysqli = new mysqli('db', 'root', 'jfE5bO@Pul1g:kZQ', 'searchBook');
 
if ($mysqli->connect_error) {
    throw new Exception('mysqli-Verbindungsfehler' . $mysqli->connect_error);
}

echo 'done!';
?>