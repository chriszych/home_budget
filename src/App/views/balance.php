
<?php

	$expSum = 0;
	$incSum = 0;

?>


<?php include $this->resolve("partials/_header.php"); ?>

  <!-- mainPageContent -->
  <section id="mainPageContent">

    <section class="py-3 text-center container">
      <div class="row py-lg-3">
        <div class="col-lg-6 col-md-8 mx-auto">
          <h2 class="fw-light fw-bold">Bilans na bieżący miesiąc</h2>
			<h3>Struktura Twoich przychodów i wydatków <br> w okresie <span class="fw-bold">od <?= $firstCurrentMonthDay ?> do
            <?= $lastCurrentMonthDay ?></span></h3>
        </div>
      </div>
	  
      <?php include $this->resolve("partials/_toggleButtons.php"); ?>
	    <!-- <div class="btn-group m-4" role="group" aria-label="Przełącznik raportu">
        <a href="./balance2" class="btn btn-lg btn-outline-primary" id="button1" onclick="toggleButtons('button1', 'button2')">Podział na kategorie</a>
        <a href="./balance" class="btn btn-lg btn-primary" id="button2" onclick="toggleButtons('button2', 'button1')">Wyświetl wszystko</a>
		</div>   -->
	  
    </section>
    <div class="album py-3 bg-body-tertiary">
      <div class="container">
        <div class="row row-cols-xl-2 row-cols-xl-2 g-1">
          <div class="col">
            <div class="card shadow-sm">
              <div class="card-body">
                <div class="container tableExpenses table-responsive">
                  
				  <h3>Przychody</h3>
				  <p>W okresie od <span class="fw-bold"><?= $firstCurrentMonthDay ?></span> do <span class="fw-bold"><?= $lastCurrentMonthDay ?></span></p>
				  
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
					<?php 
					$i = 0;
					foreach ($resultInc as $row): 
					$incSum += $row['inc_amount'];
					$i++;
					?>
					<tr>
                    <td class="text-center px-1 fw-bold"><?= str_pad($i, 1, "0", STR_PAD_LEFT); ?>. </td>
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
                  <p>W okresie od <span class="fw-bold"><?= $firstCurrentMonthDay ?></span> do <span class="fw-bold"><?= $lastCurrentMonthDay ?></span></p>


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
					<?php 
					$i = 0;
					foreach ($resultExp as $row): 
					$i++;
					$expSum += $row['exp_amount'];
					?>
					<tr>
                    <td class="text-center px-1 fw-bold"><?= str_pad($i, 1, "0", STR_PAD_LEFT); ?>. </td>
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
  </section>
  <section class="py-3 text-center container">

<?php include $this->resolve("partials/_balanceSummary.php"); ?>

    <!-- <div class="col-lg-6 col-md-8 mx-auto">
      <div class="card mb-3 rounded-3 shadow-sm border-success">
        <div class="card-header py-3 <= (($incSum-$expSum) > 0) ? 'text-bg-success border-success':'text-bg-danger border-danger'?>">
          <h2 class="my-0 fw-bold"><= (($incSum-$expSum) > 0) ? 'Gratulacje!!!':'Uwaga!!!'?></h2>
        </div>
        <div class="card-body">
          <h3><= (($incSum-$expSum) > 0) ? 'Świetnie zarządzasz swoimi finansami :)':'Ostrożnie, wpadasz w długi :('?></h3>
		  <h3>Aktualne saldo: <span class="fw-bold <= (($incSum-$expSum) > 0) ? 'text-success':'text-danger'?>"><?= $incSum-$expSum ?> PLN</span></h3>
        </div>
      </div>
    </div> -->

    <div class="container-sm" style="position: relative;">
      <div class="row">
        <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto">
          <canvas id="myChart"></canvas>
        </div>
      </div>
    </div>
  </section>
  
  <!-- Footer -->
  <?php include $this->resolve("partials/_footer.php"); ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.0/dist/chart.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

  <script>
  const chartLabels = <?= json_encode($chartLabels) ?>;
  const chartData = <?= json_encode($chartData) ?>;
</script>
 
<script src="/js/chart.js"></script>


</body>

</html>