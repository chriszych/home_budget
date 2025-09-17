  
  <?php include $this->resolve("partials/_header.php"); ?>

  <!-- mainPageContent -->
  <section id="mainPageContent">

    <section class="py-3 col-12 col-md-8 col-lg-5 text-center container">
 <!-- Subpage AddIncome -->


        <div class="text-start p-5 py-3 mb-2 border-bottom-0">
          <p class="fw-bold mb-0 fs-2">Dodaj nowy przychód: </p>
        </div>
        
        <div class="p-5 py-0">

           <form method="POST" action="/addIncome">
          <?php include $this->resolve("partials/_csrf.php"); ?>
            <div class="form-floating mb-3">

              <input type="number" id="registerFloatingInput" placeholder="kwota w PLN" step="0.01" min="0.01" max="99999999.99" name="amount" class="form-control rounded-3 <?= (array_key_exists('amount', $errors)) ? 'border-danger':''?>" id="registerFloatingInput" placeholder="amount" name="amount" value="<?php echo e($oldFormData['amount'] ?? ''); ?>">
              <label for="registerFloatingInput">Kwota w PLN:</label>
            </div>

          <?php if(array_key_exists('amount', $errors)) : ?>
            <div class="text-danger border-danger fw-bold bg-gray-100 mt-0 p-0 text-red-500">
                <?= e($errors['amount'][0]); ?>
            </div>
          <?php endif;?>

            <div class="form-floating mb-3">
              <input type="datetime-local" id="registerFloatingLogin" min="2000-01-01T00:00" max="<?php echo $nextYear;?>" placeholder="<?php echo $now; ?>" name="date" class="form-control rounded-3 <?= (array_key_exists('date', $errors)) ? 'border-danger':''?>" value="<?php echo e($oldFormData['date'] ?? $now); ?>">
              <label for="registerFloatingLogin">Data:</label>
            </div>

          <?php if(array_key_exists('date', $errors)) : ?>
            <div class="text-danger border-danger fw-bold bg-gray-100 mt-0 p-0 text-red-500">
              <?= e($errors['date'][0]); ?>
            </div>
          <?php endif;?>

            <div class="form-floating form-group mb-3">
              <select id="incomeCategory" name="category" class="form-control rounded-3 <?= (array_key_exists('category', $errors)) ? 'border-danger':''?>">
                <option disabled selected>Wybierz kategorię...</option>
				
				<?php foreach ($incomeCategories as $incomeCategory): ?> 
				<option value="<?= $incomeCategory['id_inc_user_cat']; ?>" 
				<?= (isset($oldFormData['category']) && $oldFormData['category'] == $incomeCategory['id_inc_user_cat']) ? 'selected' : '' ?>>
				<?= $incomeCategory['inc_cat_name']; ?>
				 </option> 
				<?php endforeach; ?>
				
              </select>
              <label for="incomeCategory">Kategoria:</label>
            </div>

            <?php if(array_key_exists('category', $errors)) : ?>
            <div class="text-danger border-danger fw-bold bg-gray-100 mt-0 p-0 text-red-500">
              <?= e($errors['category'][0]); ?>
            </div>
          <?php endif;?>

            <div class="form-floating mb-3">
			        <textarea id="incomeComment" name="comment" rows="2" cols="30" placeholder="dodaj komentarz (opcja)" class="form-control rounded-3 <?= (array_key_exists('comment', $errors)) ? 'border-danger':''?>"><?= isset($oldFormData['comment']) ? $oldFormData['comment'] : '' ?></textarea>
              <label for="incomeComment">Komentarz:</label>
            </div>

            <?php if(array_key_exists('comment', $errors)) : ?>
            <div class="text-danger border-danger fw-bold bg-gray-100 mt-0 p-0 text-red-500">
              <?= e($errors['comment'][0]); ?>
            </div>
          <?php endif;?>
            		  
            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
            <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary my-1 mb-1 mb-md-5 mt-1 mt-md-3" type="submit">Dodaj</button>
            <a href="./" class="w-100 mb-2 btn btn-lg rounded-3 btn-outline-secondary my-1 mb-1 mb-md-5 mt-1 mt-md-3" role="button">Anuluj</a>
          </form>
        </div>
 
  </section>
  
  <?php include $this->resolve("partials/_footer.php"); ?>