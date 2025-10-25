<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@7.3.2/css/flag-icons.min.css">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
     integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="./bilans.css">

    <script src="https://kit.fontawesome.com/f7c473a27a.js" crossorigin="anonymous"></script>
    <title>Personal online budget</title>

  <link rel="icon" href="./assets/favicon.png" type="image/png">


  </head>

  <body>


    <nav id="navBar">
    <!-- navBar -->

      <div class="navbar navbar-expand-lg bg-body-tertiary rounded">
        <div class="container-fluid">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#buttonNavbar" aria-controls="buttonNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

        <?php if(isset($_SESSION['user'])) : ?>
          <div class="collapse navbar-collapse d-lg-flex justify-content-between align-items-center" id="buttonNavbar">
           <div class="d-flex">
              <a class="house-hover d-flex justify-content-start align-items-center" href="/"><i class="fa-solid fa-house-chimney" style="color: #2861c3;"></i></a>
              <h1><a class="navbar-brand col-lg-3 me-0" href="/">&nbsp;Online Budget</a></h1>
            </div>

              <ul class="navbar-nav col-lg-9 justify-content-center">

                <li class="nav-item">
                  <a class="btn btn-lg btn-outline-primary m-1" href="/addTransaction/expense">New expense</a>
                </li>

                <li class="nav-item">
                  <a class="btn btn-lg btn-outline-primary m-1" href="/addTransaction/income">New income</a>
                </li>

                <li class="nav-item">
                  <a class="btn btn-lg btn-outline-primary m-1" href="/balanceAll/current-month">Current Balance</a>
                </li>              

                <li class="nav-item">
                  <a class="btn btn-lg btn-outline-primary m-1" href="/settings">Settings</a>
                </li>

                <li class="nav-item">
                  <a class="btn btn-lg btn-outline-primary m-1" href="/logout">Log out</a>
                </li>
              </ul>
            <!-- </div> -->
          </div>

        <?php else : ?>
        
        <div class="collapse navbar-collapse d-lg-flex" id="logNavbar">
          <a href="./"><i class="fa-solid fa-house-chimney" style="color: #2861c3;"></i></a>
          <h1><a class="navbar-brand col-lg-3 me-0" href="./">&nbsp;Online Budget</a></h1>
          <ul class="navbar-nav col-lg-9 justify-content-lg-end">
            <li class="nav-item">
              <a class="btn btn-lg btn-primary m-1" href="./login">Login</a>
            </li>
            <li class="nav-item">
              <a class="btn btn-lg btn-outline-primary m-1" href="./register">Register</a>
            </li>
          </ul>
        </div>
        
        <?php endif; ?>

        </div>
        <!-- <div class="dropdown">
          <button class="btn btn-outline-primary dropdown-toggle m-2" type="button" data-bs-toggle="dropdown">
          <span class="fi fi-gb"></span></button>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#"><span class="fi fi-pl"></span></a></li>
            <li><a class="dropdown-item" href="#"><span class="fi fi-gb"></span></a></li>
          </ul>
        </div> -->
      </div>

    </nav>