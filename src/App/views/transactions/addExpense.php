
<?php
/*
	session_start();
	if(!isset($_SESSION['logged_id'])){
		header('Location: login.php');
	} else {
		
		if(!isset($_SESSION['initial_state'])){
			$initial_state = 0;
		} else {
			$initial_state = $_SESSION['initial_state'];
		}
		
		if(!isset($_SESSION['wrong_amount'])){
			$wrong_amount = 0;
		} else {
			$wrong_amount = $_SESSION['wrong_amount'];
		}
		if(!isset($_SESSION['wrong_date'])){
			$wrong_date = 0;
		} else {
			$wrong_date = $_SESSION['wrong_date'];
		}
		if(!isset($_SESSION['wrong_category'])){
			$wrong_category = 0;
		} else {
			$wrong_category = $_SESSION['wrong_category'];
		}
		if(!isset($_SESSION['wrong_payment'])){
			$wrong_payment = 0;
		} else {
			$wrong_payment = $_SESSION['wrong_payment'];
		}
		*/
		$now = date('Y-m-d\TH:i');
		$nextYear = date('Y-m-d\TH:i', strtotime('+1 year'));
		/*
		require_once 'database.php';
		
		$payQuery = $db->prepare("SELECT id_user_pay_met, pay_met_name FROM payment_user_method WHERE id_user = :user");
		$payQuery->bindValue(':user', $_SESSION['logged_id'], PDO::PARAM_STR);
		$payQuery->execute();
		$userPay = $payQuery->fetchAll(PDO::FETCH_ASSOC);
		
		$expQuery = $db->prepare("SELECT id_exp_user_cat, exp_cat_name FROM expense_user_category WHERE id_user = :user");
		$expQuery->bindValue(':user', $_SESSION['logged_id'], PDO::PARAM_STR);
		$expQuery->execute();
		$expCat = $expQuery->fetchAll(PDO::FETCH_ASSOC);

	}*/
?>

<!--
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="./style.css">
  <link rel="stylesheet" href="./bilans.css">
  <script src="https://kit.fontawesome.com/f7c473a27a.js" crossorigin="anonymous"></script>
  <title>Budżet domowy online</title>
</head>

<body>

 


    <nav id="navBar">
    -->
    <!-- navBar -->
