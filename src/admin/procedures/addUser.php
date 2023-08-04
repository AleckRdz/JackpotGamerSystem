<?php
// Replace 'jackpotGamer.db' with the path to your existing SQLite database file
$db_path = '../../db/jackpotGamer.db';

try {
    // Connect to the database
    $db = new SQLite3($db_path);

    // Data for the new user (you can get this data from your HTML form or any other source)
    $nombre = "Aleck Jesús Zúñiga Rodríguez";
    $usuario = "aleckrdz";
    $contrasena = password_hash("xpbsxbyf5", PASSWORD_DEFAULT); // Hash the password
    $correo = "rdzaleck@gmail.com";
    $rol = "Administrador";

    // Prepare the SQL statement to insert the new user
    $query = "INSERT INTO usuarios (nombre, usuario, contrasena, correo, rol) VALUES (:nombre, :usuario, :contrasena, :correo, :rol)";
    $stmt = $db->prepare($query);
    $stmt->bindValue(':nombre', $nombre, SQLITE3_TEXT);
    $stmt->bindValue(':usuario', $usuario, SQLITE3_TEXT);
    $stmt->bindValue(':contrasena', $contrasena, SQLITE3_TEXT);
    $stmt->bindValue(':correo', $correo, SQLITE3_TEXT);
    $stmt->bindValue(':rol', $rol, SQLITE3_TEXT);

    // Execute the statement
    $result = $stmt->execute();

    if ($result) {
        echo "User added successfully.";
    } else {
        echo "Failed to add user.";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
