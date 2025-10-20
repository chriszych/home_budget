  
<?php include $this->resolve("partials/_header.php"); ?>

<!-- mainPageContent -->
<section id="mainPageContent">

<section class="py-3 col-12 col-md-8 col-lg-5 text-center container">
<!-- Subpage AddIncome -->

  <div class="text-start p-5 py-3 mb-2 border-bottom-0">
    <p class="fw-bold mb-0 fs-2">Add new income: </p>
  </div>
        
  <div class="p-5 py-0">

    <form method="POST" action="/addIncome">
      <?php include $this->resolve("partials/_csrf.php"); ?>

      <div class="form-floating mb-3">
        <input 
          type="number" 
          id="amount" 
          placeholder="kwota w PLN" 
          step="0.01" 
          min="0.01" 
          max="99999999.99" 
          name="amount" 
          class="form-control rounded-3 <?= isset($errors['amount']) ? 'border-danger' : ''?>" 
          value="<?= e($oldFormData['amount'] ?? '') ?>"
        >
        <label for="amount">Amount:</label>
          <?= formError($errors, 'amount') ?>
      </div>

      <div class="form-floating mb-3">
        <input 
          type="datetime-local" 
          id="date" 
          min="2000-01-01T00:00" 
          max="<?= $nextYear ?>" 
          placeholder="<?= $now ?>" 
          name="date" 
          class="form-control rounded-3 <?= isset($errors['date']) ? 'border-danger':''?>" 
          value="<?= e($oldFormData['date'] ?? $now) ?>"
        >
        <label for="date">Date:</label>
          <?= formError($errors, 'date') ?>
      </div>

      <div class="form-floating form-group mb-3">
        <select 
          id="incomeCategory" 
          name="category" 
          class="form-control rounded-3 <?= isset($errors['category']) ? 'border-danger':''?>"
        >
          <option disabled selected>Select a category...</option>
				
		        <?php foreach ($incomeCategories as $incomeCategory): ?> 
	            <option value="<?= $incomeCategory['id_inc_user_cat'] ?>" 
		            <?= (isset($oldFormData['category']) && $oldFormData['category'] == $incomeCategory['id_inc_user_cat']) ? 'selected' : '' ?>
              >
		            <?= $incomeCategory['inc_cat_name']; ?>
		          </option> 
		        <?php endforeach; ?>
				
        </select>
        <label for="incomeCategory">Category:</label>
          <?= formError($errors, 'category') ?>
      </div>

      <div class="form-floating mb-3">
	      <textarea 
          id="incomeComment" 
          name="comment" 
          rows="2" 
          cols="30" 
          placeholder="Add your comment" 
          class="form-control rounded-3 <?= isset($errors['comment']) ? 'border-danger':''?>"
        ><?= $oldFormData['comment'] ?? '' ?></textarea>
        <label for="incomeComment">Add your comment (optional):</label>
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