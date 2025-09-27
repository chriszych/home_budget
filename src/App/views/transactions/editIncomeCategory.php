  
<?php include $this->resolve("partials/_header.php"); ?>

<!-- mainPageContent -->
<section id="mainPageContent">

<section class="py-3 col-12 col-md-8 col-lg-5 text-center container">
<!-- Subpage AddIncome -->

  <div class="text-start p-5 py-3 mb-2 border-bottom-0">
    <p class="fw-bold mb-0 fs-2">Edytuj kategorie przychodów: </p>
  </div>
        
  <div class="p-5 py-0 fs-5">

    <form method="POST" action="/addIncomeCategory">
      <?php include $this->resolve("partials/_csrf.php"); ?>

                     <div class="container tableExpenses table-responsive">
                  
				  <!-- <h3>Przychody według kategorii</h3>
				  <p>W okresie od <span class="fw-bold"><= $firstCurrentMonthDay ?></span> do <span class="fw-bold"><= $lastCurrentMonthDay ?></span></p> -->
				  
				    <table class="table table-hover">
                    <thead>
                     <tr>
                        <th class="text-center px-1">Nr.</th>
						<th class="px-1">Kategoria</th>
                       <th class="text-center pe-1">Akcja</th>
                       
                      </tr>
                    </thead>
					
					<tbody>
					<?php foreach ($incomeCategories as $i => $row): ?>
					<tr>
                    <td class="text-center px-1 fw-bold"><?= str_pad($i+1, 1, "0", STR_PAD_LEFT); ?>. </td>
					          
                    <td class="px-1"><?= $row['inc_cat_name'] ?></td>
                    <!-- <td class="px-1">
                    
                          <div class="form-floating mb-3">
                          <div class="form-comtrol mb-1">
                            
                            <input 
                              type="text" 
                              id="registerFloatingInput" 
                              name="incomeCategory" 
                              class="form-control rounded-3" 
                              value="<= $row['inc_cat_name'] ?>"
                            >
                            <label for="registerFloatingInput">Income Category:</label> -->
                              <!-- <= formError($errors, 'amount') ?>
                            </div>  
                    </td> -->
                    
                    <td class="text-end">
                      <!-- <= $row['id_inc_user_cat'] ?> -->

                              <a href="#"><i class="fa-regular fa-pen-to-square fa-xl" style="color: #2861c3;"></i></a>
                              <a href="#"><i class="fa-regular fa-trash-can fa-xl" style="color: #2861c3;"></i></a>
                          </td>
					</tr>
					<?php endforeach; ?>
					</tbody>
					
                    <tfoot>
                      <tr>
                        <th></th>
                        <th class="text-center">Ilość Twoich kategorii: </th>
						 <th class="text-start text-nowrap"><?= $incomeCategoryCount ?></th>
            <!-- <th class="text-center"> kategorii przychodów </th> -->
                        <th></th>
                        <th></th>
                      </tr>
                    </tfoot>
                  </table>

                </div>
              </div>
            </div>
          </div>

        
        <div class="d-grid gap-1 d-md-flex justify-content-md-center">
          <!-- <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary my-1 mb-1 my-md-5 mb-md-5" role="button" type="submit">Zaloguj się</button> -->
          <a href="./" class="w-100 mb-1 btn btn-lg rounded-3 btn-primary my-1 mb-1 my-md-3 mb-md-3" role="button">Dodaj nową kategorię</a>
        </div>

         <!--  <div class="col">
            <div class="card shadow-sm">
              <div class="card-body">
                <div class="container tableIncomes table-responsive">
                  <h3>Wydatki według kategorii</h3>
                  <p>W okresie od <span class="fw-bold"><= $firstCurrentMonthDay ?></span> do <span class="fw-bold"><?= $lastCurrentMonthDay ?></span></p>

					<table class="table table-hover">
                    <thead>
                      <tr>
                        <th class="text-center px-1">Nr.</th>
						<th class="px-1">Kategoria</th>
                        <th class="text-center pe-1">Kwota</th>
                      </tr>
                    </thead>
					
					<tbody>
					<php foreach ($resultExp as $i => $row): ?>
					<tr>
                    <td class="text-center px-1 fw-bold"><= str_pad($i+1, 1, "0", STR_PAD_LEFT); ?>. </td>
					<td class="px-1"><= $row['exp_cat_name'] ?></td>
                    <td class="text-end pe-1 fw-bold"><= number_format($row['total_amount'], 2, ',', '') ?></td>
					</tr>
					<php endforeach; ?>
					</tbody>
					
                    <tfoot>
                      <tr>
                       <th></th>
                       <th class="text-center">Suma: </th>
					   <th class="text-end pe-1 text-nowrap"><= number_format($expSum, 2, ',','') ?></th>
                       <th></th>
                       <th></th>
                      </tr>
                    </tfoot>
                  </table> -->

                </div>
    </form>
  </div>
 
</section>

<?php include $this->resolve("partials/_footer.php"); ?>