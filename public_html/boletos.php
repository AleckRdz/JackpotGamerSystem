<?php include_once("masterpage/header.php"); ?>

<div class="page-heading">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 offset-lg-2 header-text">
        <h2>Participa en las rifas de <em>Jackpot GAMER</em></h2>
        <p>Puedes consultar algún número de boleto y comprobar el estado actual del boleto, seleccionar los boletos de la lista o generar una elección de boletos al azar.</p>
      </div>
    </div>
  </div>
</div>

<!-- verificador de boletos -->
<div class="search-form mb-5">
  <div class="container d-flex align-items-center justify-content-center">
    <div class="row">
      <div class="col-lg-12">
        <div id="search-form" name="gs" method="submit" role="search" action="">
          <h4 class="text-center mb-3">Verificador de Boletos</h4>
          <div class="row">
            <div class="col-lg-8 col-md-12">
              <fieldset>
                <label for="contest" class="form-label">Número de boleto:</label>
                <input type="number" name="contest" class="searchText" id="buscador" placeholder="Número..." autocomplete="on" required>
              </fieldset>
            </div>
            <div class="col-lg-4 col-md-12 text-center">
              <fieldset>
                <button class="main-button btn-buscar">Buscar</button>
              </fieldset>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- premios section -->
<section class="testimonials" id="sobreNosotros" style="background-image: url(assets/img/fondoSection.jpg)">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="col-lg-8 offset-lg-2">
          <div class="item" style="background-color: white;">
            <div class="section-heading text-center outlined-text mb-4">
              <h4>PREMIOS DEL<em> SORTEO</em></h4>
            </div>
            <div class="content">
              <div class="left-content">
                <p>Premio mayor:</p>
                <p>10 de Octubre del 2023</p>
                <ul>
                  <li>- PC AMD Radeon Rx 6600, Ryzen 5 3600, 16gb RAM, SSD 500gb.</li>
                  <li>- Monitor Gamer 27" Balam Rush Ultra Odyssey 165hz FHD.</li>
                  <li>- Mouse Óptico Razer Naga Trinity.</li>
                  <li>- Teclado Gamer HyperX Alloy Elite 2.</li>
                  <li>- Mouse Pad Gamer Antideslizante 80 x 30cm.</li>
                </ul>
                <span>______________________________________</span>
                <p>Presorteo:</p>
                <p>3 de Octubre del 2023</p>
                <ul>
                  <li>- Silla Gamer Reclinable, Ajustable, Giratoria, Ergonómica.</li>
                </ul>
                <!-- <h4>Jackpotgamermx® 2023</h4>
                <span>Ciudad Victoria, Tamps.</span> -->
              </div>
              <div class="image">
                <img src="assets/img/premioOctubre23.jpeg" alt="premio jackpotGamer">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</section>

<!-- área de boletos -->
<div class="container" id="boletos" style="padding-top:60px">
  <div class="row">
    <div class="col-lg-12 mt-4">
      <div class="section-heading text-center">
        <h4>LISTA DE <em>BOLETOS</em></h4>
        <h6 class="text-muted">Boletos restantes: <b><span class="boletos-restantes">-</span></b></h6>
        <h6 class="text-muted">Oportunidades por boleto: <b><span class="oportunidad-boleto">-</span></b></h6>
        <h6 class="text-muted">Precio por boleto: <b>$<span class="precio-boleto">-</span></b></h6>
        <h6 class="text-muted">Boletos seleccionados: <b><span class="contador-boletos">-</span></b></h6>
        <h6 class="text-muted">Precio a pagar: <b>$<span class="precio-lista">-</span></b></h6>
        <div class="ticket-list"></div>
        <div class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAzar">Elegir al Azar</div>
        <div class="btn btn-primary btn-apartar" hidden>Apartar</div>
        <hr>
        <h6 class="text-muted"><b>Atención:</b> Para seleccionar o retirar tiene que presionar el boleto, se muestran solamente un máximo de 500 boletos.</h6>
      </div>
    </div>
  </div>
  <div class="ticket-container" id="contenedor"></div>
