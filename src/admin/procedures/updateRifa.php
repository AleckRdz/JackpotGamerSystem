<?php
// Replace 'jackpotGamer.db' with the path to your existing SQLite database file
$db_path = '../../db/jackpotGamer.db';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form data from the POST request
    $id = $_POST['id'];
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

        //assign the number of tickets of the raffle to a variable
        $query = "SELECT cantidadBoletos FROM rifas WHERE idRifa = :id";
        $stmt = $db->prepare($query);
        $stmt->bindValue(':id', $id, SQLITE3_TEXT);
        $result = $stmt->execute();
        $row = $result->fetchArray(SQLITE3_ASSOC);
        $cantidadBoletosOld = $row['cantidadBoletos'];

        //if the raffle is active, send a message to the user and return
        if($estado == 1 && ($cantidadBoletosOld != $cantidadBoletos)){
            $response = array('status' => 0, 'message' => 'No puedes modificar la cantidad de boletos cuando la rifa está activa.');
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        //deactivate all raffles if this is active
        if($estado == 1){
            $query = "UPDATE rifas SET estado = 0 WHERE estado = 1";
            $stmt = $db->prepare($query);
            $result = $stmt->execute();
        }
        
        $query = "UPDATE rifas SET producto = :producto, cantidadBoletos = :cantidadBoletos, precioBoleto = :precioBoleto, oportunidades = :oportunidades, fechaRifa = :fechaRifa, estado = :estado WHERE idRifa = :id";
        $stmt = $db->prepare($query);
        $stmt->bindValue(':id', $id, SQLITE3_TEXT);
        $stmt->bindValue(':producto', $producto, SQLITE3_TEXT);
        $stmt->bindValue(':cantidadBoletos', $cantidadBoletos, SQLITE3_TEXT);
        $stmt->bindValue(':precioBoleto', $precioBoleto, SQLITE3_TEXT);
        $stmt->bindValue(':oportunidades', $oportunidades, SQLITE3_TEXT);
        $stmt->bindValue(':fechaRifa', $fechaRifa, SQLITE3_TEXT);
        $stmt->bindValue(':estado', $estado, SQLITE3_TEXT);
        $result = $stmt->execute();               

        if ($result) {
            
            // delete all the rows above the new number of tickets of the raffle on the boletos table if it is less than the old number
            if($cantidadBoletosOld > $cantidadBoletos){
                $query = "DELETE FROM boletos WHERE edicion = :idRifa AND CAST(numero AS INTEGER) >= :cantidadBoletos";
                $stmt = $db->prepare($query);
                $stmt->bindValue(':idRifa', $id, SQLITE3_TEXT);
                $stmt->bindValue(':cantidadBoletos', $cantidadBoletos, SQLITE3_TEXT);
                $result = $stmt->execute();
            }

            // add all the rows above the new number of tickets of the raffle on the boletos table if it is greater than the old number
            if($cantidadBoletosOld < $cantidadBoletos){
                for($i = $cantidadBoletosOld; $i < $cantidadBoletos; $i++){
                    $numero = str_pad($i, 5, '0', STR_PAD_LEFT);
                    $emptyCol = '';
                    $estado = 0;
                    $query = "INSERT INTO boletos (numero, nombre, telefono, fechaApartado, fechaPagado, estado, edicion, origen) VALUES (:numero, :nombre, :telefono, :fechaApartado, :fechaPagado, :estado, :idRifa, :origen)";
                    $stmt = $db->prepare($query);
                    $stmt->bindValue(':idRifa', $id, SQLITE3_TEXT);
                    $stmt->bindValue(':numero', $numero, SQLITE3_TEXT);
                    $stmt->bindValue(':nombre', $emptyCol, SQLITE3_TEXT);
                    $stmt->bindValue(':telefono', $emptyCol, SQLITE3_TEXT);
                    $stmt->bindValue(':fechaApartado', $emptyCol, SQLITE3_TEXT);
                    $stmt->bindValue(':fechaPagado', $emptyCol, SQLITE3_TEXT);
                    $stmt->bindValue(':estado', $estado, SQLITE3_TEXT);
                    $stmt->bindValue(':origen', $emptyCol, SQLITE3_TEXT);
                    $result = $stmt->execute();
                }
            }

            if($result){
                // User updated successfully, return a success code (e.g., 1)
                $response = array('status' => 1, 'message' => 'Rifa actualizada correctamente.');
            }
            
        } else {
            // Failed to update the user, return an error code (e.g., 0)
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
