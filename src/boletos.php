<?php include_once("masterpage/header.php"); ?>

<div class="page-heading">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 offset-lg-2 header-text">
        <h2>Participa en las rifas de <em>Jackpot GAMER</em></h2>
        <p>Puedes consultar algún número de boleto y comprobar el estado actual del boleto, seleccionar los boletos de la lista o generar una elección de boletos al azar.</p>
        <div class="buttons">
          <div class="border-button">
            <a href="boletos.php" style="color: white;border-color: white;"></i>Elegir al Azar</a>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<div class="search-form" id="boletos">
  <div class="container d-flex align-items-center justify-content-center">
    <div class="row">
      <div class="col-lg-12">
        <form id="search-form" name="gs" method="submit" role="search" action="#">
          <div class="row">
            <div class="col-lg-8">
              <fieldset>
                <label for="contest" class="form-label">Número de boleto:</label>
                <input type="text" name="contest" class="searchText" placeholder="Número..." autocomplete="on" required>
              </fieldset>
            </div>
            <div class="col-lg-4">
              <fieldset>
                <button class="main-button">Buscar</button>
              </fieldset>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<br>

<div class="container">
  <div class="row">
    <div class="col-lg-12 mt-4">
      <div class="section-heading text-center">
        <h4>LISTA DE <em>BOLETOS</em></h4>
        <h6 class="text-muted">Boletos restantes: <b><span class="boletos-restantes">-</span></b></h6>
        <h6 class="text-muted">Precio por boleto: <b>$<span class="precio-boleto">-</span></b></h6>
        <h6 class="text-muted">Boletos seleccionados: <b><span class="contador-boletos">-</span></b></h6>
        <h6 class="text-muted">Precio a pagar: <b>$<span class="precio-lista">-</span></b></h6>
        <div class="ticket-list"></div>
        <div class="btn btn-primary btn-apartar" hidden>Apartar</div>
        <hr>
      </div>
    </div>
  </div>
  <div class="ticket-container" id="contenedor"></div>
</div>

<div class="container">
  <div class="row">
    <div class="col-lg-12 mt-4">
      <div class="section-heading text-center">
        <a href="#boletos" class="btn btn-primary btn-regresar">Carrito</a>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    cargarBoletos();

    // show button if there are tickets selected
    $(".ticket-list").on("DOMSubtreeModified", function() {
      if ($(".ticket-list").children().length > 0) {
        $(".btn-apartar").removeAttr("hidden");
      } else {
        $(".btn-apartar").attr("hidden", true);
      }
    });

    document.addEventListener("scroll", function() {
      const boletosSection = document.querySelector("#contenedor");
      const returnButton = document.querySelector(".btn-regresar");

      if (boletosSection && returnButton) {
        const rect = boletosSection.getBoundingClientRect();

        if (rect.top <= window.innerHeight && rect.bottom >= 0) {
          returnButton.classList.add("btn-corner");
        } else {
          returnButton.classList.remove("btn-corner");
        }
      }
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
      url: "admin/procedures/fetchBoletosLibres.php",
      data: $(this).serialize(),
      success: function(response) {
        $('.ticket-container').html(response);
      }
    });
  }
</script>
<?php include_once("masterpage/footer.php"); ?>