<?php include $this->resolve("partials/_header.php"); ?>

  
<!-- userEditPage -->
<main id="registerPage">

  <div class="py-3 col-12 col-md-8 col-lg-5 text-center container">

    <div class="px-5 py-5 border-bottom-0 text-center">
      <p class="fw-bold m-5 fs-4"><?= $message ?> </p>
    </div>  
				
        <div class="d-grid gap-2 d-md-flex justify-content-md-center">
          <a href="<?= $link ?>" class="w-50 btn btn-lg rounded-3 btn-primary my-0 mb-0" role="button">OK</a>
        </div>

      </form>
    </div>
  </div>
 

</main>

<?php include $this->resolve("partials/_footer.php"); ?>