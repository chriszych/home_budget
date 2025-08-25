
<?php
		$now = date('Y-m-d\TH:i');
		$nextYear = date('Y-m-d\TH:i', strtotime('+1 year'));
?>

  <?php include $this->resolve("partials/_header.php"); ?>

  <!-- mainPageContent -->
  <section id="mainPageContent">

    <section class="py-3 col-12 col-md-8 col-lg-5 text-center container">
 <!-- Subpage AddExpense -->


        <div class="text-start p-5 py-3 mb-2 border-bottom-0">
          <p class="fw-bold mb-0 fs-2">Dodaj nowy wydatek: </p>
        </div>
        
        <div class="p-5 py-0">

           <form method="POST" action="/addExpense">
          <?php include $this->resolve("partials/_csrf.php"); ?>
            <div class="form-floating mb-3">

              <input type="number" id="registerFloatingInput" placeholder="kwota w PLN" step="0.01" min="0.01" max="99999999.99" name="amount" class="form-control rounded-3 <?= (array_key_exists('amount', $errors)) ? 'border-danger':''?>" id="registerFloatingInput" placeholder="amount" name="amount" value="<?php echo e($oldFormData['amount'] ?? ''); ?>">
              <label for="registerFloatingInput">Kwota w PLN:</label>
            </div>

          <?php if(array_key_exists('amount', $errors)) : ?>
            <div class="text-danger border-danger fw-bold bg-gray-100 mt-0 p-0 text-red-500">
                <?php echo e($errors['amount'][0]); ?>
            </div>
          <?php endif;?>

            <div class="form-floating mb-3">
              <input type="datetime-local" id="registerFloatingLogin" min="2000-01-01T00:00" max="<?php echo $nextYear;?>" placeholder="<?php echo $now; ?>" name="date" class="form-control rounded-3 <?= (array_key_exists('date', $errors)) ? 'border-danger':''?>" value="<?php echo e($oldFormData['date'] ?? $now); ?>">
              <label for="registerFloatingLogin">Data:</label>
            </div>

          <?php if(array_key_exists('date', $errors)) : ?>
            <div class="text-danger border-danger fw-bold bg-gray-100 mt-0 p-0 text-red-500">
              <?php echo e($errors['date'][0]); ?>
            </div>
          <?php endif;?>

            <div class="form-floating mb-3">    
              <select id="expensePaymentMethod" name="paymentMethod" class="form-control rounded-3 <?= (array_key_exists('paymentMethod', $errors)) ? 'border-danger':''?>">
                <option disabled selected>Wybierz sposób płatności...</option>
				     
        <?php foreach ($paymentsMethods as $paymentsMethod): ?> 
				<option value="<?php echo $paymentsMethod['id_user_pay_met']; ?>" 
				<?= (isset($oldFormData['paymentMethod']) && $oldFormData['paymentMethod'] == $paymentsMethod['id_user_pay_met']) ? 'selected' : '' ?>>
				<?php echo $paymentsMethod['pay_met_name']; ?>
				 </option> 
				<?php endforeach; ?>
				
              </select>
              <label for="expensePaymentMethod">Sposób płatności:</label>
            </div>

            <?php if(array_key_exists('paymentMethod', $errors)) : ?>
            <div class="text-danger border-danger fw-bold bg-gray-100 mt-0 p-0 text-red-500">
              <?php echo e($errors['paymentMethod'][0]); ?>
            </div>
          <?php endif;?>

            <div class="form-floating form-group mb-3">
              <select id="expenseCategory" name="category" class="form-control rounded-3 <?= (array_key_exists('category', $errors)) ? 'border-danger':''?>">
                <option disabled selected>Wybierz kategorię...</option>
				
				<?php foreach ($expenseCategories as $expenseCategory): ?> 
				<option value="<?php echo $expenseCategory['id_exp_user_cat']; ?>" 
				<?= (isset($oldFormData['category']) && $oldFormData['category'] == $expenseCategory['id_exp_user_cat']) ? 'selected' : '' ?>>
				<?php echo $expenseCategory['exp_cat_name']; ?>
				 </option> 
				<?php endforeach; ?>
				
              </select>
              <label for="expenseCategory">Kategoria:</label>
            </div>

            <?php if(array_key_exists('category', $errors)) : ?>
            <div class="text-danger border-danger fw-bold bg-gray-100 mt-0 p-0 text-red-500">
              <?php echo e($errors['category'][0]); ?>
            </div>
          <?php endif;?>

            <div class="form-floating mb-3">
			  <textarea id="expenseComment" name="comment" rows="2" cols="30" placeholder="dodaj komentarz (opcja)" class="form-control rounded-3 <?= (array_key_exists('comment', $errors)) ? 'border-danger':''?>"><?= isset($oldFormData['comment']) ? $oldFormData['comment'] : '' ?></textarea>
              <label for="expenseComment">Komentarz:</label>
            </div>

            <?php if(array_key_exists('comment', $errors)) : ?>
            <div class="text-danger border-danger fw-bold bg-gray-100 mt-0 p-0 text-red-500">
              <?php echo e($errors['comment'][0]); ?>
            </div>
          <?php endif;?>
            		  
            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
            <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary my-1 mb-1 mb-md-5 mt-1 mt-md-3" type="submit">Dodaj</button>
            <a href="./" class="w-100 mb-2 btn btn-lg rounded-3 btn-outline-secondary my-1 mb-1 mb-md-5 mt-1 mt-md-3" role="button">Anuluj</a>
          </form>
        </div>
 
  </section>
  
  <?php include $this->resolve("partials/_footer.php"); ?>