<?php include('masterpage/header.php'); ?>

<div class="card-body">
    <h4 class="pb-1 mb-2">Rifas</h4>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
            <li class="breadcrumb-item">
                <a href="index.php">Inicio</a>
            </li>
            <li class="breadcrumb-item active">Rifas</li>
        </ol>
    </nav>
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#basicModal">
        <i class="fas fa-plus"></i> Agregar Rifa
    </button>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="tablaRifas" class="table table-hover table-striped"></table>
            </div>
        </div>
    </div>
</div>

<!-- modal agregar -->
<div class="modal fade" id="basicModal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Crear Rifa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" id="formAgregarRifas">
                    <input type="hidden" id="id">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="producto" class="form-label">Objeto(s) a rifar</label>
                            <input type="text" id="producto" class="form-control" placeholder="Ingrese nombre del objeto">
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-0">
                            <label for="cantidad" class="form-label">Cantidad de boletos</label>
                            <input type="number" id="cantidad" class="form-control" placeholder="Ingrese un número">
                        </div>
                        <div class="col mb-0">
                            <label for="oportunidades" class="form-label">Oportunidades</label>
                            <input type="number" id="oportunidades" class="form-control" placeholder="Ingrese un número">
                        </div>
                    </div>
                    <div class="row g-2 mt-1">
                        <div class="col mb-0">
                            <label for="precio" class="form-label">Precio del boleto</label>
                            <input type="number" id="precio" class="form-control" placeholder="Ingrese un número">
                        </div>
                        <!-- <div class="col mb-0">
                            <label for="imagen" class="form-label">Imagen del producto</label>
                            <input type="file" id="imagen" name="imageFile" class="form-control">
                        </div> -->
                        <div class="col mb-0">
                            <label for="fecha" class="form-label">Fecha de rifa</label>
                            <input type="date" id="fecha" class="form-control">
                        </div>
                    </div>
                    <div class="row g-2 mt-1">
                        <div class="col mb-0">
                            <label for="btnradio" class="form-label">Estado</label><br>
                            <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off">
                                <label class="btn btn-outline-success" for="btnradio1">Activo</label>
                                <input type="radio" class="btn-check" name="btnradio" id="btnradio2" checked autocomplete="off">
                                <label class="btn btn-outline-secondary" for="btnradio2">Inactivo</label>
                            </div>
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
                <h5 class="modal-title" id="exampleModalLabel2">Eliminar Rifa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Está seguro de <b>eliminar</b> la rifa: <span id="delRifa"></span>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnDelete" onclick="deleteRifa()">Confirmar</button>
            </div>
        </div>
    </div>
</div>

<!-- Your other scripts and libraries -->
<script>
    $(document).ready(function() {
        // Load the table with the existing data
        $("#tablaRifas").load("procedures/fetchRifasTable.php");

        //function when btnDelete is clicked to show modalDelete
        $(document).on("click", ".btn-delete", function() {
            var producto = $(this).attr("data-producto");
            var id = $(this).attr("data-id");
            $("#delRifa").html(producto);
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
            var id = $("#id").val();
            var producto = $("#producto").val();
            var cantidad = $("#cantidad").val();
            var oportunidades = $("#oportunidades").val();
            var precio = $("#precio").val();
            // var imagen = $("#imagen").val();
            var fecha = $("#fecha").val();
            if($("#btnradio1").is(':checked')){
                var estado = 1;
            }else{
                var estado = 0;
            }
            
            // Perform basic validation
            if (producto === '' || cantidad === '' || oportunidades === '' || precio === '' || fecha === '') {
                notif("warning", "fas fa-exclamation-circle", "¡Atención!", "Ahora", "complete todos los campos");
                return;
            }

            if (id != '') {
                var procedure = 'updateRifa';
            } else {
                var procedure = 'addRifa';
            }

            // Perform additional validation here if needed
            // ...

            // If all data is valid, send the form data to the PHP file using AJAX
            $.ajax({
                type: "POST",
                url: "procedures/" + procedure + ".php", // Replace with the URL of your PHP file for adding the user
                data: {
                    id: id,
                    producto: producto,
                    cantidad: cantidad,
                    oportunidades: oportunidades,
                    precio: precio,
                    // imagen: imagen,
                    fecha: fecha,
                    estado: estado
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

                        $("#tablaRifas").load("procedures/fetchRifasTable.php");

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

    function deleteRifa() {
        var id = $("#btnDelete").attr("data-id");
        $.ajax({
            type: "POST",
            url: "procedures/deleteRifa.php", // Replace with the URL of your PHP file for adding the user
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
                    $("#tablaRifas").load("procedures/fetchRifasTable.php");

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