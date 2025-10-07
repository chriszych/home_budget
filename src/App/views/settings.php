
  <?php include $this->resolve("partials/_header.php"); ?>

  <!-- mainPageContent -->
  <section id="mainPageContent">

    <div class="container d-flex flex-column justify-content-center align-items-center text-center py-4">
      <div class="col-12 col-md-8 col-lg-5 py-1">
        <div class="d-grid gap-3">
          <a href="./listIncomeCategory" class="btn btn-lg rounded-3 btn-outline-primary w-100 w-md-50 mx-auto">Edytuj kategorie przychodów</a>
          <a href="./listExpenseCategory" class="btn btn-lg rounded-3 btn-outline-primary w-100 w-md-50 mx-auto">Edytuj kategorie wydatków</a>
          <a href="./listPaymentMethod" class="btn btn-lg rounded-3 btn-outline-primary w-100 w-md-50 mx-auto">Edytuj metody płatności</a>
          <a href="./editUser" class="btn btn-lg rounded-3 btn-outline-primary w-100 w-md-50 mx-auto">Edytuj moje konto</a>
          <a href="./deleteUserAccount" class="btn btn-lg rounded-3 btn-outline-primary w-100 w-md-50 mx-auto">Usuń moje konto</a>
        </div>
      </div>
    </div>

  </section>
  
<!-- Footer -->
<?php include $this->resolve("partials/_footer.php"); ?>