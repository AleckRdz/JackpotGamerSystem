<?php
// Replace 'jackpotGamer.db' with the path to your existing SQLite database file
$db_path = '../../db/jackpotGamer.db';

try {
    // Connect to the database
    $db = new SQLite3($db_path);

    // Replace 'USER_ID_TO_DELETE' with the actual user_id you want to delete
    $user_id_to_delete = 1;

    // SQL query to delete a specific user from the 'usuarios' table
    $query = "DELETE FROM usuarios WHERE id = :user_id";
    $stmt = $db->prepare($query);
    $stmt->bindValue(':user_id', $user_id_to_delete, SQLITE3_INTEGER);
    $stmt->execute();

    echo "User with ID $user_id_to_delete has been deleted successfully!";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