</div>

<!-- botón de bajar -->
<div class="container">
  <div class="row">
    <div class="col-lg-12 mt-4">
      <div class="section-heading text-center">
        <a href="#boletos" id="btnDown" class="btn btn-primary btn-bajar"><i class="fa-solid fa-arrow-down"></i> Lista de boletos <i class="fa-solid fa-arrow-down"></i></a>
      </div>
    </div>
  </div>
</div>

<!-- botón de subir -->
<div class="container">
  <div class="row">
    <div class="col-lg-12 mt-4">
      <div class="section-heading text-center">
        <a href="#boletos" id="btnUp" class="btn btn-primary btn-regresar"><i class="fa-solid fa-arrow-up"></i></a>
      </div>
    </div>
  </div>
</div>

<!-- modal para elección al azar -->
<div class="modal fade" id="modalAzar" tabindex="-1" aria-labelledby="modalAzarLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalAzarLabel">Elegir al Azar</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="container">
            <label for="cantidad" class="form-label">Cantidad de boletos:</label>
            <select name="cantidad" id="cantidad" class="form-control">
              <option value="0">- Seleccionar -</option>
              <option value="1">1 boleto</option>
              <option value="2">2 boletos</option>
              <option value="3">3 boletos</option>
              <option value="4">4 boletos</option>
              <option value="5">5 boletos</option>
              <option value="10">10 boletos</option>
              <option value="20">20 boletos</option>
              <option value="30">30 boletos</option>
              <option value="50">50 boletos</option>
              <option value="100">100 boletos</option>
            </select>
          </div>
          <div class="row">
            <div class="mt-3 mb-3">
              <label for="cantidad" class="form-label" hidden>Boletos:</label>
              <div class="ticket-list-random"></div>
            </div>
          </div>
          <div class="row text-center">
            <div class="mt-4">
              <fieldset>
                <button class="btn btn-generar mb-2">Generar</button>
                <button class="main-button btn btn-apartar-azar mb-2" hidden>Apartar Números</button>
              </fieldset>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- modal para apartar boletos -->
<div class="modal fade" id="modalApartar" tabindex="-1" aria-labelledby="modalApartarLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalApartarLabel">Apartar Boletos</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-12">
            <label for="nombre" class="form-label">Nombre Completo:</label>
            <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre y apellidos...">
          </div>
        </div>
        <div class="row">
          <div class="col-lg-6 mt-3">
            <label for="telefono" class="form-label">Teléfono:</label>
            <input type="text" name="telefono" id="telefono" maxlength="10" class="form-control" placeholder="Ingrese su número telefónico...">
          </div>
          <div class="col-lg-6 mt-3">
            <label for="estado" class="form-label">Estado:</label>
            <select name="estado" id="estado" class="form-control">
              <option value="0">- Seleccionar -</option>
              <option value="Aguascalientes">Aguascalientes</option>
              <option value="Baja California">Baja California</option>
              <option value="Baja California Sur">Baja California Sur</option>
              <option value="Campeche">Campeche</option>
              <option value="Chiapas">Chiapas</option>
              <option value="Chihuahua">Chihuahua</option>
              <option value="Coahuila">Coahuila</option>
              <option value="Colima">Colima</option>
              <option value="Durango">Durango</option>
              <option value="Guanajuato">Guanajuato</option>
              <option value="Guerrero">Guerrero</option>
              <option value="Hidalgo">Hidalgo</option>
              <option value="Jalisco">Jalisco</option>
              <option value="Estado de México">Estado de México</option>
              <option value="Michoacán">Michoacán</option>
              <option value="Morelos">Morelos</option>
              <option value="Nayarit">Nayarit</option>
              <option value="Nuevo León">Nuevo León</option>
              <option value="Oaxaca">Oaxaca</option>
              <option value="Puebla">Puebla</option>
              <option value="Querétaro">Querétaro</option>
              <option value="Quintana Roo">Quintana Roo</option>
              <option value="San Luis Potosí">San Luis Potosí</option>
              <option value="Sinaloa">Sinaloa</option>
              <option value="Sonora">Sonora</option>
              <option value="Tabasco">Tabasco</option>
              <option value="Tamaulipas">Tamaulipas</option>
              <option value="Tlaxcala">Tlaxcala</option>
              <option value="Veracruz">Veracruz</option>
              <option value="Yucatán">Yucatán</option>
              <option value="Zacatecas">Zacatecas</option>
              <option value="Fuera de México">Otro</option>
            </select>
          </div>
          <div class="row">
            <div class="col-lg-12 mt-3">
              <label for="cantidad" class="form-label">Boletos seleccionados:</label>
              <div class="ticket-list-usuario"></div>
            </div>
          </div>
          <div class="row text-center">
            <div class="col mt-4">
              <fieldset>
                <button class="main-button btn btn-primary btn-pagar">Pagar</button>
              </fieldset>
            </div>
          </div>
        </div>
      </div>
      <div class="ticket-random"></div>
    </div>
  </div>
