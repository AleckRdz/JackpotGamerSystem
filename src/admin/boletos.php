<?php include('masterpage/header.php'); ?>

<div class="card-body">
    <h4 class="pb-1 mb-2">Boletos</h4>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
            <li class="breadcrumb-item">
                <a href="index.php">Inicio</a>
            </li>
            <li class="breadcrumb-item active">Boletos</li>
        </ol>
    </nav>
    <button type="button" class="btn btn-primary rounded-pill mb-3 btn-validar" data-bs-toggle="modal" data-bs-target="#basicModal">
        <i class="fa-solid fa-gear"></i> Validar Boletos
    </button>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="tablaBoletos" class="table table-hover table-striped"></table>
            </div>
        </div>
    </div>

    <!-- modal para operaciones -->
    <div class="modal fade" id="basicModal" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Validar Boleto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" id="formModificarEstado">
                        <input type="hidden" id="id">
                        <div class="row">
                            <div class="col-md-8 text-center">
                                <label for="boleto" class="form-label">Número de boleto</label>
                                <input type="text" id="boleto" class="form-control" placeholder="Ingrese el número del boleto">
                            </div>
                            <div class="col-md-4 mt-4">
                                <button type="button" class="btn btn-primary" id="btnOperacion">Validar</button>
                            </div>
                        </div>
                        <div class="row g-2 mt-3">
                            <div class="col mb-0 text-center">
                                <label for="btnradio" class="form-label">Tipo de operación</label><br>
                                <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                    <input type="radio" class="btn-check" name="btnradio" id="btnradio1" checked autocomplete="off">
                                    <label class="btn btn-outline-success" for="btnradio1">Validar</label>
                                    <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off">
                                    <label class="btn btn-outline-danger" for="btnradio2">Invalidar</label>
                                    <input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off">
                                    <label class="btn btn-outline-primary" for="btnradio3">Liberar</label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" id="btnCancelar" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    $(document).ready(function() {
        cargarTablaBoletos();

        //bind n key to button click without reloading page
        $(document).keydown(function(e) {
            if (e.which == 78) {
                $('.btn-validar').click();
                return false;
            }
        });        

        //autofocus on modal show
        $('#basicModal').on('shown.bs.modal', function() {
            $('#boleto').trigger('focus');
            //bind enter key to button click without reloading page
            $('#boleto').keypress(function(e) {
                if (e.which == 13) {
                    $('#btnOperacion').click();
                    return false;
                }
            });
            //bind left arrow, up arrow and right arrow keys to radio button selection
            $(document).keydown(function(e) {
                if (e.which == 37) {
                    $('#btnradio1').click();
                    return false;
                } else if (e.which == 38) {
                    $('#btnradio2').click();
                    return false;
                } else if (e.which == 39) {
                    $('#btnradio3').click();
                    return false;
                }
            });
        });

        $('#basicModal').on('hidden.bs.modal', function() {
            $('#boleto').unbind('keypress');
            $(document).unbind('keypress');
            $('#boleto').val('');
        });

        //on radio check change button text and modal title
        $('#btnradio1').click(function() {
            $('#exampleModalLabel1').text('Validar Boleto');
            $('#btnOperacion').text('Validar');
        });

        $('#btnradio2').click(function() {
            $('#exampleModalLabel1').text('Invalidar Boleto');
            $('#btnOperacion').text('Invalidar');
        });

        $('#btnradio3').click(function() {
            $('#exampleModalLabel1').text('Liberar Boleto');
            $('#btnOperacion').text('Liberar');
        });

        //on button click get boleto and radio checked value to define procedure
        $('#btnOperacion').click(function() {
            var boleto = $('#boleto').val();
            if (boleto == '') {
                notif("warning", "fa-solid fa-triangle-exclamation", "¡Atención!", "Ahora", "Proporcione el número de boleto.");
                return;
            }
            //if radio1 is checked then assign var procedure
            if ($('#btnradio1').is(':checked')) {
                var operacion = 'validado';
                var textoBoton = 'Validar';
                var tipo = 2;
            } else if ($('#btnradio2').is(':checked')) {
                var operacion = 'invalidado';
                var textoBoton = 'Invalidar';
                var tipo = 1;
            } else if ($('#btnradio3').is(':checked')) {
                var operacion = 'liberado';
                var textoBoton = 'Liberar';
                var tipo = 0;
            } else {
                notif("warning", "fa-solid fa-triangle-exclamation", "¡Atención!", "Ahora", "Seleccione un tipo operación.");
                return;
            }

            //change the button to a spinner during request
            $("#btnOperacion").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Cargando...');
            $("#btnOperacion").prop("disabled", true);
            $("#btnCancelar").prop("disabled", true);

            $.ajax({
                url: 'procedures/procesarBoleto.php',
                type: 'POST',
                data: {
                    boleto: boleto,
                    tipo: tipo
                },
                success: function(response) {
                    status = response.status;
                    message = response.message;
                    if (status == '1') {
                        notif("success", "fa-solid fa-check", "¡Éxito!", "Ahora", "Boleto " + operacion + " correctamente.");
                        cargarTablaBoletos();
                        $('#boleto').val('');
                    } else {
                        //show error notification
                        notif("warning", "fa-solid fa-times", "¡Error!", "Ahora", message);
                    }
                },
                error: function() {
                    notif("danger", "fa-solid fa-times", "¡Error!", "Ahora", message);
                }
            });

            //change the button back to normal after request
            $("#btnOperacion").html(textoBoton);
            $("#btnOperacion").prop("disabled", false);
            $("#btnCancelar").prop("disabled", false);
        });
    });

    function cargarTablaBoletos() {
        //show spinner
        $("#tablaBoletos").html('<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>');
        // Load the table with the existing data
        $("#tablaBoletos").load("procedures/fetchBoletosTable.php", function() {
            //reload table data
            $("#tablaBoletos").load("procedures/fetchBoletosTable.php");
            //destroy datatable
            $("#tablaBoletos").DataTable().destroy();
            //set timeout then reload datatable with spanish language
            setTimeout(function() {
                $("#tablaBoletos").DataTable({
                    "language": {
                        "url": "https://cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json",
                        "emptyTable": "No hay rifas activas."
                    }
                });
            }, 1);
        });
    }
</script>
<?php include('masterpage/footer.php'); ?>