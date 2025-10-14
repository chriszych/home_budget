
<?php

    $Balance2Button =  "btn-primary";
    $Balance1Button =  "btn-outline-primary";
?>

<div class="btn-group m-4" role="group" aria-label="Przełącznik raportu">
  <a href="/balanceCategory/currentMonth" class="btn btn-lg <?= $Balance2Button ?>" id="button2">Kategorie</a>
  <a href="/balanceAll/currentMonth" class="btn btn-lg <?= $Balance1Button ?>" id="button1">Użytkownik</a>
</div>