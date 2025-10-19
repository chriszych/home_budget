<?php include $this->resolve("partials/_header.php"); ?>

  
<!-- userEditPage -->
<main id="registerPage">

  <div class="py-3 col-12 col-md-8 col-lg-5 text-center container">

    <div class="px-5 pb-4 border-bottom-0 text-start">
      <p class="fw-bold mb-0 fs-2">Edit User Details: </p>
    </div>

    <div class="p-5 pt-0">
      <form method="POST">

        <?php include $this->resolve('partials/_csrf.php'); ?>
			
			  <div class="form-floating mb-2">
          <input 
            type="text" 
            name="firstname" 
            value="<?= e($oldFormData['firstname'] ?? $firstname) ?>" 
            id="registerFloatingInput"
            placeholder="firstname"
            class="form-control rounded-3 <?= isset($errors['firstname']) ? 'border-danger' : '' ?>"
          >
          <label for="registerFloatingInput">Firstname</label>
          <?= formError($errors, 'firstname') ?>
        </div>

        <div class="form-floating mb-2">
          <input 
            type="text" 
            name="lastname" 
            value="<?= e($oldFormData['lastname'] ?? $lastname) ?>" 
            id="registerFloatingInput"
            placeholder="lastname"
            class="form-control rounded-3 <?= isset($errors['lastname']) ? 'border-danger' : '' ?>"
          >
          <label for="registerFloatingInput">Lastname</label>
          <?= formError($errors, 'lastname') ?>
        </div>

        <div class="form-floating mb-2">
          <input 
            type="email" 
            name="email" 
            value="<?= e($oldFormData['email'] ?? $email) ?>" 
            id="registerFloatingInput"
            placeholder="uzytkownik@serwer.com"
            class="form-control rounded-3 <?= isset($errors['email']) ? 'border-danger' : '' ?>"
          >
          <label for="registerFloatingInput">e-mail</label>
          <?= formError($errors, 'email') ?>
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