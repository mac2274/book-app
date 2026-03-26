<?php
// macht installierte Packages verfügbar mit autoload
require_once __DIR__ . "/../vendor/autoload.php";
// Datei einlesen
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/..");
// parsen
$dotenv->load();
// VALIDIERUNG direkt nach load()
$dotenv->required(['PG_HOST', 'PG_USER', 'PG_PASSWORD', 'PG_DATABASE', 'PG_PORT']);


$host = $_ENV['PG_HOST'];
$user = $_ENV['PG_USER'];
$pwd = $_ENV['PG_PASSWORD'];
$db = $_ENV['PG_DATABASE'];
$port = $_ENV['PG_PORT'] ?? '5432';

try {
    $pdo = new PDO("pgsql:host=$host; port=$port; dbname=$db", $user, $pwd, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    throw new Exception('Datenbankverbindungsfehler: ' . $e->getMessage());
}
?>