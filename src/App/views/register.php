<?php include $this->resolve("partials/_header.php"); ?>

  
  <!-- registerPage -->
  <main id="registerPage">


      <div class="py-3 col-12 col-md-8 col-lg-5 text-center container">

          <div class="px-5 pb-4 border-bottom-0 text-start">
          <p class="fw-bold mb-0 fs-2">Rejestracja w serwisie: </p>
           </div>

           <div class="p-5 pt-0">
           <form method="POST" action="/register">

            <?php include $this->resolve('partials/_csrf.php'); ?>
			
			<div class="form-floating mb-2">
              <!-- <input type="text" class="form-control rounded-3 <?= (array_key_exists('firstname', $errors)) ? 'border-danger':''?>" id="registerFloatingInput" placeholder="firstname" name="firstname" value="<?php echo e($oldFormData['firstname'] ?? ''); ?>">
              <label for="registerFloatingInput">Imię</label>
            </div> -->

      <!-- <php if(array_key_exists('firstname', $errors)) : ?>
        <div class="text-danger fw-bold bg-gray-100 mt-2 p-2 text-red-500">
          <php echo e($errors['firstname'][0]); ?>
        </div>
      <php endif;?> -->

          <input 
            type="text" 
            name="firstname" 
            value="<?= e($oldFormData['firstname'] ?? '') ?>" 
            id="registerFloatingInput"
            placeholder="firstname"
            name="firstname"
            class="form-control rounded-3 <?= isset($errors['firstname']) ? 'border-danger' : '' ?>"
          >
          <label for="registerFloatingInput">Imię</label>
          <?= formError($errors, 'firstname') ?>
          </div>


            <div class="form-floating mb-2">
              <input type="text" class="form-control rounded-3 <?= (array_key_exists('lastname', $errors)) ? 'border-danger':''?>" id="registerFloatingInput" placeholder="surename" name="lastname" value="<?php echo e($oldFormData['lastname'] ?? ''); ?>">
              <label for="registerFloatingInput">Nazwisko</label>
            </div>

                  <?php if(array_key_exists('lastname', $errors)) : ?>
        <div class="text-danger fw-bold bg-gray-100 mt-2 p-2 text-red-500">
          <?php echo e($errors['lastname'][0]); ?>
        </div>
      <?php endif;?>
			
            <div class="form-floating mb-2">
              <input type="email" class="form-control rounded-3 <?= (array_key_exists('email', $errors)) ? 'border-danger':''?>" id="registerFloatingInput" placeholder="uzytkownik@serwer.com" name="email" value="<?php echo e($oldFormData['email'] ?? ''); ?>">
              <label for="registerFloatingInput">Adres e-mail</label>
            </div>

      <?php if(array_key_exists('email', $errors)) : ?>
        <div class="text-danger fw-bold bg-gray-100 mt-2 p-2 text-red-500">
          <?php echo e($errors['email'][0]); ?>
        </div>
      <?php endif;?>


            <div class="form-floating mb-2">
              <input type="password" class="form-control rounded-3 <?= (array_key_exists('password', $errors)) ? 'border-danger':''?>" id="registerFloatingPass" placeholder="Password" name="password">
              <label for="registerFloatingPass">Hasło</label>
            </div>

      <?php if(array_key_exists('password', $errors)) : ?>
        <div class="text-danger fw-bold bg-gray-100 mt-2 p-2 text-red-500">
          <?php echo e($errors['password'][0]); ?>
        </div>
      <?php endif;?>

            <div class="form-floating mb-2">
              <input type="password" class="form-control rounded-3 <?= (array_key_exists('confirmPassword', $errors)) ? 'border-danger':''?>" id="floatingPasswordSecond" placeholder="Confirm password" name="confirmPassword">
              <label for="floatingPasswordSecond">Potwierdź hasło</label>
            </div>

      <?php if(array_key_exists('confirmPassword', $errors)) : ?>
        <div class="text-danger fw-bold bg-gray-100 mt-2 p-2 text-red-500">
          <?php echo e($errors['confirmPassword'][0]); ?>
        </div>
      <?php endif;?>

					
          <div class="d-grid gap-2 d-md-flex justify-content-md-center">
            <button class="w-100 btn btn-lg rounded-3 btn-primary my-0 mb-0" role="button" type="submit">Zarejestruj</button>
            <a href="./" class="w-100 btn btn-lg rounded-3 btn-outline-secondary my-0 mb-0" role="button">Anuluj</a>
    
          </div>

          <small class="text-body-secondary">Klikając "Zarejestruj", wyrażasz zgodę na warunki użytkowania oraz regulamin serwisu.</small>

          </form>
      </div>
 

  </main>


<?php include $this->resolve("partials/_footer.php"); ?>