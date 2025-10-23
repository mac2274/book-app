<?php
// macht installierte Packages verfügbar mit autoload
require_once __DIR__ . "/../vendor/autoload.php";
// Datei einlesen
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/..");
// parsen
$dotenv->load();
// VALIDIERUNG direkt nach load()
$dotenv->required(['MYSQL_HOST', 'MYSQL_USER', 'MYSQL_PASSWORD', 'MYSQL_DATABASE']);


$host = $_ENV['MYSQL_HOST'] ?? 'localhost';
$user = $_ENV['MYSQL_USER'] ?? 'root';
$pwd = $_ENV['MYSQL_PASSWORD'] ?? '';
$db = $_ENV['MYSQL_DATABASE'] ?? 'meine_datenbank';

$mysqli = new mysqli($host, $user, $pwd, $db);

if ($mysqli->connect_error) {
    throw new Exception('mysqli-Verbindungsfehler' . $mysqli->connect_error);
}
?>