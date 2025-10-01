  
<?php include $this->resolve("partials/_header.php"); ?>

<!-- mainPageContent -->
<section id="mainPageContent">

<section class="py-3 col-12 col-md-8 col-lg-5 text-center container">


  <div class="text-start p-5 py-3 mb-2 border-bottom-0">
    <p class="fw-bold mb-0 fs-2">Edytuj wybraną kategorię: </p>
  </div>
        
  <div class="p-5 py-0">

    <form action="/addIncomeCategory" method="POST">
      <?php include $this->resolve("partials/_csrf.php"); ?>
    <input type="hidden" name="id_cat" value="<?= $_POST['id_cat']?>" />
      

      <div class="form-floating mb-3">

        <input 
          type="text" 
          id="registerFloatingInput" 
          placeholder="Dodaj nową kategorię przychodów:" 
          name="editIncomeCategory" 
          class="form-control rounded-3 <= isset($errors['editIncomeCategory']) ? 'border-danger' : ''?>" 
          value="<?= e($oldFormData['editIncomeCategory'] ?? $_POST['category']) ?>"
        >
        <label for="registerFloatingInput">Edytuj kategorię przychodów:</label>
          <?= formError($errors, 'editIncomeCategory') ?>
        
      </div>
  
     
            		  
      <div class="d-grid gap-2 d-md-flex justify-content-md-center">
        <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary my-1 mb-1 mb-md-5 mt-1 mt-md-3" type="submit">Zapisz</button>
          <a href="./listIncomeCategory" class="w-100 mb-2 btn btn-lg rounded-3 btn-outline-secondary my-1 mb-1 mb-md-5 mt-1 mt-md-3" role="button">Anuluj</a>
      </div>
    </form>
  </div>
 
</section>



<?php include $this->resolve("partials/_footer.php"); ?>