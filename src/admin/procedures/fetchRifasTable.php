<?php
echo "
    <thead>
        <tr>
            <th>#</th>
            <th>Producto</th>
            <th>Boletos</th>
            <th>Precio</th>
            <th>Oportunidades</th>
            <th>Fecha de rifa</th>
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

        // SQL query to select all rifas from the 'rifas' table
        $query = "SELECT * FROM rifas";
        $result = $db->query($query);

        
        // Iterate over the results and generate the table rows dynamically
        while ($rifa = $result->fetchArray(SQLITE3_ASSOC)) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($rifa['idRifa']) . '</td>';
            //validate if any image is found within the id
            // if (file_exists('../assets/img/elements/' . htmlspecialchars($rifa['idRifa']) . '.jpg')) {
                //     echo '<td><img src="assets/img/elements/' . htmlspecialchars($rifa['idRifa']) . '.jpg" class="img-fluid rounded-circle" width="40" height="40"></td>';
                // } else {
                    //     echo '<td><img src="assets/img/elements/default.jpg" class="img-fluid rounded-circle" width="40" height="40"></td>';
            // }
            echo '<td>' . htmlspecialchars($rifa['producto']) . '</td>';
            echo '<td>' . htmlspecialchars($rifa['cantidadBoletos']) . '</td>';
            echo '<td>' . htmlspecialchars($rifa['precioBoleto']) . '</td>';
            echo '<td>' . htmlspecialchars($rifa['oportunidades']) . '</td>';
            echo '<td>' . htmlspecialchars($rifa['fechaRifa']) . '</td>';
            if ($rifa['estado'] == '1') {
                echo '<td class="text-center"><span class="badge bg-success">Activo</span></td>';
            } else {
                echo '<td class="text-center"><span class="badge bg-secondary">Inactivo</span></td>';
            }
            echo '<td class="text-center">';
            echo '<a href="#" class="btn btn-primary btn-sm me-1 mt-1 btn-edit" data-bs-toggle="tooltip" 
            data-id="' . htmlspecialchars($rifa['idRifa']) . '" 
            data-producto="' . htmlspecialchars($rifa['producto']) . '" 
            data-cantidad="' . htmlspecialchars($rifa['cantidadBoletos']) . '" 
            data-precio="' . htmlspecialchars($rifa['precioBoleto']) . '" 
            data-oportunidades="' . htmlspecialchars($rifa['oportunidades']) . '" 
            data-fecha="' . htmlspecialchars($rifa['fechaRifa']) . '" 
            data-estado="' . htmlspecialchars($rifa['estado']) . '"
            data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true" title="" data-bs-original-title="<i class=\'fa-solid fa-pen\'></i> <span>Editar</span>">';
            echo '<i class="fas fa-edit"></i></a>';
            echo '<a href="#" class="btn btn-danger btn-sm me-1 mt-1 btn-delete" data-bs-toggle="tooltip" 
            data-producto="' . htmlspecialchars($rifa['producto']) . '" 
            data-id="' . htmlspecialchars($rifa['idRifa']) . '" 
            data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true" title="" data-bs-original-title="<i class=\'fa-solid fa-eraser\'></i> <span>Eliminar</span>">';
            echo '<i class="fas fa-trash"></i>';
            echo '</a>';
            echo '</td>';
            echo '</tr>';
        }
        //check if result has any rows, if not then print a table row with a message
        if ($result->fetchArray(SQLITE3_ASSOC) == 0) {
            echo '<tr><td colspan="9" class="text-center">No hay rifas registradas.</td></tr>';
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
    echo "
        </tbody>
        <tfoot>
            <tr>
                <th>#</th>
                <th>Producto</th>
                <th>Boletos</th>
                <th>Precio</th>
                <th>Oportunidades</th>
                <th>Fecha de rifa</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </tfoot>";
// Close the database connection
$db->close(); 
?>