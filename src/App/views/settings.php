
  <?php include $this->resolve("partials/_header.php"); ?>

  <!-- mainPageContent -->
  <section id="mainPageContent">

    <section class="py-3 text-center container">

      <?php include $this->resolve("partials/_toggleSettings.php"); ?>

    </section>

    <section class="py-3 col-12 col-md-8 col-lg-4 text-center container">

        <div class="d-grid gap-2 d-md-flex justify-content-md-center">
          <button class="w-100 mb-3 btn btn-lg rounded-3 btn-outline-primary my-1 mb-1 my-md-3 mb-md-3" role="button" type="submit">Kategorie wydatków</button>
        </div>
        <div class="d-grid gap-2 d-md-flex justify-content-md-center">
          <button class="w-100 mb-2 btn btn-lg rounded-3 btn-outline-primary my-1 mb-1 my-md-3 mb-md-3" role="button" type="submit">Kategorie przychodów</button>
        </div>
        <div class="d-grid gap-2 d-md-flex justify-content-md-center">
          <button class="w-100 mb-2 btn btn-lg rounded-3 btn-outline-primary my-1 mb-1 my-md-3 mb-md-3" role="button" type="submit">Metody płatności</button>
        </div>
        <div class="d-grid gap-2 d-md-flex justify-content-md-center">
          <button class="w-100 mb-2 btn btn-lg rounded-3 btn-outline-primary my-1 mb-1 my-md-3 mb-md-3" role="button" type="submit">Zmień hasło</button>
        </div>
        <div class="d-grid gap-2 d-md-flex justify-content-md-center">
          <button class="w-100 mb-2 btn btn-lg rounded-3 btn-outline-primary my-1 mb-1 my-md-3 mb-md-3" role="button" type="submit">Usuń konto</button>
        </div>

    </section>


  </section>
  
<!-- Footer -->
<?php include $this->resolve("partials/_footer.php"); ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.0/dist/chart.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>


</body>

</html>