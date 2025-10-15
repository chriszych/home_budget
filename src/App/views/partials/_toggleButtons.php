 <?php
  
  $viewMode = $_SESSION['viewMode'] ?? 'currentMonth';

?> 

<div class="btn-group m-4" role="group" aria-label="Przełącznik raportu">
  <a href="/balanceCategory/<?= $viewMode ?>" 
  class="btn btn-lg <?= $balanceMode === 'category' ? 'btn-primary' : 'btn-outline-primary' ?>" id="button2">
  Podział na kategorie</a>
  <a href="/balanceAll/<?= $viewMode ?>" 
  class="btn btn-lg <?= $balanceMode === 'detailed' ? 'btn-primary' : 'btn-outline-primary' ?>" id="button1">
  Wyświetl wszystko</a>
</div>