<!--
      <div class="navbar navbar-expand-lg bg-body-tertiary rounded">
        <div class="container-fluid">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#buttonNavbar" aria-controls="buttonNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
  
          <div class="collapse navbar-collapse d-lg-flex" id="buttonNavbar">
            <a href="./main.php"><i class="fa-solid fa-house-chimney" style="color: #2861c3;"></i></a>
            <h1><a class="navbar-brand col-lg-3 me-0" href="./main.php">&nbsp;Budżet online</a></h1>
            <ul class="navbar-nav col-lg-9 justify-content-lg-end">

              <li class="nav-item">
                <a class="btn btn-lg btn-outline-primary m-1 disabled" href="./addExpense.php">Nowy wydatek</a>
              </li>

              <li class="nav-item">
                <a class="btn btn-lg btn-outline-primary m-1" href="./addIncome.php">Nowy przychód</a>
              </li>

              <li class="nav-item">
                <a class="btn btn-lg btn-outline-primary m-1" href="./bilans.php">Aktualny bilans</a>
              </li>              

              <li class="nav-item">
                <a class="btn btn-lg btn-outline-primary m-1" href="#">Ustawienia</a>
              </li>

              <li class="nav-item">
                <a class="btn btn-lg btn-outline-primary m-1" href="./logout.php">Wyloguj</a>
              </li>
            </ul>
          </div>
        </div>
      </div>

    </nav>

  -->
  <?php include $this->resolve("partials/_header.php"); ?>

  <!-- mainPageContent -->
  <section id="mainPageContent">
   <? 

  //dd($paymentsMethods);

   //foreach ($paymentsMethods as $paymentsMethod):
   //echo ($paymentsMethod['pay_met_name']);
   //endforeach; 
   ?>

    <section class="py-3 col-12 col-md-8 col-lg-5 text-center container">
 <!-- Subpage AddExpense -->


        <div class="text-start p-5 py-3 mb-2 border-bottom-0">
          <p class="fw-bold mb-0 fs-2">Dodaj nowy wydatek: </p>
        </div>
        
        <div class="p-5 py-0">
          <!--<form method="POST" action="insertNewExpense.php">-->
           <form method="POST" action="/addExpense">
          <?php include $this->resolve("partials/_csrf.php"); ?>
            <div class="form-floating mb-3">
              <!--<input type="text" class="form-control rounded-3 <= (array_key_exists('lastname', $errors)) ? 'border-danger':''?>" id="registerFloatingInput" placeholder="surename" name="lastname" value="<?php echo e($oldFormData['lastname'] ?? ''); ?>">-->
              <input type="number" id="registerFloatingInput" placeholder="kwota w PLN" step="0.01" min="0.01" max="99999999.99" name="amount" class="form-control rounded-3 <?= (array_key_exists('amount', $errors)) ? 'border-danger':''?>" id="registerFloatingInput" placeholder="amount" name="amount" value="<?php echo e($oldFormData['amount'] ?? ''); ?>">
              <label for="registerFloatingInput">Kwota w PLN:</label>
            </div>

          <?php if(array_key_exists('amount', $errors)) : ?>
            <div class="text-danger border-danger fw-bold bg-gray-100 mt-0 p-0 text-red-500">
                <?php echo e($errors['amount'][0]); ?>
            </div>
          <?php endif;?>

            <div class="form-floating mb-3">
              <input type="datetime-local" id="registerFloatingLogin" min="2000-01-01T00:00" max="<?php echo $nextYear;?>" placeholder="<?php echo $now; ?>" name="date" class="form-control rounded-3 <?= (array_key_exists('date', $errors)) ? 'border-danger':''?>" value="<?php echo e($oldFormData['date'] ?? $now); ?>">
              <label for="registerFloatingLogin">Data:</label>
            </div>

          <?php if(array_key_exists('date', $errors)) : ?>
            <div class="text-danger border-danger fw-bold bg-gray-100 mt-0 p-0 text-red-500">
              <?php echo e($errors['date'][0]); ?>
            </div>
          <?php endif;?>

            <div class="form-floating mb-3">    
              <select id="expensePaymentMethod" name="paymentMethod" class="form-control rounded-3 <?= (array_key_exists('paymentMethod', $errors)) ? 'border-danger':''?>">
                <option disabled selected>Wybierz sposób płatności...</option>
				
				<!--<hp foreach ($userPay as $row): ?> -->
				<!--<option value="<php echo $row['id_user_pay_met']; ?>" 
				<= (isset($_SESSION['form_payment']) && $_SESSION['form_payment'] == $row['id_user_pay_met']) ? 'selected' : '' ?>>
				<php echo $row['pay_met_name']; ?>
				 </option> 
				<php endforeach; ?>
        -->
      
        <?php foreach ($paymentsMethods as $paymentsMethod): ?> 
				<option value="<?php echo $paymentsMethod['id_user_pay_met']; ?>" 
				<?= (isset($oldFormData['paymentMethod']) && $oldFormData['paymentMethod'] == $paymentsMethod['id_user_pay_met']) ? 'selected' : '' ?>>
				<?php echo $paymentsMethod['pay_met_name']; ?>
				 </option> 
				<?php endforeach; ?>
				
              </select>
              <label for="expensePaymentMethod">Sposób płatności:</label>
            </div>

            <?php if(array_key_exists('paymentMethod', $errors)) : ?>
            <div class="text-danger border-danger fw-bold bg-gray-100 mt-0 p-0 text-red-500">
              <?php echo e($errors['paymentMethod'][0]); ?>
            </div>
          <?php endif;?>

            <div class="form-floating form-group mb-3">
              <select id="expenseCategory" name="category" class="form-control rounded-3 <?= (array_key_exists('category', $errors)) ? 'border-danger':''?>">
                <option disabled selected>Wybierz kategorię...</option>
				
				<?php foreach ($expenseCategories as $expenseCategory): ?> 
				<option value="<?php echo $expenseCategory['id_exp_user_cat']; ?>" 
				<?= (isset($oldFormData['category']) && $oldFormData['category'] == $expenseCategory['id_exp_user_cat']) ? 'selected' : '' ?>>
				<?php echo $expenseCategory['exp_cat_name']; ?>
				 </option> 
				<?php endforeach; ?>
				
              </select>
              <label for="expenseCategory">Kategoria:</label>
            </div>

            <?php if(array_key_exists('category', $errors)) : ?>
            <div class="text-danger border-danger fw-bold bg-gray-100 mt-0 p-0 text-red-500">
              <?php echo e($errors['category'][0]); ?>
            </div>
          <?php endif;?>

            <div class="form-floating mb-3">
			  <textarea id="expenseComment" name="comment" rows="2" cols="30" placeholder="dodaj komentarz (opcja)" class="form-control rounded-3 <?= (array_key_exists('comment', $errors)) ? 'border-danger':''?>"><?= isset($oldFormData['comment']) ? $oldFormData['comment'] : '' ?></textarea>
              <label for="expenseComment">Komentarz:</label>
            </div>

            <?php if(array_key_exists('comment', $errors)) : ?>
            <div class="text-danger border-danger fw-bold bg-gray-100 mt-0 p-0 text-red-500">
              <?php echo e($errors['comment'][0]); ?>
            </div>
          <?php endif;?>
            
			  <!--
			  	<p class="text-danger fw-bold">
      
			 <//?php 
				if (isset($_SESSION['error'])){
					echo $_SESSION['error'];
					unset($_SESSION['error']);
				}
				 unset($_SESSION['form_amount']);
				 unset($_SESSION['form_datetime']);
				 unset($_SESSION['form_payment']);
				 unset($_SESSION['form_category']);
				 unset($_SESSION['form_comment']);
				 unset($_SESSION['initial_state']);
				 				 
				 unset($_SESSION['wrong_amount']);
				 unset($_SESSION['wrong_date']);
				 unset($_SESSION['wrong_category']);
				 unset($_SESSION['wrong_payment']);
				?>
        
				</p>
            -->
			  
            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
            <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary my-1 mb-1 mb-md-5 mt-1 mt-md-3" type="submit">Dodaj</button>
            <a href="./" class="w-100 mb-2 btn btn-lg rounded-3 btn-outline-secondary my-1 mb-1 mb-md-5 mt-1 mt-md-3" role="button">Anuluj</a>
          </form>
        </div>
 
  </section>
  
  <?php include $this->resolve("partials/_footer.php"); ?>

  <!-- Footer 
  <footer id="footer">
    <div class="footer container ">
      <div class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
        <div class="col-md-4 d-flex align-items-center">
          <span class="mb-3 mb-md-0 text-body-secondary">Budżet online &#169; 2024</span>
        </div>
        <ul class="socials nav col-md-4 justify-content-end list-unstyled d-flex ">
          <li class="ms-3"><a href="#" class="text-body-secondary"><i class="fa-brands fa-facebook"></i></a></li>
          <li class="ms-3"><a href="#" class="text-body-secondary"><i class="fa-brands fa-linkedin"></i></a></li>
          <li class="ms-3"><a href="#" class="text-body-secondary"><i class="fa-brands fa-github"></i></a></li>
        </ul>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>

</body>

</html>
-->