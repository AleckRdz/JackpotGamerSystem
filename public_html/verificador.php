<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boleto</title>
    <link rel="icon" href="assets/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="assets/css/verificador.css">
</head>

<body>
    <div class="container-fluid">
        <div class="text-center">
            <div class="ticket light">
                <div class="ticket-head text-center" style="background-image: url(assets/img/fondoSection.jpg)">
                    <div class="layer"></div>
                    <div class="from-to">Jackpot GAMER</div>
                </div>
                <div class="ticket-body">
                    <div class="passenger">
                        <p>COMPRADOR</p>
                        <h4 id="lblNombre">-</h4>
                    </div>
                    <div class="flight-info row">
                        <div class="col">
                            <p>ESTADO</p>
                            <h4 id="lblEstado">-</h4>
                        </div>
                    </div>
                    <div class="flight-info row">
                        <div class="col-6">
                            <p>NÚMERO</p>
                            <h4 id="lblNumero">-</h4>
                        </div>
                        <div class="col-6">
                            <p>PAGADO</p>
                            <h4 id="lblPagado">-</h4>
                        </div>
                    </div>
                    <div class="flight-info row">
                        <div class="col-xs-12 col-md-12">
                            <p>OPORTUNIDADES EXTRA</p>
                            <h4 id="lblOportunidades">-</h4>
                        </div>
                    </div>
                </div>
                <div class="footer">
                    <div class="disclaimer">Las probabilidades son 0 solamente cuando no compras boleto.</div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // function on document ready to load data from buscarBoleto.php based on number on url
    $(document).ready(function() {
        var urlParams = new URLSearchParams(window.location.search);
        var numero = urlParams.get('numero');
        $.ajax({
            url: 'procedures/buscarBoleto.php',
            type: 'POST',
            data: {
                numero: numero
            },
            dataType: 'json',
            success: function(response) {
                if (response.status == 1) {
                    $('#lblNombre').html(response.nombre);
                    $('#lblEstado').html(response.estado);
                    $('#lblNumero').html(response.numero);
                    $('#lblPagado').html(response.pagado);
                    $('#lblOportunidades').html(response.oportunidades);
                } else {
                    alert(response.message);
                }
            }
        });
    });

</script>

</html>