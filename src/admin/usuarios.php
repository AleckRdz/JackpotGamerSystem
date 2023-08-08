<?php include('masterpage/header.php'); ?>

<div class="card-body">
    <h4 class="pb-1 mb-2">Usuarios</h4>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
            <li class="breadcrumb-item">
                <a href="index.php">Inicio</a>
            </li>
            <li class="breadcrumb-item">
                Configuraciones
            </li>
            <li class="breadcrumb-item active">Usuarios</li>
        </ol>
    </nav>
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#basicModal">
        <i class="fas fa-plus"></i> Agregar Usuario
    </button>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="tablaUsuarios" class="table table-hover table-striped"></table>
            </div>
        </div>
    </div>
</div>

<!-- modal agregar -->
<div class="modal fade" id="basicModal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Agregar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" id="formAgregarUsuarios">
                    <input type="hidden" id="id">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="name" class="form-label">Nombre</label>
                            <input type="text" id="name" class="form-control" placeholder="Ingrese el nombre">
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-0">
                            <label for="user" class="form-label">Usuario</label>
                            <input type="text" id="user" class="form-control" placeholder="Ingrese el usuario">
                        </div>
                        <div class="col mb-0">
                            <label for="email" class="form-label">Correo</label>
                            <input type="text" id="email" class="form-control" placeholder="xxxx@xxx.xx">
                        </div>
                    </div>
                    <div class="row g-2 mt-1">
                        <div class="col mb-0">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" id="password" class="form-control" placeholder="******">
                        </div>
                        <div class="col mb-0">
                            <label for="rol" class="form-label">Rol</label>
                            <select name="rol" class="form-control" id="rol">
                                <option value="0">- Seleccionar -</option>
                                <option value="Usuario">Usuario</option>
                                <option value="Administrador">Administrador</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnAgregar">Agregar</button>
            </div>
        </div>
    </div>
</div>

<!-- delete confirm modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" style="display: none;" aria-hidden="false">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel2">Eliminar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Está seguro de <b>eliminar</b> al usuario: <span id="delUser"></span>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnDelete" onclick="deleteUser()">Confirmar</button>
            </div>
        </div>
    </div>
</div>

<!-- Your other scripts and libraries -->
<script>
    $(document).ready(function() {
        // Load the table with the existing data
        $("#tablaUsuarios").load("procedures/fetchUserTable.php");

        //function when btnDelete is clicked to show modalDelete
        $(document).on("click", ".btn-delete", function() {
            var user = $(this).attr("data-user");
            var id = $(this).attr("data-id");
            $("#delUser").html(user);
            $("#btnDelete").attr("data-id", id);
            $("#deleteModal").modal("show");
        });

        //function when a modal is closed
        $(".modal").on("hidden.bs.modal", function() {
            // Clear the form fields after modal close
            $("#id").val("");
            $("#name").val("");
            $("#user").val("");
            $("#email").val("");
            $("#password").val("");
            $("select[name='rol']").val("0");
            $("#btnAgregar").html("Agregar");
        });

        //function when btnEdit is clicked to show modalEdit
        $(document).on("click", ".btn-edit", function() {
            var id = $(this).attr("data-id");
            var nombre = $(this).attr("data-nombre");
            var usuario = $(this).attr("data-usuario");
            var correo = $(this).attr("data-correo");
            var rol = $(this).attr("data-rol");
            $("#id").val(id);
            $("#name").val(nombre);
            $("#user").val(usuario);
            $("#email").val(correo);
            $("#rol").val(rol);

            $("#btnAgregar").html("Actualizar");
            $("#basicModal").modal("show");
        });

        // Handle form submission when the "Agregar" button is clicked
        $("#btnAgregar").click(function() {
            // Get the form data
            var id = $("#id").val().trim();
            var name = $("#name").val().trim();
            var user = $("#user").val().trim();
            var email = $("#email").val().trim();
            var password = $("#password").val().trim();
            var rol = $("select[name='rol']").val();

            // Perform basic validation
            if (name === '' || user === '' || email === '' || password === '' || rol === '0') {
                notif("warning", "fas fa-exclamation-circle", "¡Atención!", "Ahora", "complete todos los campos");
                return;
            }

            if (id != '') {
                var procedure = 'updateUser';
            } else {
                var procedure = 'addUser';
            }

            // Perform additional validation here if needed
            // ...

            // If all data is valid, send the form data to the PHP file using AJAX
            $.ajax({
                type: "POST",
                url: "procedures/" + procedure + ".php", // Replace with the URL of your PHP file for adding the user
                data: {
                    id: id,
                    name: name,
                    user: user,
                    email: email,
                    password: password,
                    rol: rol
                },
                success: function(response) {
                    // Parse the JSON response to access the returned data
                    var status = response.status;
                    var message = response.message;

                    // Show a notification based on the status code
                    if (status === 1) {
                        // Success notification using notif function
                        notif("success", "fas fa-check-circle", "¡Éxito!", "Ahora", message);

                        // Hide the modal popup
                        $("#basicModal").modal("hide");

                        $("#tablaUsuarios").load("procedures/fetchUserTable.php");

                    } else {
                        // Error notification
                        notif("warning", "fa-solid fa-triangle-exclamation", "¡Atención!", "Ahora", message);
                    }
                },
                error: function(xhr, status, error) {
                    notif("danger", "fa-solid fa-skull-crossbones", "¡Error!", "Ahora", "Ha ocurrido un error, contacte a soporte.");
                }
            });
        });
    });

    function deleteUser() {
        var id = $("#btnDelete").attr("data-id");
        $.ajax({
            type: "POST",
            url: "procedures/deleteUser.php", // Replace with the URL of your PHP file for adding the user
            data: {                
                id: id
            },
            success: function(response) {
                // Parse the JSON response to access the returned data
                var status = response.status;
                var message = response.message;

                // Show a notification based on the status code
                if (status === 1) {
                    // Success notification using notif function
                    notif("success", "fas fa-check-circle", "¡Éxito!", "Ahora", message);

                    // Hide the modal popup
                    $("#deleteModal").modal("hide");

                    //reload table data
                    $("#tablaUsuarios").load("procedures/fetchUserTable.php");

                } else {
                    // Error notification
                    notif("warning", "fa-solid fa-triangle-exclamation", "¡Atención!", "Ahora", message);
                }

            },
            error: function(xhr, status, error) {
                notif("danger", "fa-solid fa-skull-crossbones", "¡Error!", "Ahora", "Ha ocurrido un error, contacte a soporte.");
            }
        });
    }
</script>


<?php include('masterpage/footer.php'); ?>