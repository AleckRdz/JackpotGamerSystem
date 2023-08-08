<?php
// Replace 'jackpotGamer.db' with the path to your existing SQLite database file
$db_path = '../../db/jackpotGamer.db';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form data from the POST request
    $producto = $_POST['producto'];
    $cantidadBoletos = $_POST['cantidad'];
    $precioBoleto = $_POST['precio'];
    $oportunidades = $_POST['oportunidades'];
    $fechaRifa = $_POST['fecha'];
    $estado = $_POST['estado'];

    // Perform additional validation here if needed
    // ...
    
    try {
        // Connect to the database
        $db = new SQLite3($db_path);
        
        // Prepare the SQL statement to insert the new user into the 'usuarios' table
        $query = "INSERT INTO rifas (producto, cantidadBoletos, precioBoleto, oportunidades, fechaRifa, estado) VALUES (:producto, :cantidadBoletos, :precioBoleto, :oportunidades, :fechaRifa, :estado)";
        $stmt = $db->prepare($query);
        $stmt->bindValue(':producto', $producto, SQLITE3_TEXT);
        $stmt->bindValue(':cantidadBoletos', $cantidadBoletos, SQLITE3_TEXT);
        $stmt->bindValue(':precioBoleto', $precioBoleto, SQLITE3_TEXT);
        $stmt->bindValue(':oportunidades', $oportunidades, SQLITE3_TEXT);
        $stmt->bindValue(':fechaRifa', $fechaRifa, SQLITE3_TEXT);
        $stmt->bindValue(':estado', $estado, SQLITE3_TEXT);
        
        // Execute the statement to insert the rifa
        $result = $stmt->execute();

        if ($result) {
            // Rifa added successfully, return a success code (e.g., 1)
            $response = array('status' => 1, 'message' => 'Rifa creada correctamente.');
            
        } else {
            // Failed to add the rifa, return an error code (e.g., 0)
            $response = array('status' => 0, 'message' => 'Ha ocurrido un error.');
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
?>