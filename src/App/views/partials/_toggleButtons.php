 <?php
  if ($balanceMode == "detailed")
  {
    $Balance1Button =  "btn-primary";
    $Balance2Button =  "btn-outline-primary";
  }
  elseif ($balanceMode == "category")
  {
    $Balance2Button =  "btn-primary";
    $Balance1Button =  "btn-outline-primary";
  }
?> 

<div class="btn-group m-4" role="group" aria-label="Przełącznik raportu">
  <a href="/balanceCategory/currentMonth" class="btn btn-lg <?= $Balance2Button ?>" id="button2">Podział na kategorie</a>
  <a href="/balanceAll/currentMonth" class="btn btn-lg <?= $Balance1Button ?>" id="button1">Wyświetl wszystko</a>
</div>