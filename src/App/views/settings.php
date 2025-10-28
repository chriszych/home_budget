
  <?php include $this->resolve("partials/_header.php"); ?>

  <section id="mainPageContent">

    <div class="container d-flex flex-column justify-content-center align-items-center text-center py-4">
      <div class="col-12 col-md-8 col-lg-5 py-1">
        <div class="d-grid gap-3">
          <a href="../categories/list/income" class="btn btn-lg rounded-3 btn-outline-primary w-100 w-md-50 mx-auto">Edit my income categories</a>
          <a href="./categories/list/expense" class="btn btn-lg rounded-3 btn-outline-primary w-100 w-md-50 mx-auto">Edit my expense categories</a>
          <a href="./categories/list/paymentMethod" class="btn btn-lg rounded-3 btn-outline-primary w-100 w-md-50 mx-auto">Edit my payment methods</a>
          <a href="./editUser" class="btn btn-lg rounded-3 btn-outline-primary w-100 w-md-50 mx-auto">Edit my account</a>
          <a href="./changePassword" class="btn btn-lg rounded-3 btn-outline-primary w-100 w-md-50 mx-auto">Change my password</a>
          <a href="./deleteUser" class="btn btn-lg rounded-3 btn-outline-primary w-100 w-md-50 mx-auto">Delete my account</a>
        </div>
      </div>
    </div>

  </section>
  
<!-- Footer -->
<?php include $this->resolve("partials/_footer.php"); ?>