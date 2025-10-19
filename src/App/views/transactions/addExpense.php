
<?php include $this->resolve("partials/_header.php"); ?>

<!-- mainPageContent -->
<section id="mainPageContent">

<section class="py-3 col-12 col-md-8 col-lg-5 text-center container">
<!-- Subpage AddExpense -->

  <div class="text-start p-5 py-3 mb-2 border-bottom-0">
    <p class="fw-bold mb-0 fs-2">Add new expense: </p>
  </div>
        
  <div class="p-5 py-0">

    <form method="POST" action="/addExpense">
      <?php include $this->resolve("partials/_csrf.php"); ?>
 
      <div class="form-floating mb-3">
        <input 
          type="number" 
          id="registerFloatingInput" 
          placeholder="kwota w PLN" 
          step="0.01" 
          min="0.01" 
          max="99999999.99" 
          name="amount" 
          class="form-control rounded-3 <?= isset($errors['amount']) ? 'border-danger':''?>" 
          id="registerFloatingInput" 
          placeholder="amount" 
          name="amount" 
          value="<?= e($oldFormData['amount'] ?? '') ?>"
        >
        <label for="registerFloatingInput">Amount:</label>
        <?= formError($errors, 'amount') ?>
      </div>

      <div class="form-floating mb-3">
        <input 
          type="datetime-local" 
          id="registerFloatingLogin" 
          min="2000-01-01T00:00" 
          max="<?= $nextYear ?>" 
          placeholder="<?= $now ?>" 
          name="date" 
          class="form-control rounded-3 <?= isset($errors['date']) ? 'border-danger':''?>" 
          value="<?= e($oldFormData['date'] ?? $now) ?>"
        >
        <label for="registerFloatingLogin">Date:</label>
        <?= formError($errors, 'date') ?>
      </div>

      <div class="form-floating mb-3">    
        <select 
          id="expensePaymentMethod" 
          name="paymentMethod" 
          class="form-control rounded-3 <?= isset($errors['paymentMethod']) ? 'border-danger':''?>"
        >
          <option disabled selected>Select a payment method...</option>
				     
          <?php foreach ($paymentMethods as $paymentMethod): ?> 
				    <option value="<?= $paymentMethod['id_user_pay_met']; ?>" 
				    <?= (isset($oldFormData['paymentMethod']) && $oldFormData['paymentMethod'] == $paymentMethod['id_user_pay_met']) ? 'selected' : '' ?>>
				    <?= $paymentMethod['pay_met_name']; ?>
				    </option> 
				  <?php endforeach; ?>
				
        </select>
        <label for="expensePaymentMethod">Payment method:</label>
        <?= formError($errors, 'paymentMethod') ?>
      </div>

      <div class="form-floating form-group mb-3">
        <select 
          id="expenseCategory" 
          name="category" 
          class="form-control rounded-3 <?= isset($errors['category']) ? 'border-danger':''?>"
        >
          <option disabled selected>Select a category...</option>
				
				    <?php foreach ($expenseCategories as $expenseCategory): ?> 
				      <option value="<?= $expenseCategory['id_exp_user_cat']; ?>" 
				        <?= (isset($oldFormData['category']) && $oldFormData['category'] == $expenseCategory['id_exp_user_cat']) ? 'selected' : '' ?>>
				        <?= $expenseCategory['exp_cat_name']; ?>
				      </option> 
				    <?php endforeach; ?>
				
        </select>
        <label for="expenseCategory">Category:</label>
        <?= formError($errors, 'category') ?>
      </div>

      <div class="form-floating mb-3">
			  <textarea 
          id="expenseComment" 
          name="comment" 
          rows="2" 
          cols="30" 
          placeholder="dodaj komentarz (opcja)" 
          class="form-control rounded-3 <?= isset($errors['comment']) ? 'border-danger':''?>"
        ><?= $oldFormData['comment'] ?? '' ?></textarea>
        <label for="expenseComment">Add your comment:</label>
        <?= formError($errors, 'comment') ?>
      </div>
           		  
      <div class="d-grid gap-2 d-md-flex justify-content-md-center">
        <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary my-1 mb-1 mb-md-5 mt-1 mt-md-3" type="submit">Dodaj</button>
        <a href="./" class="w-100 mb-2 btn btn-lg rounded-3 btn-outline-secondary my-1 mb-1 mb-md-5 mt-1 mt-md-3" role="button">Anuluj</a>
      </div>
    </form>
  </div>
 
</section>
  
<?php include $this->resolve("partials/_footer.php"); ?>