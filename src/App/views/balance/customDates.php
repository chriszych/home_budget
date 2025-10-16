  
<?php include $this->resolve("partials/_header.php"); ?>

<!-- mainPageContent -->
<section id="mainPageContent">

<section class="py-3 col-12 col-md-8 col-lg-5 text-center container">
<!-- Subpage AddIncome -->

  <div class="text-start p-5 py-3 mb-2 border-bottom-0">
    <p class="fw-bold mb-0 fs-2">Podaj zakres dat: </p>
  </div>
        
  <div class="p-5 py-0">

    <form method="POST">
      <?php include $this->resolve("partials/_csrf.php"); ?>

      <div class="form-floating mb-3">
        <input 
          type="datetime-local" 
          id="registerFloatingLogin" 
          min="2000-01-01T00:00" 
          max="<?= $nextYear ?>" 
          placeholder="<?= $now ?>" 
          name="startDate" 
          class="form-control rounded-3 <?= isset($errors['startDate']) ? 'border-danger':''?>" 
          value="<?= e($oldFormData['startDate'] ?? $_SESSION['startDate'] ?? $now) ?>"
        >
        <label for="registerFloatingLogin">Data od:</label>
          <?= formError($errors, 'startDate') ?>
      </div>

            <div class="form-floating mb-3">
        <input 
          type="datetime-local" 
          id="registerFloatingLogin" 
          min="2000-01-01T00:00" 
          max="<?= $nextYear ?>" 
          placeholder="<?= $now ?>" 
          name="endDate" 
          class="form-control rounded-3 <?= isset($errors['endDate']) ? 'border-danger':''?>" 
          value="<?= e($oldFormData['endDate'] ?? $_SESSION['endDate'] ?? $now) ?>"
        >
        <label for="registerFloatingLogin">Data do:</label>
          <?= formError($errors, 'endDate') ?>
      </div>

            		  
      <div class="d-grid gap-2 d-md-flex justify-content-md-center">
        <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary my-1 mb-1 mb-md-5 mt-1 mt-md-3" type="submit">OK</button>
          <a href="/balanceAll/<?= $_SESSION['viewMode'] ?>" class="w-100 mb-2 btn btn-lg rounded-3 btn-outline-secondary my-1 mb-1 mb-md-5 mt-1 mt-md-3" role="button">Anuluj</a>
      </div>
    </form>
  </div>
 
</section>

<?php include $this->resolve("partials/_footer.php"); ?>