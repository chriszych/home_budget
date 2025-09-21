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
          <input 
            type="email" 
            name="email" 
            value="<?= e($oldFormData['email'] ?? '') ?>" 
            id="emailFloatingName"
            placeholder="e-mail"
            class="form-control rounded-3 <?= isset($errors['email']) ? 'border-danger' : '' ?>"
          >
          <label for="emailFloatingName">E-mail</label>
          <?= formError($errors, 'email') ?>
        </div>

        <div class="form-floating mb-3">
          <input 
            type="password" 
            name="password" 
            value="<?= e($oldFormData['password'] ?? '') ?>" 
            id="LoginFloatingPass"
            placeholder="Password"
            class="form-control rounded-3 <?= isset($errors['password']) ? 'border-danger' : '' ?>"
          >
          <label for="LoginFloatingPass">Hasło</label>
          <?= formError($errors, 'password') ?>
        </div>

        <div class="d-grid gap-2 d-md-flex justify-content-md-center">
          <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary my-1 mb-1 my-md-5 mb-md-5" role="button" type="submit">Zaloguj się</button>
          <a href="./" class="w-100 mb-2 btn btn-lg rounded-3 btn-outline-secondary my-1 mb-1 my-md-5 mb-md-5" role="button">Anuluj</a>
        </div>

      </form>
    </div>
  </div>
</main>

<?php include $this->resolve("partials/_footer.php"); ?>