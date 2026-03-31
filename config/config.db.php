<?php
// Autoload für Composer-Packages
require_once __DIR__ . "/../vendor/autoload.php";

// ausgeklammert, weil Render genutzt wird
// // Datei einlesen
// $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/..");
// // parsen
// $dotenv->load();
// // VALIDIERUNG direkt nach load()

// Hilfsfunktion für ENV
function env($key) {
    return $_ENV[$key] ?? getenv($key);
}

// ENV Variablen
$host = env('PG_HOST');
$user = env('PG_USER');
$pwd  = env('PG_PASSWORD');
$db   = env('PG_DATABASE');
$port = env('PG_PORT') ?? '5432';

// Verbindung
try {
    $pdo = new PDO(
        "pgsql:host=$host;port=$port;dbname=$db",
        $user,
        $pwd,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $e) {
    die('Datenbankverbindungsfehler: ' . $e->getMessage());
}