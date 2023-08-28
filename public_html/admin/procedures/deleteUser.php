<?php
// Replace 'jackpotGamer.db' with the path to your existing SQLite database file
$db_path = '../../db/jackpotGamer.db';

try {
    // Check if the user ID is provided in the POST request
    if (isset($_POST['id'])) {        
        $user_id_to_delete = $_POST['id'];

        // Connect to the database
        $db = new SQLite3($db_path);

        // SQL query to delete the user from the 'usuarios' table
        $query = "DELETE FROM usuarios WHERE id = :user_id";
        $stmt = $db->prepare($query);
        $stmt->bindValue(':user_id', $user_id_to_delete, SQLITE3_INTEGER);
        $stmt->execute();

        $response = array('status' => 1, 'message' => 'Usuario eliminado correctamente.');
    } else {
        // If user ID is not provided in the request, return an error message
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
// Close the database connection
$db->close();
?>