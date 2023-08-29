<?php
// Replace 'jackpotGamer.db' with the path to your existing SQLite database file
$db_path = '../db/jackpotGamer.db';

try {
    // Connect to the database
    $db = new SQLite3($db_path);

    // get the number of boletos to fetch from the request
    $numeros = $_POST['numeros'];
    $numeroArray = explode(', ', $numeros); // Assuming numbers are separated by comma and space

    $numeroValues = "'" . implode("', '",
        $numeroArray
    ) . "'";

    $query = "SELECT numero, oportunidades FROM boletos WHERE estado = 0 AND numero IN ($numeroValues) AND edicion = (SELECT idRifa FROM rifas WHERE estado = 1)";
    $result = $db->query($query);

    // Execute the query and get the rows
    $rows = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $rows[] = $row;
    }

    if (empty($rows)) {
        echo '<div class="alert alert-danger" role="alert">No hay boletos disponibles.</div>';
    } else {
        $numRows = count($rows);

        echo '<table class="table table-responsive table-hover table-sm"><thead><tr><th scope="col" width="25%" class="text-center">Número(s)</th><th scope="col">Oportunidad(es) Extra</th></tr></thead><tbody>';
        // Print the rows' data
        for ($i = 0; $i < $numRows; $i++) {
            $numero = $rows[$i]['numero'];
            if ($rows[$i]['oportunidades'] == "") {
                $oportunidades = '-';
            } else {
                $oportunidades = $rows[$i]['oportunidades'];
            }
            echo '<tr><td class="text-center">' . $numero . '</td><td>' . $oportunidades . '</td></tr>';
        }
        echo '</tbody></table>';
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
// Close the database connection
$db->close();
