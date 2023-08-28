<?php
session_start(); // Start the session

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    // Replace 'jackpotGamer.db' with the path to your existing SQLite database file
    $db_path = '../../db/jackpotGamer.db';
    
    try {
        // Connect to the database
        $db = new SQLite3($db_path);
        
        // Prepare the SQL statement to retrieve the user data
        $query = "SELECT id, contrasena FROM usuarios WHERE usuario = :usuario OR correo = :usuario";
        $stmt = $db->prepare($query);
        $stmt->bindValue(':usuario', $username, SQLITE3_TEXT);
        
        // Execute the statement
        $result = $stmt->execute();
        $user = $result->fetchArray(SQLITE3_ASSOC);
        
        if ($user && password_verify($password, $user["contrasena"])) {
            // Password is correct, user is authenticated.
            // Set session variable with the user ID
            $_SESSION["user_id"] = $user["id"];
            
            $response = array('status' => 1, 'message' => '');
        } else {
            // Invalid credentials, return error message
            $response = array('status' => 0, 'message' => 'Usuario o contraseña incorrectos.');
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    } catch (Exception $e) {
        // Show error message
        $response = array('status' => -1, 'message' => 'Ha ocurrido un error inesperado, intente de nuevo más tarde.');
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}

// Close the database connection
$db->close();
?>