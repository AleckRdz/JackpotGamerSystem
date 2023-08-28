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
    $digitos = $_POST['digitos'];
    switch ($digitos) {
        case 2:
            $maxNumber = 99;
            break;
        case 3:
            $maxNumber = 999;
            break;
        case 4:
            $maxNumber = 9999;
            break;
        case 5:
            $maxNumber = 99999;
            break;
    }
    // Generate an array of all possible numbers
    $allNumbers = range($cantidadBoletos, $maxNumber);    

    // Perform additional validation here if needed
    // ...
    
    try {
        // Connect to the database
        $db = new SQLite3($db_path);

        //deactivate all raffles if this is active
        if ($estado == 1) {
            $query = "UPDATE rifas SET estado = 0 WHERE estado = 1";
            $stmt = $db->prepare($query);
            $result = $stmt->execute();
        }
        
        // Prepare the SQL statement to insert the new user into the 'usuarios' table
        $query = "INSERT INTO rifas (producto, cantidadBoletos, precioBoleto, oportunidades, fechaRifa, estado, digitos) VALUES (:producto, :cantidadBoletos, :precioBoleto, :oportunidades, :fechaRifa, :estado, :digitos)";
        $stmt = $db->prepare($query);
        $stmt->bindValue(':producto', $producto, SQLITE3_TEXT);
        $stmt->bindValue(':cantidadBoletos', $cantidadBoletos, SQLITE3_TEXT);
        $stmt->bindValue(':precioBoleto', $precioBoleto, SQLITE3_TEXT);
        $stmt->bindValue(':oportunidades', $oportunidades, SQLITE3_TEXT);
        $stmt->bindValue(':fechaRifa', $fechaRifa, SQLITE3_TEXT);
        $stmt->bindValue(':estado', $estado, SQLITE3_TEXT);
        $stmt->bindValue(':digitos', $digitos, SQLITE3_TEXT);
        
        // Execute the statement to insert the rifa
        $result = $stmt->execute();
        $idRifa = $db->lastInsertRowID();
        
        if ($result) {            
            //insert into boletos table the number of rows specified in cantidadBoletos
            for($i = 0; $i < $cantidadBoletos; $i++) {
                //insert into column oportunidades a string containing n numbers separated by commas, the last one has a dot at the end, where n is the number of opportunities specified in oportunidades variable, also these numbers are generated randomly and must be only numbers above the number in cantidadBoletos variable, if oportunidades is 1 then insert empty string
                if ($oportunidades == 1) {
                    $oportunidadesCol = '';
                } else {
                    $selectedNumbers = [];
                    for ($j = 0; $j < $oportunidades-1; $j++) {
                        if (empty($allNumbers)) {
                            break; // No more available unique numbers
                        }

                        $index = array_rand($allNumbers);
                        $selectedNumbers[] = $allNumbers[$index];
                        unset($allNumbers[$index]);
                    }

                    // Format the selected numbers
                    $oportunidadesCol = implode(', ', $selectedNumbers) . '';
                }
                
                //add zeros to the left of the number until it haves n digits
                $numero = str_pad($i, $digitos, '0', STR_PAD_LEFT);
                $emptyCol = '';
                $estado = 0;
                $query = "INSERT INTO boletos (numero, oportunidades, nombre, telefono, fechaApartado, fechaPagado, estado, edicion, origen) VALUES (:numero, :oportunidades, :nombre, :telefono, :fechaApartado, :fechaPagado, :estado, (SELECT idRifa FROM rifas WHERE idRifa = :idRifa), :origen)";
                $stmt2 = $db->prepare($query);
                $stmt2->bindValue(':numero', $numero, SQLITE3_TEXT);
                $stmt2->bindValue(':oportunidades', $oportunidadesCol, SQLITE3_TEXT);
                $stmt2->bindValue(':nombre', $emptyCol, SQLITE3_TEXT);
                $stmt2->bindValue(':telefono', $emptyCol, SQLITE3_TEXT);
                $stmt2->bindValue(':fechaApartado', $emptyCol, SQLITE3_TEXT);
                $stmt2->bindValue(':fechaPagado', $emptyCol, SQLITE3_TEXT);
                $stmt2->bindValue(':estado', $estado, SQLITE3_TEXT);
                $stmt2->bindValue(':origen', $emptyCol, SQLITE3_TEXT);
                $stmt2->bindValue(':idRifa', $idRifa, SQLITE3_TEXT);
                $result2 = $stmt2->execute();
                if(!$result2) {
                    // Failed to add the rifa, return an error code (e.g., 0)
                    $response = array('status' => 0, 'message' => 'Ha ocurrido un error: ' . $db->lastErrorMsg() . '');
                    // Return the JSON response
                    header('Content-Type: application/json');
                    echo json_encode($response);
                    exit();
                }
            }

            // Rifa added successfully, return a success code (e.g., 1)
            $response = array('status' => 1, 'message' => 'Rifa creada correctamente.');
            
        } else {
            // Failed to add the rifa, return an error code (e.g., 0)
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
    $response = array('status' => -1, 'message' => 'Ha ocurrido un error, contacte a soporte: ' . $db->lastErrorMsg() . '');

    // Return the JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
}
// Close the database connection
$db->close();
?>