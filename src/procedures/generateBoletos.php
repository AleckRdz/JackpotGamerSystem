<?php
// Replace 'jackpotGamer.db' with the path to your existing SQLite database file
$db_path = '../db/jackpotGamer.db';

try {
    // Connect to the database
    $db = new SQLite3($db_path);

    // get the number of boletos to fetch from the request
    $limit = $_POST['cantidad'];

    //if limit is under 1 or above 100 send message
    if ($limit < 1 || $limit > 100) {
        echo '<div class="alert alert-danger" role="alert">La cantidad de boletos a generar no es válida.</div>';
        exit();
    }

    // SQL query to check if there's enough boletos available
    $query = "SELECT COUNT(*) AS total FROM boletos WHERE estado = 0 AND edicion = (SELECT idRifa FROM rifas WHERE estado = 1)";    
    $result = $db->query($query);

    //assign values to variables
    $row = $result->fetchArray(SQLITE3_ASSOC);
    $total = $row['total'];    

    //if there are no rows show a message
    if ($total === 0) {
        echo '<div class="alert alert-danger" role="alert">No hay boletos disponibles.</div>';
        exit();
    } 
    
    //if there are less rows than the requested amount show a message
    if ($total < $limit) {
        echo '<div class="alert alert-danger" role="alert">No hay suficientes boletos disponibles.</div>';
        exit();
    }

    // SQL query to select boletos from the 'boletos' table of the current raffle        
    $query = "SELECT numero, oportunidades FROM boletos WHERE estado = 0 AND edicion = (SELECT idRifa FROM rifas WHERE estado = 1) ORDER BY RANDOM() LIMIT $limit";
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

        echo '<table class="table table-responsive table-hover table-sm"><thead><tr><th scope="col" width="25%" class="text-center">Número(s)</th><th scope="col">Oportunidades Extra</th></tr></thead><tbody>';
        // Print the rows' data
        for ($i = 0; $i < $numRows; $i++) {
            $numero = $rows[$i]['numero'];
            if($rows[$i]['oportunidades'] == "") {
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
