
<div class="navbar navbar-expand rounded justify-content-center">
  <div class="d-flex justify-content-center w-100" id="buttonNavbar">
    <ul class="navbar-nav d-flex flex-column flex-lg-row justify-content-center">
      <li class="nav-item">
        <a class="btn btn-lg <?= $currentViewmode === 'current-month' ? 'btn-primary' : 'btn-outline-primary' ?> m-2 w-100" 
        href="./current-month">
        Current month</a>
      </li>
      <li class="nav-item">
        <a class="btn btn-lg <?= $currentViewmode === 'last-month' ? 'btn-primary' : 'btn-outline-primary' ?> m-2 w-100" 
        href="./last-month">
        Previous month</a>
      </li>
      <li class="nav-item">
        <a class="btn btn-lg <?= $currentViewmode === 'current-year' ? 'btn-primary' : 'btn-outline-primary' ?> m-2 w-100" 
        href="./current-year">
        Current year</a>
      </li>
      <li class="nav-item">
        <a class="btn btn-lg <?= $currentViewmode === 'custom' ? 'btn-primary' : 'btn-outline-primary' ?> m-2 w-100" 
        href="./custom">
        Custom date</a>
      </li>
    </ul>
  </div>
</div>

