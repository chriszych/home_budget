<?php include $this->resolve("partials/_header.php"); ?>

  
<main id="registerPage">

  <div class="py-3 col-12 col-md-8 col-lg-5 text-center container">

    <div class="px-5 pb-4 border-bottom-0 text-start">
      <p class="fw-bold mb-0 fs-2">Change User password: </p>
    </div>

    <div class="p-5 pt-0">
      <form method="POST">

        <?php include $this->resolve('partials/_csrf.php'); ?>

        <div class="form-floating mb-2">
          <input 
            type="password" 
            name="password" 
            value="<?= e($oldFormData['password'] ?? '') ?>" 
            id="registerFloatingPass"
            placeholder="Password"
            class="form-control rounded-3 <?= isset($errors['password']) ? 'border-danger' : '' ?>"
          >
          <label for="registerFloatingPass">New password</label>
          <?= formError($errors, 'password') ?>
        </div>

        <div class="form-floating mb-2">
          <input 
            type="password" 
            name="confirmPassword" 
            value="<?= e($oldFormData['confirmPassword'] ?? '') ?>" 
            id="floatingPasswordSecond"
            placeholder="Confirm password"
            class="form-control rounded-3 <?= isset($errors['confirmPassword']) ? 'border-danger' : '' ?>"
          >
          <label for="floatingPasswordSecond">Confirm new password</label>
          <?= formError($errors, 'confirmPassword') ?>
        </div>
				
        <div class="d-grid gap-2 d-md-flex justify-content-md-center">
          <button class="w-100 btn btn-lg rounded-3 btn-primary my-0 mb-0" role="button" type="submit">Save</button>
          <a href="./settings" class="w-100 btn btn-lg rounded-3 btn-outline-secondary my-0 mb-0" role="button">Cancel</a>
        </div>

      </form>
    </div>
  </div>
 

</main>

<?php include $this->resolve("partials/_footer.php"); ?>