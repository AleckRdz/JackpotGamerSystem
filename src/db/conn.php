<?php
// Replace 'your_database.db' with the actual path to your SQLite database file
$databaseFile = 'jackpotGamerDB.db';

try {
    $pdo = new PDO("sqlite:$databaseFile");
    // Set error handling to throw exceptions on errors
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Handle connection errors here
    die("Connection failed: " . $e->getMessage());
}
?>