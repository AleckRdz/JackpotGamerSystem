<?php
// Replace 'jackpotGamer.db' with the path to your existing SQLite database file
$db_path = '../db/jackpotGamer.db';

try {
    // Connect to the database
    $db = new SQLite3($db_path);

    // if cantidad is not set, set it to 500
    if (!isset($_GET['cantidad'])) {
        $_GET['cantidad'] = 500;
    }

    //assign values to variables
    $limit = $_GET['cantidad'];

    // SQL query to select all boletos from the 'boletos' table of the current raffle        
    $query = "SELECT numero FROM boletos WHERE estado = 0 AND edicion = (SELECT idRifa FROM rifas WHERE estado = 1) ORDER BY RANDOM() LIMIT $limit";
    $result = $db->query($query);

    // Execute the query and get the first row
    $row = $result->fetchArray(SQLITE3_ASSOC);

    if ($row === false) {
        echo '<div class="alert alert-danger" role="alert">No hay boletos disponibles.</div>';
        exit();
    } else {
        // Print the first row's data
        //assign values to variables            
        $numero = $row['numero'];
        echo '<div class="ticket" onclick="moverTicket(this);">';
        echo '<span>' . $numero . '</span>';
        echo '</div>';

        // Iterate over the remaining rows and print their data
        while ($boleto = $result->fetchArray(SQLITE3_ASSOC)) {
            //assign values to variables            
            $numero = $boleto['numero'];
            echo '<div class="ticket" onclick="moverTicket(this);">';
            echo '<span>' . $numero . '</span>';
            echo '</div>';
        }
    }


    //if the query returns no results, show a message
    if ($result->fetchArray() == false) {
        echo '<div class="alert alert-danger" role="alert">No hay boletos disponibles.</div>';
    } else {
        echo '<div class="ticket-container">';
        // Iterate over the results and generate the table rows dynamically
        while ($boleto = $result->fetchArray(SQLITE3_ASSOC)) {
            //assign values to variables            
            $numero = $boleto['numero'];
            echo '<div class="ticket" onclick="moverTicket(this);">';
            echo '<span>' . $numero . '</span>';
            echo '</div>';
        }
        echo "</div>";
    }
    //query to get the number of boletos with status 0 (available)
    $query = "SELECT COUNT(*) AS total FROM boletos WHERE estado = 0 AND edicion = (SELECT idRifa FROM rifas WHERE estado = 1)";
    $result = $db->query($query);
    $totalBoletos = $result->fetchArray(SQLITE3_ASSOC)['total'];

    //query to get the price of a boleto
    $query = "SELECT precioBoleto FROM rifas WHERE estado = 1";
    $result = $db->query($query);
    $precioBoleto = $result->fetchArray(SQLITE3_ASSOC)['precioBoleto'];

    //query to get oportunities per boleto
    $query = "SELECT oportunidades FROM rifas WHERE estado = 1";
    $result = $db->query($query);
    $oportunidades = $result->fetchArray(SQLITE3_ASSOC)['oportunidades'];
    
    //return the number of boletos, the price of a boleto and the number of opportunities per boleto
    echo '<script>$(".boletos-restantes").text("' . $totalBoletos . '");$(".precio-boleto").text("' . $precioBoleto . '");$(".oportunidad-boleto").text("' . $oportunidades . '");</script>';    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
// Close the database connection
$db->close();