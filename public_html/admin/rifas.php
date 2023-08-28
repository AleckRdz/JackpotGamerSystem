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
    <button type="button" class="btn btn-primary rounded-pill mb-3" data-bs-toggle="modal" data-bs-target="#basicModal">
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
                        <div class="col-sm-12 mb-3">
                            <label for="producto" class="form-label">Producto(s) a rifar</label>
                            <input type="text" id="producto" class="form-control" placeholder="Ingrese nombre del producto">
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-sm-6 col-md-6 mb-0">
                            <label for="digitos" class="form-label">Digitos a jugar</label><br>
                            <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                <input type="radio" class="btn-check" name="digitos" id="btnDigitos2" autocomplete="off">
                                <label class="btn btn-outline-primary" for="btnDigitos2">2</label>
                                <input type="radio" class="btn-check" name="digitos" id="btnDigitos3" autocomplete="off">
                                <label class="btn btn-outline-primary" for="btnDigitos3">3</label>
                                <input type="radio" class="btn-check" name="digitos" id="btnDigitos4" autocomplete="off">
                                <label class="btn btn-outline-primary" for="btnDigitos4">4</label>
                                <input type="radio" class="btn-check" name="digitos" id="btnDigitos5" autocomplete="off">
                                <label class="btn btn-outline-primary" for="btnDigitos5">5</label>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 mb-0">
                            <label for="cantidad" class="form-label">Cantidad de boletos</label>
                            <select name="cantidad" class="form-control" id="cantidad" disabled>
                                <option value="0">Seleccionar dígitos</option>
                            </select>
                        </div>
                    </div>
                    <div class="row g-2 mt-1">
                        <div class="col-sm-6 mb-0">
                            <label for="precio" class="form-label">Precio del boleto</label>
                            <input type="number" id="precio" class="form-control" placeholder="Ingrese un número">
                        </div>
                        <!-- <div class="col mb-0">
                            <label for="imagen" class="form-label">Imagen del producto</label>
                            <input type="file" id="imagen" name="imageFile" class="form-control">
                        </div> -->
                        <div class="col-sm-6 mb-0">
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
                <button type="button" class="btn btn-outline-secondary" id="btnCancelar" data-bs-dismiss="modal">Cancelar</button>
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
                <p>¿Está seguro de <b>ELIMINAR</b> la rifa: <u><span id="delRifa"></span></u> y <b>TODOS</b> sus respectivos boletos?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnDelete" onclick="deleteRifa()">Eliminar</button>
            </div>
        </div>
    </div>
</div>

