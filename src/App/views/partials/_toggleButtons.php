
<div class="btn-group m-4" role="group" aria-label="Przełącznik raportu">
  <a href="/balanceCategory/<?= $currentViewmode ?>" 
  class="btn btn-lg <?= $balanceMode === 'balanceCategory' ? 'btn-primary' : 'btn-outline-primary' ?>" id="button2">
  Podział na kategorie</a>
  <a href="/balanceAll/<?= $currentViewmode ?>" 
  class="btn btn-lg <?= $balanceMode === 'balanceAll' ? 'btn-primary' : 'btn-outline-primary' ?>" id="button1">
  Wyświetl wszystko</a>
</div>