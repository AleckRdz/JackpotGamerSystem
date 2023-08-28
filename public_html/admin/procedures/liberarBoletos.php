<?php
// Replace 'jackpotGamer.db' with the path to your existing SQLite database file
$db_path = '../../db/jackpotGamer.db';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Perform additional validation here if needed
    // ...

    try {
        // Connect to the database
        $db = new SQLite3($db_path);        

        // SQL query to update the boleto, set its estado to 0 and the other fields to empty values
        $query = "UPDATE boletos SET estado = 0, nombre = '', telefono = '', origen = '', fechaApartado = '', fechaPagado = '' WHERE estado = 1 AND edicion = (SELECT idRifa FROM rifas WHERE estado = 1)";
        $stmt = $db->prepare($query);
        $result = $stmt->execute();

        if ($result) {
            // boleto updated successfully, return a success code (e.g., 1)
            $response = array('status' => 1, 'message' => 'Boletos liberados correctamente.');
        } else {
            // Failed to update the boleto, return an error code (e.g., 0)
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
