<?php
// Replace 'jackpotGamer.db' with the path to your SQLite database file
$db_path = '../../db/jackpotGamer.db';

try {
    // Connect to the database
    $db = new SQLite3($db_path);

    $query = "DROP TABLE boletos";
    $db->exec($query);

    // SQL query to create the 'rifas' table
    $query = "CREATE TABLE IF NOT EXISTS boletos (
                idBoleto INTEGER PRIMARY KEY AUTOINCREMENT,
                numero TEXT NOT NULL,
                edicion INTEGER NOT NULL,
                nombre TEXT,
                telefono TEXT,
                origen TEXT,
                fechaApartado DATE,
                fechaPagado DATE,
                estado INTEGER NOT NULL
            )";

    // Execute the query
    $db->exec($query);

    echo "Table 'boletos' created successfully!";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
// Close the database connection
$db->close();
?>