</div>



<script>
  $(document).ready(function() {
    cargarBoletos();
    getDigits();

    // show button if there are tickets selected
    $(".ticket-list").on("DOMSubtreeModified", function() {
      if ($(".ticket-list").children().length > 0) {
        $(".btn-apartar").removeAttr("hidden");
        $("#btnUp").addClass("btn-pulse");
      } else {
        $(".btn-apartar").attr("hidden", true);
        $("#btnUp").removeClass("btn-pulse");
      }
    });

    //function to prevent numbers in #nombre input
    $("#nombre").on("keypress", function(event) {
      var regex = new RegExp("^[a-zA-Z ]+$");
      var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
      if (!regex.test(key)) {
        event.preventDefault();
        return false;
      }
    });

    //function to prevent letters in #telefono input
    $("#telefono").on("keypress", function(event) {
      var regex = new RegExp("^[0-9]+$");
      var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
      if (!regex.test(key)) {
        event.preventDefault();
        return false;
      }
    });

    document.addEventListener("scroll", function() {
      const boletosSection = document.querySelector("#contenedor");
      const returnButton = document.querySelector(".btn-regresar");

      if (boletosSection && returnButton) {
        const rect = boletosSection.getBoundingClientRect();

        if (rect.top < window.innerHeight && rect.bottom >= 0) {
          returnButton.classList.add("btn-corner");
        } else {
          returnButton.classList.remove("btn-corner");
        }
      }
    });

    document.addEventListener("scroll", function() {
      const boletosSection = document.querySelector("#contenedor");
      const returnButton = document.querySelector(".btn-bajar");

      if (boletosSection && returnButton) {
        const rect = boletosSection.getBoundingClientRect();

        if (rect.top > window.innerHeight && rect.bottom >= 0) {
          returnButton.classList.add("btn-corner");
          $(".btn-bajar").removeAttr("hidden");
        } else {
          returnButton.classList.remove("btn-corner");
          $(".btn-bajar").attr("hidden", true);
        }
      }
    });

    $(".btn-generar").click(function() {
      var cantidad = $("#cantidad").val();
      //hide buttons and label
      $(".btn-apartar-azar").attr("hidden", true);
      $(".ticket-list-random").prev().attr("hidden", true);
      //change button text to Generando with a spinner
      $(".btn-generar").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Generando...');
      $(".btn-generar").attr("disabled", true);
      $(".ticket-list-random").html("");

      if (cantidad > 0 && cantidad <= 100) {
        $.ajax({
          type: "POST",
          url: "procedures/generateBoletos.php",
          data: {
            cantidad: cantidad
          },
          success: function(response) {
            //play a gif then remove it
            var gifPath = "assets/img/slot.gif"; // Replace with the actual path to your GIF
            var timestamp = new Date().getTime(); // Generate a unique timestamp
            var gifUrl = gifPath + "?v=" + timestamp; // Add the timestamp to the GIF's path

            $(".ticket-list-random").html('<img src="' + gifUrl + '" alt="loading" class="gif">');
            //3 seconds delay
            setTimeout(function() {
              //show numbers generated
              $('.ticket-list-random').html(response);
              // show button
              $(".btn-apartar-azar").removeAttr("hidden");
              // show label
              $(".ticket-list-random").prev().removeAttr("hidden");
              //change button text to Regenerar
              $(".btn-generar").text("Volver a Generar");
              $(".btn-generar").attr("disabled", false);
            }, 4000);
          }
        });
      } else {
        notif("warning", "fa-solid fa-triangle-exclamation", "¡Atención!", "Ahora", "Seleccione una cantidad válida de boletos a generar.");
        $(".btn-generar").text("Generar");
        $(".btn-generar").attr("disabled", false);
      }
    });

    //function when btn-apartar is clicked to open modal, take each of the selected tickets number and put them in the modal separated by commas, last one gets a dot
    $(".btn-apartar").click(function() {
      var ticketList = $(".ticket-list").children();
      var ticketListLength = ticketList.length;
      var ticketListText = "";

      for (var i = 0; i < ticketListLength; i++) {
        var ticket = ticketList[i].textContent;
        ticketListText += ticket + (i === ticketListLength - 1 ? "" : ", ");
      }

      $.ajax({
        type: "POST",
        url: "procedures/getOportunidades.php",
        data: {
          numeros: ticketListText
        },
        success: function(response) {
          $('.ticket-list-usuario').html(response);
          $("#modalApartar").modal("show");
        },
        error: function() {
          notif("danger", "fa-solid fa-times-octagon", "¡Error!", "Ahora", "Ocurrió un error al cargar los boletos seleccionados.");
        }
      });

    });

    //function when btn-buscar is clicked
    $(".btn-buscar").click(function() {
      var numero = $("#buscador").val();
      var digitos = $("#buscador").attr("data-digits");

      if (numero == "") {
        notif("warning", "fa-solid fa-triangle-exclamation", "¡Atención!", "Ahora", "Ingrese un número de boleto.");
        $("#buscador").focus();
        return;
      }

      if (numero.length != digitos) {
        notif("warning", "fa-solid fa-triangle-exclamation", "¡Atención!", "Ahora", "Los boletos son de " + digitos + " dígitos.");
        $("#buscador").focus();
        return;
      }

      $.ajax({
        type: "POST",
        url: "procedures/buscarBoleto.php",
        data: {
          numero: numero
        },
        success: function(response) {
          response = JSON.parse(response);
          if (response.status === 1) {
            //open a new window and pass data to it to show the ticket
            window.open("verificador.php?numero=" + numero, "_blank");
          } else {
            notif("warning", "fa-solid fa-times-octagon", "¡Atención!", "Ahora", response.message);
          }
        },
        error: function() {
          notif("danger", "fa-solid fa-times-octagon", "¡Error!", "Ahora", "Ocurrió un error al buscar el boleto.");
        }
      });
    });

    //function when btn-apartar-azar is clicked to open modal, show numbers generated on modal
    $(".btn-apartar-azar").click(function() {
      var ticketList = $(".ticket-list-random").html();

      $("#modalApartar").modal("show");
      $(".ticket-list-usuario").html(ticketList);
      $("#modalAzar").modal("hide");
    });

    //on modal generar close clean inputs
    $("#modalAzar").on("hidden.bs.modal", function() {
      $("#cantidad").val(0);
      $(".ticket-list-random").html("");
      $(".ticket-list-random").prev().attr("hidden", true);
      $(".btn-generar").text("Generar");
      $(".btn-apartar-azar").attr("hidden", true);
    });

    //on btn-pagar click
    $(".btn-pagar").click(function() {
      var nombre = $("#nombre").val();
      var telefono = $("#telefono").val();
      var estado = $("#estado").val();
      var precioBoleto = $(".precio-boleto").text();
      var precioTotal = 0;

      //validate if nombre and telefono are not empty, also telefono must be 10 digits long
      if (nombre == "" || telefono == "" || estado == 0) {
        notif("warning", "fa-solid fa-triangle-exclamation", "¡Atención!", "Ahora", "Ingrese todos los datos solicitados.");
        return;
      }

      if (telefono.length != 10) {
        notif("warning", "fa-solid fa-triangle-exclamation", "¡Atención!", "Ahora", "Ingrese un número telefónico válido (10 dígitos).");
        return;
      }

      //assign all numbers on the table's Número(s) column to a variable
      var numeros = [];
      var extras = [];

      $('.table tr').each(function() {
        var value = $(this).find('td:eq(0)').text(); // Change 1 to the column index you want
        if (value.trim() !== '') {
          numeros.push(value);
        }
        precioTotal++;
      });

      $('.table tr').each(function() {
        var value = $(this).find('td:eq(1)').text(); // Change 1 to the column index you want
        if (value.trim() !== '') {
          extras.push(value);
        }
      });

      //convert array to string separated by comma and space
      var boletos = numeros.join(', ');

      $.ajax({
        type: "POST",
        url: "procedures/apartarBoletos.php",
        data: {
          nombre: nombre,
          telefono: telefono,
          estado: estado,
          numeros: boletos
        },
        success: function(response) {
          if (response.status === 1) {
            notif("success", "fa-solid fa-check", "¡Éxito!", "Ahora", response.message);
            $("#modalApartar").modal("hide");
            var oportunidades = response.oportunidades;
            var precioTotal = response.total;
            //redirect to whatsapp
            var message = `Hola, aparté boletos de la rifa 🎮🏆
————————————
🎫 *BOLETO(S):* 
${boletos}

🍀 *OPORTUNIDAD(ES) EXTRA:*
${oportunidades}

👤 *NOMBRE:* ${nombre}
🌐 *ESTADO:* ${estado}

💰 *PRECIO A PAGAR:*
💲${precioTotal}    
————————————
👇 CUENTAS DE PAGO AQUÍ:
www.jackpotgamermx.com/cuentas.php

⚠ *ATENCIÓN:*
El siguiente paso es enviar foto del comprobante de pago por aquí.`;
            window.open("https://api.whatsapp.com/send/?phone=%2B528341458065&text=" + encodeURIComponent(message) + "&type=phone_number&app_absent=0");
            //reload page
            setTimeout(function() {
              location.reload();
            }, 3000);
          } else {
            notif("warning", "fa-solid fa-times-octagon", "¡Atención!", "Ahora", response.message);
          }
        },
        error: function() {
          notif("danger", "fa-solid fa-times-octagon", "¡Error!", "Ahora", "Ocurrió un error al apartar los boletos.");
        }
      });
    });
  });

  function moverTicket(element) {
    const ticket = element;
    const ticketContainer = document.querySelector(".ticket-container");
    const ticketList = document.querySelector(".ticket-list");

    if (ticket && ticketContainer.contains(ticket)) {
      ticketList.appendChild(ticket);
      ticket.classList.add("ticket-item"); // Add a class to style the ticket element
    } else {
      ticketContainer.appendChild(ticket);
      ticket.classList.remove("ticket-item"); // Remove the class if moving back to container
    }

    // Update the ticket count
    const ticketCount = document.querySelectorAll(".ticket-item").length;
    document.querySelector(".contador-boletos").textContent = ticketCount;

    // Update the total price
    const precioBoleto = document.querySelector(".precio-boleto").textContent;
    const precioTotal = ticketCount * precioBoleto;
    document.querySelector(".precio-lista").textContent = precioTotal;
  }

  function cargarBoletos() {
    $.ajax({
      type: "POST",
      url: "procedures/fetchBoletosLibres.php",
      data: $(this).serialize(),
      success: function(response) {
        $('.ticket-container').html(response);
      }
    });
  }

  //function to get the number of digits from the active rifa
  function getDigits() {
    $.ajax({
      type: "POST",
      url: "procedures/getDigits.php",
      success: function(response) {
        response = JSON.parse(response);
        if (response.status === 1) {
          //assign the value to the input data-digits
          $("#buscador").attr("data-digits", response.digitos);
        }
      }
    });
  }
</script>
<?php include_once("masterpage/footer.php"); ?>