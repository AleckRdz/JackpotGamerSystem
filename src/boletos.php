<?php include_once("masterpage/header.php"); ?>

<div class="page-heading">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 offset-lg-2 header-text">
        <h2>Participa en las rifas de <em>JackpotGamer</em></h2>
        <p>Puedes consultar algún número de boleto o los boletos que ha comprado cierta persona por su nombre y comprobar el estado actual del boleto.</p>
      </div>
    </div>
  </div>
</div>

<div class="search-form">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <form id="search-form" name="gs" method="submit" role="search" action="#">
          <div class="row">
            <div class="col-lg-4">
              <fieldset>
                <label for="contest" class="form-label">Número de boleto</label>
                <input type="text" name="contest" class="searchText" placeholder="Número..." autocomplete="on" required>
              </fieldset>
            </div>
            <div class="col-lg-4">
              <fieldset>
                <label for="nombreParticipante" class="form-label">Nombre del participante</label>
                <input type="text" name="nombreParticipante" class="searchText" placeholder="Nombre..." autocomplete="on" required>                
              </fieldset>
            </div>
            <div class="col-lg-2">
              <fieldset>
                <label for="edicion" class="form-label">Edición</label>
                <select name="edicion" class="form-select" aria-label="Default select example" id="edicion" onchange="this.form.click()">
                  <option selected>Edición...</option>
                  <option value="1">1ra</option>
                </select>
              </fieldset>
            </div>
            <div class="col-lg-2">
              <fieldset>
                <button class="main-button">Search Now</button>
              </fieldset>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php include_once("masterpage/footer.php"); ?>