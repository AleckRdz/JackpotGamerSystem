<?php
// Replace 'jackpotGamer.db' with the path to your existing SQLite database file
$db_path = '../../db/jackpotGamer.db';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form data from the POST request
    $id = $_POST['id'];

    // Perform additional validation here if needed
    // ...

    try {
        // Connect to the database
        $db = new SQLite3($db_path);

        //switch estado of the rifa, if active then deactivate and viceversa, also deactivate all other rifas if this one activates
        $query = "UPDATE rifas SET estado = CASE WHEN idRifa = $id THEN CASE WHEN estado = 1 THEN 0 ELSE 1 END ELSE 0 END";
        $result = $db->exec($query);                
        
        if ($result) {
            // state updated successfully, return a success code (e.g., 1)
            $response = array('status' => 1, 'message' => 'Estado alternado correctamente.');            
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
?>