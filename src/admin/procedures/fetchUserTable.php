<?php
echo "
    <thead>
        <tr>
            <th>#</th>
            <th>Avatar</th>
            <th>Nombre</th>
            <th>Usuario</th>
            <th>Correo</th>
            <th>Rol</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>";
    // Replace 'jackpotGamer.db' with the path to your existing SQLite database file
    $db_path = '../../db/jackpotGamer.db';

    try {
        // Connect to the database
        $db = new SQLite3($db_path);

        // SQL query to select all users from the 'usuarios' table
        $query = "SELECT * FROM usuarios";
        $result = $db->query($query);
        
        // Iterate over the results and generate the table rows dynamically
        while ($user = $result->fetchArray(SQLITE3_ASSOC)) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($user['id']) . '</td>';
            //validate if any image is found within the id
            if (file_exists('../assets/img/avatars/' . htmlspecialchars($user['id']) . '.jpg')) {
                echo '<td><img src="assets/img/avatars/' . htmlspecialchars($user['id']) . '.jpg" class="img-fluid rounded-circle" width="40" height="40"></td>';
            } else {
                echo '<td><img src="assets/img/avatars/default.jpg" class="img-fluid rounded-circle" width="40" height="40"></td>';
            }
            echo '<td>' . htmlspecialchars($user['nombre']) . '</td>';
            echo '<td>' . htmlspecialchars($user['usuario']) . '</td>';
            echo '<td>' . htmlspecialchars($user['correo']) . '</td>';
            echo '<td>' . htmlspecialchars($user['rol']) . '</td>';
            echo '<td class="text-center">';
            echo '<a href="#" class="btn btn-primary btn-sm me-1 mt-1 btn-edit" data-bs-toggle="tooltip" 
            data-id="' . htmlspecialchars($user['id']) . '" 
            data-nombre="' . htmlspecialchars($user['nombre']) . '" 
            data-usuario="' . htmlspecialchars($user['usuario']) . '" 
            data-correo="' . htmlspecialchars($user['correo']) . '" 
            data-rol="' . htmlspecialchars($user['rol']) . '" 
            data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true" title="" data-bs-original-title="<i class=\'fa-solid fa-user-pen\'></i> <span>Editar</span>">';
            echo '<i class="fas fa-edit"></i></a>';
            echo '<a href="#" class="btn btn-danger btn-sm me-1 mt-1 btn-delete" data-bs-toggle="tooltip" 
            data-user="' . htmlspecialchars($user['usuario']) . '" 
            data-id="' . htmlspecialchars($user['id']) . '" 
            data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true" title="" data-bs-original-title="<i class=\'fa-solid fa-user-xmark\'></i> <span>Eliminar</span>">';
            echo '<i class="fas fa-trash"></i>';
            echo '</a>';
            echo '</td>';
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
                <th>Avatar</th>
                <th>Nombre</th>
                <th>Usuario</th>
                <th>Correo</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </tfoot>";
// Close the database connection
$db->close(); 
?>