<?php
echo "
    <thead>
        <tr>
            <th>Número</th>
            <th>Oportunidades</th>
            <th>Comprador</th>
            <th>Teléfono</th>
            <th>Origen</th>
            <th>Fecha apartado</th>
            <th>Fecha pagado</th>
            <th>Estado</th>            
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
        while ($boleto = $result->fetchArray(SQLITE3_ASSOC)) {
            //assign values to variables            
            $nombre = $boleto['nombre'];
            $telefono = $boleto['telefono'];
            $origen = $boleto['origen'];
            $fechaApartado = $boleto['fechaApartado'];
            $fechaPagado = $boleto['fechaPagado'];
            $oportunidades = $boleto['oportunidades'];
            echo '<tr>';            
            echo '<td>' . htmlspecialchars($boleto['numero']) . '</td>';            
            if ($oportunidades == '') {
                echo '<td>-</td>';
            } else {
                echo '<td>' . htmlspecialchars($boleto['oportunidades']) . '</td>';
            }
            if ($nombre == '') {
                echo '<td>-</td>';
            } else {
                echo '<td>' . htmlspecialchars($boleto['nombre']) . '</td>';
            }
            if ($telefono == '') {
                echo '<td>-</td>';
            } else {
                echo '<td>' . htmlspecialchars($boleto['telefono']) . '</td>';
            }
            if ($origen == '') {
                echo '<td>-</td>';
            } else {
                echo '<td>' . htmlspecialchars($boleto['origen']) . '</td>';
            }
            if ($fechaApartado == '') {
                echo '<td>-</td>';
            } else {
                echo '<td>' . htmlspecialchars($boleto['fechaApartado']) . '</td>';
            }
            if ($fechaPagado == '') {
                echo '<td>-</td>';
            } else {
                echo '<td>' . htmlspecialchars($boleto['fechaPagado']) . '</td>';
            }
            if ($boleto['estado'] == '0') {
                echo '<td class="text-center"><span class="badge bg-secondary rounded-pill">Libre</span></td>';
                // echo '<td class="text-center">-</td>';
            } else  if ($boleto['estado'] == '1') {
                echo '<td class="text-center"><span class="badge bg-warning rounded-pill">Apartado</span></td>';
                // echo '<td class="text-center"><button type="button" onclick="validarBoleto();" data-id="' . htmlspecialchars($boleto['idBoleto']) . '" class="btn btn-success btn-icon rounded-pill btn-sm me-1 mt-1" data-bs-toggle="tooltip" data-bs-target="#basicModal" data-bs-placement="top" data-bs-html="true" title="" data-bs-original-title="<i class=\'fas fa-check\'></i> Validar Boletos"><i class="fa-solid fa-circle-check"></i></button>';
                // echo '<button type="button" onclick="liberarBoleto();" data-id="' . htmlspecialchars($boleto['idBoleto']) . '" class="btn btn-primary btn-icon rounded-pill btn-sm me-1 mt-1" data-bs-toggle="tooltip" data-bs-target="#basicModal" data-bs-placement="top" data-bs-html="true" title="" data-bs-original-title="<i class=\'fas fa-repeat\'></i> Liberar Boletos"><i class="fa-solid fa-repeat"></i></button></td>';
            } else if ($boleto['estado'] == '2') {
                echo '<td class="text-center"><span class="badge bg-success rounded-pill">Pagado</span></td>';
                // echo '<td class="text-center"><button type="button" onclick="invalidarBoleto();" data-id="' . htmlspecialchars($boleto['idBoleto']) . '" class="btn btn-danger btn-icon rounded-pill btn-sm me-1 mt-1" data-bs-toggle="tooltip" data-bs-target="#basicModal" data-bs-placement="top" data-bs-html="true" title="" data-bs-original-title="<i class=\'fas fa-xmark\'></i> Invalidar Boletos"><i class="fa-solid fa-circle-xmark"></i></button>';
            }           
            echo '</tr>';
        }        
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
    echo "
        </tbody>
        <tfoot>
            <tr>
                <th>Número</th>
                <th>Oportunidades</th>
                <th>Comprador</th>
                <th>Teléfono</th>
                <th>Origen</th>
                <th>Fecha apartado</th>
                <th>Fecha pagado</th>
                <th>Estado</th>
            </tr>
        </tfoot>";
// Close the database connection
$db->close();
?>