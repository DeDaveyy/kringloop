<?php
// Database config
$dbHost = 'localhost';
$dbName = 'duurzaam';
$dbUser = 'root';
$dbPass = '';

// Database connectie met PDO
try {
    $pdo = new PDO("mysql:host={$dbHost};dbname={$dbName}", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connectie gefaald: " . $e->getMessage());
}
?>