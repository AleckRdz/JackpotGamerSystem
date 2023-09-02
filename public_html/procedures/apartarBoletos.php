<?php
// Replace 'jackpotGamer.db' with the path to your existing SQLite database file
$db_path = '../db/jackpotGamer.db';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form data from the POST request
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $estado = $_POST['estado'];

    // get the number of boletos to fetch from the request
    $numeros = $_POST['numeros'];
    $numeroArray = explode(', ', $numeros); // Assuming numbers are separated by comma and space

    $numeroValues = "'" . implode(
        "', '",
        $numeroArray
    ) . "'";

    // Perform additional validation here if needed
    // ...

    try {
        // Connect to the database
        $db = new SQLite3($db_path);
        
        //check if the boletos exists, if not, return an error message
        $query = "SELECT numero FROM boletos WHERE numero IN ($numeroValues) AND edicion = (SELECT idRifa FROM rifas WHERE estado = 1)";
        $result = $db->query($query);

        $boletos = array();
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $boletos[] = $row['numero'];
        }

        //if different from the number of boletos requested, return an error message
        if (count($boletos) != count($numeroArray)) {
            //if array diff returns more than one send a message with the numbers that don't exist, else, send a message with the number that doesn't exist
            if (count(array_diff($numeroArray, $boletos)) > 1)
                $response = array('status' => 0, 'message' => 'Los boletos ' . implode(', ', array_diff($numeroArray, $boletos)) . ' no existen, intente con otros.');
            else
                $response = array('status' => 0, 'message' => 'El boleto ' . implode(', ', array_diff($numeroArray, $boletos)) . ' no existe, intente con otro.');
            header('Content-Type: application/json');
            echo json_encode($response);
            exit();
        }

        //check if the boletos are taken
        $query = "SELECT numero FROM boletos WHERE numero IN ($numeroValues) AND edicion = (SELECT idRifa FROM rifas WHERE estado = 1) AND estado != 0";
        $result = $db->query($query);

        $boletos = array();
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $boletos[] = $row['numero'];
        }
        
        if (count($boletos) > 1) {
            $response = array('status' => 0, 'message' => 'Los boletos ' . implode(', ', $boletos) . ' acaban de ser apartados por alguien más, intente con otros.');
            header('Content-Type: application/json');
            echo json_encode($response);
            exit();
        }
        
        if (count($boletos) > 0) {
            $response = array('status' => 0, 'message' => 'El boleto ' . implode(', ', $boletos) . ' acaba de ser apartado por alguien más, intente con otro.');
            header('Content-Type: application/json');
            echo json_encode($response);
            exit();
        }

        // apartar el boleto
        $query = "UPDATE boletos SET nombre = :nombre, telefono = :telefono, origen = :origen, fechaApartado = :fecha, estado = 1 WHERE numero IN ($numeroValues) AND edicion = (SELECT idRifa FROM rifas WHERE estado = 1)";
        $stmt = $db->prepare($query);
        $stmt->bindValue(':nombre', $nombre, SQLITE3_TEXT);
        $stmt->bindValue(':telefono', $telefono, SQLITE3_TEXT);
        $stmt->bindValue(':origen', $estado, SQLITE3_TEXT);
        $stmt->bindValue(':fecha', date('Y-m-d H:i:s'), SQLITE3_TEXT);
        $result = $stmt->execute();

        //get the precio of the boletos
        $query = "SELECT precioBoleto FROM rifas WHERE estado = 1";
        $result = $db->query($query);
        $row = $result->fetchArray(SQLITE3_ASSOC);
        $precio = $row['precioBoleto'];

        //get the total price
        $total = $precio * count($numeroArray);

        //get the oportunidades from the boletos apartados
        $query = "SELECT oportunidades FROM boletos WHERE edicion = (SELECT idRifa FROM rifas WHERE estado = 1) AND numero IN ($numeroValues)";
        $result = $db->query($query);
        //concatenate all the oportunidades separated by commas
        $oportunidades = '';
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $oportunidades .= $row['oportunidades'] . ', ';
        }
        
        //remove the last comma
        $oportunidades = substr($oportunidades, 0, -2);            

        if ($result) {
            $response = array('status' => 1, 'message' => 'Boletos apartados correctamente.', 'total' => $total, 'oportunidades' => $oportunidades);
            //return response with the data
        } else {
            // return an error code (e.g., 0)
            $response = array('status' => 0, 'message' => 'Ha ocurrido un error, contacte a soporte.');
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
