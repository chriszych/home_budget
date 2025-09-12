    <div class="col-lg-6 col-md-8 mx-auto">
      <div class="card mb-3 rounded-3 shadow-sm border-success">
          <div class="card-header py-3 <?= ($balance > 0) ? 'text-bg-success border-success':'text-bg-danger border-danger'?>">
          <h2 class="my-0 fw-bold"><?= $messageMain ?></h2>
          <!-- <div class="card-header py-3 <?= ($balance > 0) ? 'text-bg-success border-success':'text-bg-danger border-danger'?>">
          <h2 class="my-0 fw-bold"><?= ($balance > 0) ? 'Gratulacje!!!':'Uwaga!!!'?></h2> -->
          <!-- <div class="card-header py-3 <= (($incSum-$expSum) > 0) ? 'text-bg-success border-success':'text-bg-danger border-danger'?>">
          <h2 class="my-0 fw-bold"><= (($incSum-$expSum) > 0) ? 'Gratulacje!!!':'Uwaga!!!'?></h2> -->
        </div>
        <div class="card-body">
          <h3><?= $messageText ?></h3>
		      <h3>Aktualne saldo: <span class="fw-bold <?= ($balance > 0) ? 'text-success':'text-danger'?>"><?= $balance ?> PLN</span></h3>
          <!-- <h3><?= ($balance > 0) ? 'Świetnie zarządzasz swoimi finansami :)':'Ostrożnie, wpadasz w długi :('?></h3>
		      <h3>Aktualne saldo: <span class="fw-bold <?= ($balance > 0) ? 'text-success':'text-danger'?>"><?= $balance ?> PLN</span></h3> -->
          <!-- <h3><= (($incSum-$expSum) > 0) ? 'Świetnie zarządzasz swoimi finansami :)':'Ostrożnie, wpadasz w długi :('?></h3>
		      <h3>Aktualne saldo: <span class="fw-bold <= (($incSum-$expSum) > 0) ? 'text-success':'text-danger'?>"><= $incSum-$expSum ?> PLN</span></h3> -->
        </div>
      </div>
    </div>