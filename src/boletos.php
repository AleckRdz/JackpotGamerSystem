<?php include_once("masterpage/header.php"); ?>

<div class="page-heading">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 offset-lg-2 header-text">
        <h2>Participa en las rifas de <em>JackpotGamer</em></h2>
        <p>Puedes consultar algún número de boleto y comprobar el estado actual del boleto.</p>
      </div>
    </div>
  </div>
</div>

<div class="search-form">
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
<?php include_once("masterpage/footer.php"); ?>