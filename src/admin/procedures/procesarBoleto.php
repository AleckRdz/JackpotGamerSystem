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
        $query = "SELECT estado FROM boletos WHERE numero = :boleto AND edicion = (SELECT idRifa FROM rifas WHERE estado = 1)";
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

        if ($tipo == $row['estado']) {
            $response = array('status' => 0, 'message' => 'El boleto ya tiene dicho estado.');

            // Return the JSON response
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        if($tipo == 0 && $row['estado'] == 2){
            $response = array('status' => 0, 'message' => 'No se puede liberar un boleto pagado.');
            
            // Return the JSON response
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        if($tipo == 1 && $row['estado'] == 0){
            $response = array('status' => 0, 'message' => 'No se puede invalidar un boleto libre.');
            
            // Return the JSON response
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // if ($tipo == 2 && $row['estado'] == 0) {
        //     $response = array('status' => 0, 'message' => 'No se puede validar un boleto libre.');

        //     // Return the JSON response
        //     header('Content-Type: application/json');
        //     echo json_encode($response);
        //     return;
        // }

        if($tipo == 0){
            $query = "UPDATE boletos SET estado = :tipo, nombre = '', telefono = '', origen = '', fechaApartado = '' WHERE numero = :boleto AND edicion = (SELECT idRifa FROM rifas WHERE estado = 1)";
            $stmt = $db->prepare($query);
            $stmt->bindValue(':boleto', $boleto, SQLITE3_TEXT);
            $stmt->bindValue(':tipo', $tipo, SQLITE3_NUM);
            $result = $stmt->execute();
        } else if($tipo == 1){
            $query = "UPDATE boletos SET estado = :tipo, fechaPagado = '' WHERE numero = :boleto AND edicion = (SELECT idRifa FROM rifas WHERE estado = 1)";
            $stmt = $db->prepare($query);
            $stmt->bindValue(':boleto', $boleto, SQLITE3_TEXT);
            $stmt->bindValue(':tipo', $tipo, SQLITE3_NUM);
            $result = $stmt->execute();
        } else if($tipo == 2){
            $query = "UPDATE boletos SET estado = :tipo, fechaPagado = :fecha WHERE numero = :boleto AND edicion = (SELECT idRifa FROM rifas WHERE estado = 1)";
            $stmt = $db->prepare($query);
            $stmt->bindValue(':boleto', $boleto, SQLITE3_TEXT);
            $stmt->bindValue(':tipo', $tipo, SQLITE3_NUM);
            $stmt->bindValue(':fecha', date('Y-m-d H:i:s'), SQLITE3_TEXT);
            $result = $stmt->execute();
        }


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
