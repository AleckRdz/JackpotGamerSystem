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
    <b>Acciones en masa:</b><br>
    <button type="button" class="btn btn-success rounded-pill mb-3" data-bs-toggle="" data-bs-target="#basicModal">
        <i class="fas fa-square-check"></i> Validar
    </button>
    <button type="button" class="btn btn-danger rounded-pill mb-3" data-bs-toggle="modal" data-bs-target="#basicModal">
        <i class="fas fa-square-xmark"></i> Invalidar
    </button>
    <button type="button" class="btn btn-primary rounded-pill mb-3" data-bs-toggle="modal" data-bs-target="#basicModal">
        <i class="fas fa-repeat"></i> Liberar
    </button>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="tablaBoletos" class="table table-hover table-striped"></table>
            </div>
        </div>
    </div>

</div>

<script>
    $(document).ready(function() {
        //show spinner
        $("#tablaBoletos").html('<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>');
        // Load the table with the existing data
        $("#tablaBoletos").load("procedures/fetchBoletosTable.php", function() {
            //initialize datatable with spanish language from cdn
            $('#tablaBoletos').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json",
                    "emptyTable": "No hay rifas activas."
                }
            });
        });
    });
</script>
<?php include('masterpage/footer.php'); ?>