<?php
// Replace 'jackpotGamer.db' with the path to your SQLite database file
$db_path = '../../db/jackpotGamer.db';

try {
    // Connect to the database
    $db = new SQLite3($db_path);

    // SQL query to update the 'boletos' table by adding a new column 'digitos'
    $query = "ALTER TABLE rifas ADD COLUMN digitos INTEGER NOT NULL";

    // Execute the query
    $db->exec($query);

    echo "Table 'boletos' updated successfully with new column 'digitos'!";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
// Close the database connection
$db->close();
