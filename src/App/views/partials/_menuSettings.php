
<?php

$viewMode = $_SESSION['viewMode'] ?? 'currentMonth';

?>

<div class="navbar navbar-expand rounded justify-content-center">
  <div class="d-flex justify-content-center w-100" id="buttonNavbar">
    <ul class="navbar-nav d-flex flex-column flex-lg-row justify-content-center">
      <li class="nav-item">
        <a class="btn btn-lg <?= $viewMode === 'currentMonth' ? 'btn-primary' : 'btn-outline-primary' ?> m-2 w-100" 
        href="./currentMonth">
        Aktualny miesiąc</a>
      </li>
      <li class="nav-item">
        <a class="btn btn-lg <?= $viewMode === 'lastMonth' ? 'btn-primary' : 'btn-outline-primary' ?> m-2 w-100" 
        href="./lastMonth">
        Poprzedni miesiąc</a>
      </li>
      <li class="nav-item">
        <a class="btn btn-lg <?= $viewMode === 'currentYear' ? 'btn-primary' : 'btn-outline-primary' ?> m-2 w-100" 
        href="./currentYear">
        Aktualny rok</a>
      </li>
      <li class="nav-item">
        <a class="btn btn-lg <?= $viewMode === 'customDates' ? 'btn-primary' : 'btn-outline-primary' ?> m-2 w-100" 
        href="./customDates">
        Dowolna data</a>
      </li>
    </ul>
  </div>
</div>

