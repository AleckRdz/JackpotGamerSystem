<?php
// Replace 'jackpotGamer.db' with the path to your existing SQLite database file
$db_path = '../../db/jackpotGamer.db';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form data from the POST request
    $id = $_POST['id'];
    $name = $_POST['name'];
    $user = $_POST['user'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $rol = $_POST['rol'];

    // Perform additional validation here if needed
    // ...

    // Hash the password before storing it in the database
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        // Connect to the database
        $db = new SQLite3($db_path);

            $query = "UPDATE usuarios SET nombre = :name, usuario = :user, correo = :email, contrasena = :password, rol = :rol WHERE id = :id";
            $stmt = $db->prepare($query);
            $stmt->bindValue(':name', $name, SQLITE3_TEXT);
            $stmt->bindValue(':user', $user, SQLITE3_TEXT);
            $stmt->bindValue(':email', $email, SQLITE3_TEXT);
            $stmt->bindValue(':password', $hashedPassword, SQLITE3_TEXT);
            $stmt->bindValue(':rol', $rol, SQLITE3_TEXT);
            $stmt->bindValue(':id', $id, SQLITE3_TEXT);
            $result = $stmt->execute();

            if ($result) {
                // User updated successfully, return a success code (e.g., 1)
                $response = array('status' => 1, 'message' => 'Usuario actualizado correctamente.');
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
    $response = array('status' => -1, 'message' => 'Ha ocurrido un error, contacte a soportes.');

    // Return the JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
}
// Close the database connection
$db->close();
?>