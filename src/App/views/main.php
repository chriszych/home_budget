
<?php include $this->resolve("partials/_header.php"); ?>
  
<!-- mainPageContent -->
<main>
  <section id="mainPageContent">
    <div class="container col-12 col-xxl-8 px-4 py-5">
      <div class="row flex-lg-row-reverse align-items-center g-5 py-5">
        
        <div class="col-10 col-sm-8 col-lg-6">
          <img src="./pics/01main.jpg" class="d-block mx-lg-auto img-fluid" alt="desk ready for work" width="450" height="300" loading="lazy">
        </div>
        
        <div class="col-10 col-sm-8 col-lg-4">
          <p class="display-6 text-body-emphasis lh-1 mb-0 text-left">Welcome <?= $firstname ?>!</p>
            
          <div class="col-12 col-sm-10 col-lg-10">
			      <p class="lead text-left pt-4">You've been with us since: <br><span class="fw-bold"><?= $loggedRegDate ?></span><br><?= $welcomeText ?></p>
            <p class="lead text-left pt-4">Current Month's Finances::</p>
            <div class="row">
              <div class="col-1">
                <p class="lead text-start p-0">Income: </p>
              </div>
              <div class="col">
				        <p class="lead fw-bold text-end"><?= number_format($incSum ?? 0, 2, ',','') ?></p>
              </div>
            </div>
              
            <div class="row">
              <div class="col-1">
                <p class="lead text-start p-0">Expenses: </p>
              </div>
              <div class="col">
					      <p class="lead fw-bold text-end"><?= number_format($expSum ?? 0, 2, ',','') ?></p>
              </div>
            </div>

            <div class="row">
              <div class="col-1">
                <p class="lead fw-bold <?= $messageColor ?>">Balance: </p>
              </div>
              <div class="col">
					      <p class="lead fw-bold <?= $messageColor ?> text-end"><?= number_format($balance, 2, ',','') ?></p>
              </div>
            </div>
                
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<?php include $this->resolve("partials/_footer.php"); ?>