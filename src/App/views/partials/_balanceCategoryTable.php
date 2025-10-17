

   <div class="album py-3 bg-body-tertiary">
      <div class="container">
        <div class="row row-cols-xl-2 row-cols-xl-2 g-1">
          <div class="col">
            <div class="card shadow-sm">
              <div class="card-body">
                <div class="container tableExpenses table-responsive">
                  
				  <h3>Przychody według kategorii</h3>
          <!-- <h3>Przychody według kategorii <?= $viewMode ?></h3> -->
				  <p>W okresie od <span class="fw-bold"><?= $dateLowLimit ?></span> do <span class="fw-bold"><?= $dateHiLimit ?></span></p>
				  
				    <table class="table table-hover">
                    <thead>
                     <tr>
                        <th class="text-center px-1">Nr.</th>
						<th class="px-1">Kategoria</th>
                       <th class="text-center pe-1">Kwota</th>
                       
                      </tr>
                    </thead>
					
					<tbody>
					<?php foreach ($resultInc as $i => $row): ?>
					<tr>
                    <td class="text-center px-1 fw-bold"><?= str_pad($i+1, 1, "0", STR_PAD_LEFT); ?>. </td>
					<td class="px-1"><?= $row['inc_cat_name'] ?></td>
                    <td class="text-end pe-1 fw-bold"><?= number_format($row['total_amount'], 2, ',', '') ?></td>
					</tr>
					<?php endforeach; ?>
					</tbody>
					
                    <tfoot>
                      <tr>
                        <th></th>
                        <th class="text-center">Suma: </th>
						<th class="text-end pe-1 text-nowrap"><?= number_format($incSum, 2, ',','') ?></th>
                        <th></th>
                        <th></th>
                      </tr>
                    </tfoot>
                  </table>

                </div>
              </div>
            </div>
          </div>

          <div class="col">
            <div class="card shadow-sm">
              <div class="card-body">
                <div class="container tableIncomes table-responsive">
                  <h3>Wydatki według kategorii</h3>
                  <p>W okresie od <span class="fw-bold"><?= $dateLowLimit ?></span> do <span class="fw-bold"><?= $dateHiLimit ?></span></p>

					<table class="table table-hover">
                    <thead>
                      <tr>
                        <th class="text-center px-1">Nr.</th>
						<th class="px-1">Kategoria</th>
                        <th class="text-center pe-1">Kwota</th>
                      </tr>
                    </thead>
					
					<tbody>
					<?php foreach ($resultExp as $i => $row): ?>
					<tr>
                    <td class="text-center px-1 fw-bold"><?= str_pad($i+1, 1, "0", STR_PAD_LEFT); ?>. </td>
					<td class="px-1"><?= $row['exp_cat_name'] ?></td>
                    <td class="text-end pe-1 fw-bold"><?= number_format($row['total_amount'], 2, ',', '') ?></td>
					</tr>
					<?php endforeach; ?>
					</tbody>
					
                    <tfoot>
                      <tr>
                       <th></th>
                       <th class="text-center">Suma: </th>
					   <th class="text-end pe-1 text-nowrap"><?= number_format($expSum, 2, ',','') ?></th>
                       <th></th>
                       <th></th>
                      </tr>
                    </tfoot>
                  </table>

                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>