<?php include $this->resolve("partials/_header.php"); ?>

<section id="mainPageContent">

<section class="py-3 col-12 col-md-8 col-lg-5 text-center container">
  <div class="text-start p-5 py-3 mb-2 border-bottom-0">
    <p class="fw-bold mb-0 fs-2"><?= $title ?>: </p>
  </div>
        
  <div class="p-5 py-0">

    <form method="POST" action="<?= $formAction ?>">
      <?php include $this->resolve("partials/_csrf.php"); ?>
      
      <?php if (isset($categoryId)): ?>
        <input type="hidden" name="id_cat" value="<?= $categoryId ?>" />
      <?php endif; ?>

      <div class="form-floating mb-3">
        <input 
          type="text" 
          id="registerFloatingInput" 
          placeholder="<?= $label ?>" 
          name="<?= $fieldName ?>" 
          class="form-control rounded-3 <?= isset($errors[$fieldName]) ? 'border-danger' : ''?>" 
          value="<?= e($oldFormData[$fieldName] ?? $categoryValue ?? '') ?>"
        >
        <label for="registerFloatingInput"><?= $label ?></label>
        <?= formError($errors, $fieldName) ?>
      </div>

      <div class="d-grid gap-2 d-md-flex justify-content-md-center">
        <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary my-0 mb-0" role="button" type="submit">Save</button>
        <?php 
          $listPath = 'list' . ucfirst($fieldName);
        ?>
        <a href="../<?= $listPath ?>" class="w-100 mb-2 btn btn-lg rounded-3 btn-outline-secondary my-0 mb-0" role="button">Cancel</a>
      </div>
    </form>
  </div>
</section>
</section>

<?php include $this->resolve("partials/_footer.php"); ?>