<?php
// Replace 'jackpotGamer.db' with the path to your existing SQLite database file
$db_path = '../db/jackpotGamer.db';

try {
    // Connect to the database
    $db = new SQLite3($db_path);    

    $query = "SELECT digitos FROM rifas WHERE estado = 1";
    $result = $db->query($query);

    //get the value of the digits and then return it in a json array alogn with the status
    $row = $result->fetchArray(SQLITE3_ASSOC);
    $digitos = $row['digitos'];
    $response = array('status' => 1, 'digitos' => $digitos);
    echo json_encode($response);    

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
// Close the database connection
$db->close();
?>