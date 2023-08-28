<?php
// Replace 'jackpotGamer.db' with the path to your existing SQLite database file
$db_path = '../db/jackpotGamer.db';

try {
    // Connect to the database
    $db = new SQLite3($db_path);

    $numero = $_POST['numero'];

    $query = "SELECT nombre, origen, fechaPagado, oportunidades FROM boletos WHERE numero = :numero AND edicion = (SELECT idRifa FROM rifas WHERE estado = 1)";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':numero', $numero, SQLITE3_TEXT);
    $result = $stmt->execute();
    
    // if any row exist send back a json array with status 1 and numero data, else send back a json array with status 0 and message 'No se encontró el boleto.'
    if ($result->fetchArray()) {
        $result->reset();
        $row = $result->fetchArray();
        $nombre = $row['nombre'];
        if (!$nombre) {
            $nombre = '-';
        }
        $estado = $row['origen'];
        if (!$estado) {
            $estado = '-';
        }
        $fechaPagado = $row['fechaPagado'];
        $oportunidades = $row['oportunidades'];
        $pagado = $fechaPagado ? 'SÍ' : 'NO';
        echo json_encode(array('status' => 1, 'nombre' => $nombre, 'estado' => $estado, 'pagado' => $pagado, 'oportunidades' => $oportunidades));
    } else {
        echo json_encode(array('status' => 0, 'message' => 'No se encontró el boleto.'));
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
} finally {
    // Close the database connection
    if ($db) {
        $db->close();
    }
}
?>