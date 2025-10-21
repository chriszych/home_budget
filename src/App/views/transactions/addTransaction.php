<!-- <php $title = $type === 'income' ? 'income' : 'expense'; ?>
<div class="text-start p-5 py-3 mb-2 border-bottom-0">
  <p class="fw-bold mb-0 fs-2">Add new <= $title ?>: </p>
</div>
      
<div class="p-5 py-0">
  <form method="POST" action="/addTransaction/<= $title ?>"> 
    <php include $this->resolve("partials/_csrf.php"); ?>

    <php
      $categories = $type === 'income' ? $incomeCategories : $expenseCategories;
      $idKey = $type === 'income' ? 'id_inc_user_cat' : 'id_exp_user_cat';
      $nameKey = $type === 'income' ? 'inc_cat_name' : 'exp_cat_name';
    ?>
    <div class="form-floating mb-3">
      <select id="<= $type ?>Category" name="category" class="form-select rounded-3">
        <option selected>Choose category</option>
          
          <php foreach ($categories as $category): ?> 
            <option value="<= $category[$idKey]; ?>" 
              <= (isset($oldFormData['category']) && $oldFormData['category'] == $category[$idKey]) ? 'selected' : '' ?>>
              <= $category[$nameKey]; ?>
            </option> 
          <php endforeach; ?>
      </select>
      <label for="<= $type ?>Category">Category:</label>
      <= formError($errors, 'category') ?>
    </div>

    <php if ($type === 'expense'): ?>
      <div class="form-floating mb-3">
        <select id="paymentMethod" name="paymentMethod" class="form-select rounded-3">
          <option selected>Choose payment method</option>
            
            <php foreach ($paymentMethods as $method): ?> 
              <option value="<= $method['id_user_pay_met']; ?>" 
                <= (isset($oldFormData['paymentMethod']) && $oldFormData['paymentMethod'] == $method['id_user_pay_met']) ? 'selected' : '' ?>>
                <= $method['pay_met_name']; ?>
              </option> 
            <php endforeach; ?>
        </select>
        <label for="paymentMethod">Payment Method:</label>
        <= formError($errors, 'paymentMethod') ?>
      </div>
    <php endif; ?>

    </form>
</div> -->

<?php include $this->resolve("partials/_header.php"); ?>

<section id="mainPageContent">

<section class="py-3 col-12 col-md-8 col-lg-5 text-center container">
<?php $title = $type === 'income' ? 'income' : 'expense'; ?>
    <div class="text-start p-5 py-3 mb-2 border-bottom-0">
        <p class="fw-bold mb-0 fs-2">Add new <?= $title ?>: </p>
    </div>
        
    <div class="p-5 py-0">

        <form method="POST" action="/addTransaction/<?= $title ?>"> 
            <?php include $this->resolve("partials/_csrf.php"); ?>
    
            <div class="form-floating mb-3">
                <input 
                    type="number" 
                    id="amount" 
                    placeholder="amount in PLN" 
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
                    name="date" 
                    class="form-control rounded-3 <?= isset($errors['date']) ? 'border-danger' : ''?>" 
                    value="<?= e($oldFormData['date'] ?? $now) ?>" 
                    min="<?= $minDate ?>" 
                    max="<?= $maxDate ?>"
                >
                <label for="date">Date:</label>
                <?= formError($errors, 'date') ?>
            </div>

            <?php
                // Logika dla Kategorii - z fragmentu, który mi podałeś
                $categories = $type === 'income' ? $incomeCategories : $expenseCategories;
                $idKey = $type === 'income' ? 'id_inc_user_cat' : 'id_exp_user_cat';
                $nameKey = $type === 'income' ? 'inc_cat_name' : 'exp_cat_name';
            ?>
            <div class="form-floating mb-3">
                <select id="<?= $type ?>Category" name="category" class="form-select rounded-3">
                    <option value="" selected>Select a category...</option>
                    <?php foreach ($categories as $category): ?> 
                        <option value="<?= $category[$idKey]; ?>" 
                            <?= (isset($oldFormData['category']) && $oldFormData['category'] == $category[$idKey]) ? 'selected' : '' ?>>
                            <?= $category[$nameKey]; ?>
                        </option> 
                    <?php endforeach; ?>
                </select>
                <label for="<?= $type ?>Category">Category:</label>
                <?= formError($errors, 'category') ?>
            </div>

            <?php if ($type === 'expense'): ?>
                <div class="form-floating mb-3">
                    <select id="paymentMethod" name="paymentMethod" class="form-select rounded-3">
                        <option value="" selected>Select a payment method...</option>
                        <?php foreach ($paymentMethods as $method): ?> 
                            <option value="<?= $method['id_user_pay_met']; ?>" 
                                <?= (isset($oldFormData['paymentMethod']) && $oldFormData['paymentMethod'] == $method['id_user_pay_met']) ? 'selected' : '' ?>>
                                <?= $method['pay_met_name']; ?>
                            </option> 
                        <?php endforeach; ?>
                    </select>
                    <label for="paymentMethod">Payment Method:</label>
                    <?= formError($errors, 'paymentMethod') ?>
                </div>
            <?php endif; ?>
            
            <div class="form-floating mb-3">
                <textarea 
                    id="comment" 
                    name="comment" 
                    rows="2" 
                    cols="30" 
                    placeholder="Add your comment" 
                    class="form-control rounded-3 <?= isset($errors['comment']) ? 'border-danger':''?>"
                ><?= $oldFormData['comment'] ?? '' ?></textarea>
                <label for="comment">Add your comment (optional):</label>
                <?= formError($errors, 'comment') ?>
            </div>
               
            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary my-1 mb-1 mb-md-5 mt-1 mt-md-3" type="submit">Dodaj</button>
                <a href="../" class="w-100 mb-2 btn btn-lg rounded-3 btn-outline-secondary my-1 mb-1 mb-md-5 mt-1 mt-md-3" role="button">Cancel</a>
            </div>
            
        </form>
    </div>
</section>

<?php include $this->resolve("partials/_footer.php"); ?>