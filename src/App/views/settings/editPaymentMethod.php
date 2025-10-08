  
<?php include $this->resolve("partials/_header.php"); ?>

<!-- mainPageContent -->
<section id="mainPageContent">

<section class="py-3 col-12 col-md-8 col-lg-5 text-center container">


  <div class="text-start p-5 py-3 mb-2 border-bottom-0">
    <p class="fw-bold mb-0 fs-2">Edytuj metodę płatności: </p>
  </div>
        
  <div class="p-5 py-0">


    <form method="POST">
      <?php include $this->resolve("partials/_csrf.php"); ?>
    <input type="hidden" name="id_cat" value="<?= $id_cat ?>" />
      

      <div class="form-floating mb-3">

        <input 
          type="text" 
          id="registerFloatingInput" 
          placeholder="Dodaj nową metodę płatności:" 
          name="paymentMethod" 
          class="form-control rounded-3 <?= isset($errors['paymentMethod']) ? 'border-danger' : ''?>" 
          value="<?= e($oldFormData['paymentMethod'] ?? $category) ?>"
        >
        <label for="registerFloatingInput">Edytuj metodę płatności:</label>
          <?= formError($errors, 'paymentMethod') ?>
        
      </div>
  
     
            		  
      <div class="d-grid gap-2 d-md-flex justify-content-md-center">
        <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary my-1 mb-1 mb-md-5 mt-1 mt-md-3" type="submit">Zapisz</button>
          <a href="../listPaymentMethod" class="w-100 mb-2 btn btn-lg rounded-3 btn-outline-secondary my-1 mb-1 mb-md-5 mt-1 mt-md-3" role="button">Anuluj</a>
      </div>
    </form>
  </div>
 
</section>



<?php include $this->resolve("partials/_footer.php"); ?>