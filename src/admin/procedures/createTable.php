<?php
// Replace 'jackpotGamer.db' with the path to your SQLite database file
$db_path = '../../db/jackpotGamer.db';

try {
    // Connect to the database
    $db = new SQLite3($db_path);

    $query = "DROP TABLE rifas";
    $db->exec($query);

    // SQL query to create the 'rifas' table
    $query = "CREATE TABLE IF NOT EXISTS rifas (
                idRifa INTEGER PRIMARY KEY AUTOINCREMENT,
                producto TEXT NOT NULL,
                cantidadBoletos INTEGER NOT NULL,
                precioBoleto REAL NOT NULL,
                oportunidades INTEGER NOT NULL,
                -- rutaImagen TEXT,
                fechaRifa DATE NOT NULL,
                estado INTEGER NOT NULL
            )";

    // Execute the query
    $db->exec($query);

    echo "Table 'rifas' created successfully!";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
// Close the database connection
$db->close();
?>