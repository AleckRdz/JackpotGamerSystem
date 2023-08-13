<?php
// Replace 'jackpotGamer.db' with the path to your existing SQLite database file
$db_path = '../../db/jackpotGamer.db';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form data from the POST request
    $boleto = $_POST['boleto'];
    $tipo = $_POST['tipo'];

    // Perform additional validation here if needed
    // ...

    try {
        // Connect to the database
        $db = new SQLite3($db_path);

        //validate if the number exists
        $query = "SELECT numero FROM boletos WHERE numero = :boleto AND edicion = (SELECT idRifa FROM rifas WHERE estado = 1)";
        $stmt = $db->prepare($query);
        $stmt->bindValue(':boleto', $boleto, SQLITE3_TEXT);
        $result = $stmt->execute();
        $row = $result->fetchArray();

        if (!$row) {
            // Number does not exist, return an error code (e.g., 0)
            $response = array('status' => 0, 'message' => 'El boleto no existe.');

            // Return the JSON response
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        $query = "UPDATE boletos SET estado = :tipo WHERE numero = :boleto AND edicion = (SELECT idRifa FROM rifas WHERE estado = 1)";
        $stmt = $db->prepare($query);
        $stmt->bindValue(':boleto', $boleto, SQLITE3_TEXT);
        $stmt->bindValue(':tipo', $tipo, SQLITE3_NUM);
        $result = $stmt->execute();

        if ($result) {
            // User updated successfully, return a success code (e.g., 1)
            $response = array('status' => 1, 'message' => 'Boleto procesado correctamente.');
        } else {
            // Failed to update the user, return an error code (e.g., 0)
            $response = array('status' => 0, 'message' => 'Ha ocurrido un error: ' . $db->lastErrorMsg() . '');
        }

        // Return the JSON response
        header('Content-Type: application/json');
        echo json_encode($response);
    } catch (Exception $e) {
        // Error occurred, return an error code (e.g., -1)
        $response = array('status' => -1, 'message' => 'Error: ' . $e->getMessage());

        // Return the JSON response
        header('Content-Type: application/json');
        echo json_encode($response);
    }
} else {
    // Invalid request method, return an error code (e.g., -1)
    $response = array('status' => -1, 'message' => 'Ha ocurrido un error, contacte a soporte.');

    // Return the JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
}
// Close the database connection
$db->close();
