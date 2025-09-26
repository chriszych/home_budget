  
<?php include $this->resolve("partials/_header.php"); ?>

<!-- mainPageContent -->
<section id="mainPageContent">

<section class="py-3 col-12 col-md-8 col-lg-5 text-center container">
<!-- Subpage AddIncome -->

  <div class="text-start p-5 py-3 mb-2 border-bottom-0">
    <p class="fw-bold mb-0 fs-2">Edytuj kategorie przychodów: </p>
  </div>
        
  <div class="p-5 py-0">

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
                    <td class="text-end pe-1 fw-bold"><?= $row['id_inc_user_cat'] ?></td>
					</tr>
					<?php endforeach; ?>
					</tbody>
					
                    <tfoot>
                      <tr>
                        <th></th>
                        <th class="text-center">Ilość Twoich kategorii: </th>
						 <th class="text-end pe-1 text-nowrap"><?= $incomeCategoryCount ?></th>
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