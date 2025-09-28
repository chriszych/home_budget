  
<?php include $this->resolve("partials/_header.php"); ?>

<!-- mainPageContent -->
<section id="mainPageContent">

<section class="py-1 col-12 col-md-10 col-lg-8 col-xl-6 col-xxl-5 text-center container">
<!-- Subpage AddIncome -->

  <div class="text-start p-0 p-md-2 py-0 mb-1 border-bottom-0">
    <p class="fw-bold mb-0 fs-2">Edytuj kategorie przychodów: </p>
  </div>
        
  <div class="p-0 p-md-5 py-0 fs-5">

    <!-- <form method="POST" action="/addIncomeCategory">
      <php include $this->resolve("partials/_csrf.php"); ?> -->

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

                    
                    <td class="text-end">
                      <!-- <= $row['id_inc_user_cat'] ?> 
                      style="color: #2861c3;-->
                            <div class="d-flex justify-content-evenly">
                              <div class="mx-2">
                                <a href="#" class="icon-hover"><i class="fa-regular fa-pen-to-square fa-xl"></i></a>
                              </div>
                              <div class="mx-2">
                                <a href="#" class="icon-trash-hover"><i class="fa-regular fa-trash-can fa-xl"></i></a>
                              </div>
                            </div>
                          </td>
					</tr>
					<?php endforeach; ?>
					</tbody>
					
                    <tfoot>
                      <tr>
                        <th></th>
                        <th class="text-center">Ilość Twoich kategorii: </th>
						 <th class="text-center"><?= $incomeCategoryCount ?></th>
            <!-- <th class="text-center"> kategorii przychodów </th> -->
        
      
                      </tr>
                    </tfoot>
                  </table>

                </div>
              </div>
            </div>
          </div>

        
        <!-- <div class="d-grid gap-2 d-md-flex d-flex mx-5 justify-content-center"> -->
          <!-- <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary my-1 mb-1 my-md-5 mb-md-5" role="button" type="submit">Zaloguj się</button> -->
          <!-- <a href="./" class="w-50 mb-1 btn btn-lg rounded-3 btn-primary mb-2 my-mb-md-3 text-center" role="button">Dodaj nową kategorię</a>
          <a href="./settings" class="w-50 mb-1 btn btn-lg rounded-3 btn-outline-secondary mb-2 mb-md-3 text-center" role="button">Anuluj</a>
        </div> -->

      <div class="d-grid gap-2 d-md-flex justify-content-center">
        <a href="./addNewIncomeCategory" class="w-100 w-md-75 mb-2 btn btn-lg rounded-3 btn-primary my-2 mb-md-3" role="button">Dodaj nową kategorię</a>
        <a href="./settings" class="w-100 w-md-75 mb-2 btn btn-lg rounded-3 btn-outline-secondary my-2 mb-md-3" role="button">   Anuluj   </a>
      </div>


                </div>
    <!-- </form> -->
  </div>
 
</section>

<?php include $this->resolve("partials/_footer.php"); ?>