<!-- other scripts and libraries -->
<script>
    $(document).ready(function() {
        //show spinner
        $("#tablaRifas").html('<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>');

        // Load the table with the existing data
        $("#tablaRifas").load("procedures/fetchRifasTable.php", function() {
            $("#tablaRifas").DataTable({
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json",
                    "emptyTable": "No se han creado rifas."
                }
            });
        });

        //function when modal is hidden to enable radios
        $(".modal").on("hidden.bs.modal", function() {
            $("#btnDigitos2").removeAttr("disabled");
            $("#btnDigitos3").removeAttr("disabled");
            $("#btnDigitos4").removeAttr("disabled");
            $("#btnDigitos5").removeAttr("disabled");
        });

        //functions when btnDigitos is clicked

        // 2-Digit Tickets
        $("#btnDigitos2").click(function() {
            $("#cantidad").removeAttr("disabled");
            $("#cantidad").html("<option value='0'>- Seleccionar -</option>");
            $("#cantidad").append("<option value='100' data-oportunidades='1'>100 con 1 oportunidad c/u.</option>");
            $("#cantidad").append("<option value='50' data-oportunidades='2'>50 con 2 oportunidades c/u.</option>");
            $("#cantidad").append("<option value='25' data-oportunidades='4'>25 con 4 oportunidades c/u.</option>");
            $("#cantidad").append("<option value='20' data-oportunidades='5'>20 con 5 oportunidades c/u.</option>");
            $("#cantidad").append("<option value='10' data-oportunidades='10'>10 con 10 oportunidades c/u.</option>");
            $("#cantidad").append("<option value='5' data-oportunidades='20'>5 con 20 oportunidades c/u.</option>");
        });

        // 3-Digit Tickets
        $("#btnDigitos3").click(function() {
            $("#cantidad").removeAttr("disabled");
            $("#cantidad").html("<option value='0'>- Seleccionar -</option>");
            $("#cantidad").append("<option value='1000' data-oportunidades='1'>1000 con 1 oportunidad c/u.</option>");
            $("#cantidad").append("<option value='500' data-oportunidades='2'>500 con 2 oportunidades c/u.</option>");
            $("#cantidad").append("<option value='250' data-oportunidades='4'>250 con 4 oportunidades c/u.</option>");
            $("#cantidad").append("<option value='125' data-oportunidades='8'>125 con 8 oportunidades c/u.</option>");
            $("#cantidad").append("<option value='100' data-oportunidades='10'>100 con 10 oportunidades c/u.</option>");
            $("#cantidad").append("<option value='50' data-oportunidades='20'>50 con 20 oportunidades c/u.</option>");
        });

        // 4-Digit Tickets
        $("#btnDigitos4").click(function() {
            $("#cantidad").removeAttr("disabled");
            $("#cantidad").html("<option value='0'>- Seleccionar -</option>");
            $("#cantidad").append("<option value='10000' data-oportunidades='1'>10000 con 1 oportunidad c/u.</option>");
            $("#cantidad").append("<option value='5000' data-oportunidades='2'>5000 con 2 oportunidades c/u.</option>");
            $("#cantidad").append("<option value='2500' data-oportunidades='4'>2500 con 4 oportunidades c/u.</option>");
            $("#cantidad").append("<option value='2000' data-oportunidades='5'>2000 con 5 oportunidades c/u.</option>");
            $("#cantidad").append("<option value='1250' data-oportunidades='8'>1250 con 8 oportunidades c/u.</option>");
            $("#cantidad").append("<option value='1000' data-oportunidades='10'>1000 con 10 oportunidades c/u.</option>");
            $("#cantidad").append("<option value='625' data-oportunidades='16'>625 con 16 oportunidades c/u.</option>");
            $("#cantidad").append("<option value='500' data-oportunidades='20'>500 con 20 oportunidades c/u.</option>");
            $("#cantidad").append("<option value='400' data-oportunidades='25'>400 con 25 oportunidades c/u.</option>");
            $("#cantidad").append("<option value='250' data-oportunidades='40'>250 con 40 oportunidades c/u.</option>");
            $("#cantidad").append("<option value='200' data-oportunidades='50'>200 con 50 oportunidades c/u.</option>");
            $("#cantidad").append("<option value='125' data-oportunidades='80'>125 con 80 oportunidades c/u.</option>");
            $("#cantidad").append("<option value='100' data-oportunidades='100'>100 con 100 oportunidades c/u.</option>");
            $("#cantidad").append("<option value='50' data-oportunidades='200'>50 con 200 oportunidades c/u.</option>");
        });

        // 5-Digit Tickets
        $("#btnDigitos5").click(function() {
            $("#cantidad").removeAttr("disabled");
            $("#cantidad").html("<option value='0'>- Seleccionar -</option>");
            $("#cantidad").append("<option value='100000' data-oportunidades='1'>100000 con 1 oportunidad c/u.</option>");
            $("#cantidad").append("<option value='50000' data-oportunidades='2'>50000 con 2 oportunidades c/u.</option>");
            $("#cantidad").append("<option value='25000' data-oportunidades='4'>25000 con 4 oportunidades c/u.</option>");
            $("#cantidad").append("<option value='20000' data-oportunidades='5'>20000 con 5 oportunidades c/u.</option>");
            $("#cantidad").append("<option value='12500' data-oportunidades='8'>12500 con 8 oportunidades c/u.</option>");
            $("#cantidad").append("<option value='10000' data-oportunidades='10'>10000 con 10 oportunidades c/u.</option>");
            $("#cantidad").append("<option value='6250' data-oportunidades='16'>6250 con 16 oportunidades c/u.</option>");
            $("#cantidad").append("<option value='5000' data-oportunidades='20'>5000 con 20 oportunidades c/u.</option>");
            $("#cantidad").append("<option value='4000' data-oportunidades='25'>4000 con 25 oportunidades c/u.</option>");
            $("#cantidad").append("<option value='2500' data-oportunidades='40'>2500 con 40 oportunidades c/u.</option>");
            $("#cantidad").append("<option value='2000' data-oportunidades='50'>2000 con 50 oportunidades c/u.</option>");
            $("#cantidad").append("<option value='1250' data-oportunidades='80'>1250 con 80 oportunidades c/u.</option>");
            $("#cantidad").append("<option value='1000' data-oportunidades='100'>1000 con 100 oportunidades c/u.</option>");
            $("#cantidad").append("<option value='500' data-oportunidades='200'>500 con 200 oportunidades c/u.</option>");
        });

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
            $("#producto").val("");
            $("#cantidad").val("");
            $("#precio").val("");
            $("#oportunidades").val("");
            $("#fecha").val("");
            $("#btnradio2").prop("checked", true);
            $("#btnAgregar").html("Agregar");
            $("#cantidad").attr("disabled", "disabled");
            $("#cantidad").html("<option value='0'>Seleccionar dígitos</option>");
            $("#btnDigitos2").prop("checked", false);
            $("#btnDigitos3").prop("checked", false);
            $("#btnDigitos4").prop("checked", false);
            $("#btnDigitos5").prop("checked", false);

        });

        //function when btnEdit is clicked to show modalEdit
        $(document).on("click", ".btn-edit", function() {
            var id = $(this).attr("data-id");
            var producto = $(this).attr("data-producto");
            var cantidad = $(this).attr("data-cantidad");
            var precio = $(this).attr("data-precio");
            var oportunidades = $(this).attr("data-oportunidades");
            var fecha = $(this).attr("data-fecha");
            var estado = $(this).attr("data-estado");
            var digitos = $(this).attr("data-digitos");
            if (digitos == 2) {
                $("#btnDigitos2").click();
            } else if (digitos == 3) {
                $("#btnDigitos3").click();
            } else if (digitos == 4) {
                $("#btnDigitos4").click();
            } else if (digitos == 5) {
                $("#btnDigitos5").click();
            }
            $("#id").val(id);
            $("#producto").val(producto);
            $("#cantidad").attr("disabled", "disabled");
            $("#cantidad").val(cantidad);
            $("#precio").val(precio);
            $("#fecha").val(fecha);
            if (estado == 1) {
                $("#btnradio1").prop("checked", true);
            } else {
                $("#btnradio2").prop("checked", true);
            }

            //disable radio buttons
            $("#btnDigitos2").attr("disabled", "disabled");
            $("#btnDigitos3").attr("disabled", "disabled");
            $("#btnDigitos4").attr("disabled", "disabled");
            $("#btnDigitos5").attr("disabled", "disabled");

            $("#btnAgregar").html("Actualizar");
            $("#basicModal").modal("show");
        });

        $(document).on("click", ".btn-switch", function() {
            var id = $(this).attr("data-id");
            $.ajax({
                type: "POST",
                url: "procedures/switchEstado.php",
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

                        //reload table data
                        $("#tablaRifas").load("procedures/fetchRifasTable.php");
                        //destroy datatable
                        $("#tablaRifas").DataTable().destroy();
                        //set timeout then reload datatable with spanish language
                        setTimeout(function() {
                            $("#tablaRifas").DataTable({
                                "language": {
                                    "url": "https://cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json",
                                    "emptyTable": "No se han creado rifas."
                                }
                            });
                        }, 1);

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

        // Handle form submission when the "Agregar" button is clicked
        $("#btnAgregar").click(function() {
            // Get the form data
            var id = $("#id").val();
            var producto = $("#producto").val();
            var cantidad = $("#cantidad").val();
            var oportunidades = $("#cantidad option:selected").attr("data-oportunidades");
            var precio = $("#precio").val();
            var fecha = $("#fecha").val();
            if ($("#btnradio1").is(':checked')) {
                var estado = 1;
            } else {
                var estado = 0;
            }

            // Perform basic validation
            if (producto === '' || cantidad === 0 || oportunidades === 0 || precio === '' || fecha === '') {
                notif("warning", "fas fa-exclamation-circle", "¡Atención!", "Ahora", "complete todos los campos");
                return;
            }

            if ($("#btnDigitos2").is(':checked')) {
                var digitos = 2;
            } else if ($("#btnDigitos3").is(':checked')) {
                var digitos = 3;
            } else if ($("#btnDigitos4").is(':checked')) {
                var digitos = 4;
            } else if ($("#btnDigitos5").is(':checked')) {
                var digitos = 5;
            } else {
                notif("warning", "fas fa-exclamation-circle", "¡Atención!", "Ahora", "Seleccione la cantidad de dígitos.");
            }

            //validate if the date is older than today but include today
            // date_default_timezone_set('America/Mexico_City');
            var today = new Date();
            var date = new Date(fecha);
            if (date < today) {
                notif("warning", "fas fa-exclamation-circle", "¡Atención!", "Ahora", "La fecha de la rifa debe ser por lo menos de un día a partir de la fecha actual.");
                return;
            }

            if (id != '') {
                var procedure = 'updateRifa';
            } else {
                var procedure = 'addRifa';
            }

            // Perform additional validation here if needed
            // ...

            //change the button to a spinner during request
            $("#btnAgregar").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Cargando...');
            $("#btnAgregar").prop("disabled", true);
            $("#btnCancelar").prop("disabled", true);

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
                    digitos: digitos,
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
                        //destroy datatable
                        $("#tablaRifas").DataTable().destroy();
                        //set timeout then reload datatable with spanish language
                        setTimeout(function() {
                            $("#tablaRifas").DataTable({
                                "language": {
                                    "url": "https://cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json",
                                    "emptyTable": "No se han creado rifas."
                                }
                            });
                        }, 10);
                    } else {
                        // Error notification
                        notif("warning", "fa-solid fa-triangle-exclamation", "¡Atención!", "Ahora", message);
                    }
                },
                error: function(xhr, status, error) {
                    notif("danger", "fa-solid fa-skull-crossbones", "¡Error!", "Ahora", "Ha ocurrido un error, contacte a soporte.");
                },
                complete: function(xhr, status) {
                    // Change the button to a success state
                    $("#btnAgregar").html("Actualizar");
                    $("#btnAgregar").prop("disabled", false);
                    $("#btnCancelar").prop("disabled", false);
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
                    //destroy datatable
                    $("#tablaRifas").DataTable().destroy();
                    //set timeout then reload datatable with spanish language
                    setTimeout(function() {
                        $("#tablaRifas").DataTable({
                            "language": {
                                "url": "https://cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json",
                                "emptyTable": "No se han creado rifas."
                            }
                        });
                    }, 10);

                } else {
                    // Error notification
                    notif("warning", "fa-solid fa-triangle-exclamation", "¡Atención!", "Ahora", message);
                }
                //reload datatable after a 200 ms delay
                setTimeout(function() {
                    $("#tablaRifas").DataTable();
                }, 200);
            },
            error: function(xhr, status, error) {
                notif("danger", "fa-solid fa-skull-crossbones", "¡Error!", "Ahora", "Ha ocurrido un error, contacte a soporte.");
            }
        });
    }
</script>
<?php include('masterpage/footer.php'); ?>