<?php
// Replace 'jackpotGamer.db' with the path to your existing SQLite database file
$db_path = '../../db/jackpotGamer.db';

try {
    // Check if the user ID is provided in the POST request
    if (isset($_POST['id'])) {        
        $rifa_id_to_delete = $_POST['id'];

        // Connect to the database
        $db = new SQLite3($db_path);

        // SQL query to delete the user from the 'usuarios' table
        $query = "DELETE FROM rifas WHERE idRifa = :rifa_id";
        $stmt = $db->prepare($query);
        $stmt->bindValue(':rifa_id', $rifa_id_to_delete, SQLITE3_INTEGER);
        $stmt->execute();

        $response = array('status' => 1, 'message' => 'Rifa eliminada correctamente.');
    } else {
        // If user ID is not provided in the request, return an error message
        $response = array('status' => 0, 'message' => 'Ha ocurrido un error.');
    }
} catch (Exception $e) {
    // Error occurred, return an error code (e.g., -1)
    $response = array('status' => -1, 'message' => 'Ha ocurrido un error, contacte a soporte.');
} finally {
    // Return the JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    
    // Close the database connection
    $db->close();
}
