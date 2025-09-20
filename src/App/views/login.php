<?php include $this->resolve("partials/_header.php"); ?>

  
  <!-- loginPage -->
  <main id="loginPage">

      <div class="py-3 col-12 col-md-8 col-lg-5 text-center container">
        <div class="p-5 pb-4 border-bottom-0">
          <p class="error fw-bold mb-0 fs-2 text-start"><?= $welcomeText ?></p>
        </div>

        <div class="modal-body p-5 pt-0">
          <form method="POST" action="/login">
          <?php include $this->resolve('partials/_csrf.php'); ?>
            <div class="form-floating mb-3">
			  <input type="text" class="form-control rounded-3" id="emailFloatingName" placeholder="e-mail" name="email"  value="<?= e($oldFormData['email'] ?? ''); ?>">
              <label for="emailFloatingName">E-mail</label>

              <?php if(array_key_exists('email', $errors)) : ?>
                <div class="text-danger fw-bold bg-gray-100 mt-2 p-2 text-red-500">
                  <?= e($errors['email'][0]); ?>
                </div>
              <?php endif;?>


            </div>
            <div class="form-floating mb-3">
              <input type="password" class="form-control rounded-3" id="LoginFloatingPass" placeholder="Password" name="password">
              <label for="LoginFloatingPass">Hasło</label>
             
			  </div>

        <?php if(array_key_exists('password', $errors)) : ?>
            <div class="text-danger fw-bold bg-gray-100 mt-0 p-0 text-red-500">
                <?= e($errors['password'][0]); ?>
            </div>
        <?php endif;?>

          <div class="d-grid gap-2 d-md-flex justify-content-md-center">
            <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary my-1 mb-1 my-md-5 mb-md-5" role="button" type="submit">Zaloguj się</button>
            <a href="./" class="w-100 mb-2 btn btn-lg rounded-3 btn-outline-secondary my-1 mb-1 my-md-5 mb-md-5" role="button">Anuluj</a>
          </div>

          </form>
      </div>
 

  </main>

<?php include $this->resolve("partials/_footer.php"); ?>