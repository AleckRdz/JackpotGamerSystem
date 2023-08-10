<?php
echo "
    <thead>
        <tr>
            <th>#</th>
            <th>Comprador</th>
            <th>Teléfono</th>
            <th>Origen</th>
            <th>Fecha apartado</th>
            <th>Fecha pagado</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>";
    // Replace 'jackpotGamer.db' with the path to your existing SQLite database file
    $db_path = '../../db/jackpotGamer.db';

    try {
        // Connect to the database
        $db = new SQLite3($db_path);

        // SQL query to select all boletos from the 'boletos' table of the current raffle
        $query = "SELECT * FROM boletos WHERE edicion = (SELECT idRifa FROM rifas WHERE estado = 1)";
        $result = $db->query($query);

        
        // Iterate over the results and generate the table rows dynamically
        while ($rifa = $result->fetchArray(SQLITE3_ASSOC)) {
            //assign values to variables            
            $nombre = $rifa['nombre'];
            $telefono = $rifa['telefono'];
            $origen = $rifa['origen'];
            $fechaApartado = $rifa['fechaApartado'];
            $fechaPagado = $rifa['fechaPagado'];
            echo '<tr>';            
            echo '<td>' . htmlspecialchars($rifa['numero']) . '</td>';
            //if the name is empty, show a dash
            if ($nombre == '') {
                echo '<td>-</td>';
            } else {
                echo '<td>' . htmlspecialchars($rifa['nombre']) . '</td>';
            }
            if ($telefono == '') {
                echo '<td>-</td>';
            } else {
                echo '<td>' . htmlspecialchars($rifa['telefono']) . '</td>';
            }
            if ($origen == '') {
                echo '<td>-</td>';
            } else {
                echo '<td>' . htmlspecialchars($rifa['origen']) . '</td>';
            }
            if ($fechaApartado == '') {
                echo '<td>-</td>';
            } else {
                echo '<td>' . htmlspecialchars($rifa['fechaapartado']) . '</td>';
            }
            if ($fechaPagado == '') {
                echo '<td>-</td>';
            } else {
                echo '<td>' . htmlspecialchars($rifa['fechaPagado']) . '</td>';
            }
            if ($rifa['estado'] == '0') {
                echo '<td class="text-center"><span class="badge bg-secondary rounded-pill">Libre</span></td>';
            } else  if ($rifa['estado'] == '1') {
                echo '<td class="text-center"><span class="badge bg-warning rounded-pill">Apartado</span></td>';
            } else if ($rifa['estado'] == '2') {
                echo '<td class="text-center"><span class="badge bg-success rounded-pill">Pagado</span></td>';
            }
            echo '<td class="text-center">';            
            echo '<button type="button" class="btn btn-success btn-icon rounded-pill btn-sm me-1 mt-1" data-bs-toggle="tooltip" data-bs-target="#basicModal" data-bs-placement="top" data-bs-html="true" title="" data-bs-original-title="<i class=\'fas fa-check\'></i> Validar Boletos"><i class="fa-solid fa-circle-check"></i></button>';
            echo '<button type="button" class="btn btn-danger btn-icon rounded-pill btn-sm me-1 mt-1" data-bs-toggle="tooltip" data-bs-target="#basicModal" data-bs-placement="top" data-bs-html="true" title="" data-bs-original-title="<i class=\'fas fa-xmark\'></i> Invalidar Boletos"><i class="fa-solid fa-circle-xmark"></i></button>';
            echo '<button type="button" class="btn btn-primary btn-icon rounded-pill btn-sm me-1 mt-1" data-bs-toggle="tooltip" data-bs-target="#basicModal" data-bs-placement="top" data-bs-html="true" title="" data-bs-original-title="<i class=\'fas fa-repeat\'></i> Liberar Boletos"><i class="fa-solid fa-repeat"></i></button>';
            echo '</tr>';
        }        
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
    echo "
        </tbody>
        <tfoot>
            <tr>
                <th>#</th>
                <th>Comprador</th>
                <th>Teléfono</th>
                <th>Origen</th>
                <th>Fecha apartado</th>
                <th>Fecha pagado</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </tfoot>";
// Close the database connection
$db->close();
?>