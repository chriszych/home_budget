

 <div class="album py-3 bg-body-tertiary">
      <div class="container">
        <div class="row row-cols-xl-2 row-cols-xl-2 g-1">
          <div class="col">
            <div class="card shadow-sm">
              <div class="card-body">
                <div class="container tableExpenses table-responsive">
                  
				  <h3>Przychody</h3>
				  <p>W okresie od <span class="fw-bold"><?= $sqlDataLow ?></span> do <span class="fw-bold"><?= $sqlDataHi ?></span></p>
				  
				    <table class="table table-hover">
                    <thead>
                     <tr>
                        <th class="text-center px-1">Nr.</th>
                       <th class="text-center px-1">Data</th>
                       <th class="text-center pe-1">Kwota</th>
                       <th class="px-1">Kategoria</th>
                       <th class="px-1">Komentarz</th>
                      </tr>
                    </thead>
					
					<tbody>
					<?php foreach ($resultInc as $i => $row): ?>
					<tr>
                    <td class="text-center px-1 fw-bold"><?= str_pad($i+1, 1, "0", STR_PAD_LEFT); ?>. </td>
                    <td class="text-center px-1 text-nowrap"><?= (new DateTime($row['inc_date']))->format('d.m.y H:i') ?></td>
                    <td class="text-end pe-1 fw-bold"><?= number_format($row['inc_amount'], 2, ',', '') ?></td>
                    <td class="px-1"><?= $row['inc_cat_name'] ?></td>
                    <td class="px-1"><?= $row['inc_comment'] ?></td>
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
                  <h3>Wydatki</h3>
                  <p>W okresie od <span class="fw-bold"><?= $sqlDataLow ?></span> do <span class="fw-bold"><?= $sqlDataHi ?></span></p>


					<table class="table table-hover">
                    <thead>
                      <tr>
                        <th class="text-center px-1">Nr.</th>
                        <th class="text-center px-1">Data</th>
                        <th class="text-center pe-1">Kwota</th>
                        <th class="px-1">Kategoria</th>
						<th class="px-1">Płatność</th>
                        <th class="px-1">Komentarz</th>
                      </tr>
                    </thead>
					
					<tbody>
          
					<?php foreach ($resultExp as $i => $row): ?>

					<tr>
                    <td class="text-center px-1 fw-bold"><?= str_pad($i+1, 1, "0", STR_PAD_LEFT); ?>. </td>
                    <td class="text-center px-1 text-nowrap"><?= (new DateTime($row['exp_date']))->format('d.m.y H:i') ?></td>
                    <td class="text-end pe-1 fw-bold"><?= number_format($row['exp_amount'], 2, ',', '') ?></td>
                    <td class="px-1"><?= $row['exp_cat_name'] ?></td>
					<td class="px-1"><?= $row['pay_met_name'] ?></td>
                    <td class="px-1"><?= $row['exp_comment'] ?></td>
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