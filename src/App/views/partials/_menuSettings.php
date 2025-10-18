
<div class="navbar navbar-expand rounded justify-content-center">
  <div class="d-flex justify-content-center w-100" id="buttonNavbar">
    <ul class="navbar-nav d-flex flex-column flex-lg-row justify-content-center">
      <li class="nav-item">
        <a class="btn btn-lg <?= $currentViewmode === 'current-month' ? 'btn-primary' : 'btn-outline-primary' ?> m-2 w-100" 
        href="./current-month">
        Aktualny miesiąc</a>
      </li>
      <li class="nav-item">
        <a class="btn btn-lg <?= $currentViewmode === 'last-month' ? 'btn-primary' : 'btn-outline-primary' ?> m-2 w-100" 
        href="./last-month">
        Poprzedni miesiąc</a>
      </li>
      <li class="nav-item">
        <a class="btn btn-lg <?= $currentViewmode === 'current-year' ? 'btn-primary' : 'btn-outline-primary' ?> m-2 w-100" 
        href="./current-year">
        Aktualny rok</a>
      </li>
      <li class="nav-item">
        <a class="btn btn-lg <?= $currentViewmode === 'custom' ? 'btn-primary' : 'btn-outline-primary' ?> m-2 w-100" 
        href="./custom">
        Dowolna data</a>
      </li>
    </ul>
  </div>
</div>

