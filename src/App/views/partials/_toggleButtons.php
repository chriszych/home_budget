
<?php
  $path = $_SERVER['REQUEST_URI'];
  $isBalance2 = strpos($path, '/balance2') !== false;
?>

<div class="btn-group m-4" role="group" aria-label="Przełącznik raportu">
  <a href="/balance2" class="btn btn-lg <?= $isBalance2 ? 'btn-primary' : 'btn-outline-primary' ?>" id="button1">Podział na kategorie</a>
  <a href="/balance" class="btn btn-lg <?= !$isBalance2 ? 'btn-primary' : 'btn-outline-primary' ?>" id="button2">Wyświetl wszystko</a>
</div>