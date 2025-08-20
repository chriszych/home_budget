<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
     integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="./bilans.css">

    <script src="https://kit.fontawesome.com/f7c473a27a.js" crossorigin="anonymous"></script>
    <title>Budżet domowy online</title>
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
          <div class="collapse navbar-collapse d-lg-flex" id="buttonNavbar">
            <a href="/"><i class="fa-solid fa-house-chimney" style="color: #2861c3;"></i></a>
            <h1><a class="navbar-brand col-lg-3 me-0" href="/">&nbsp;Budżet online</a></h1>
            <ul class="navbar-nav col-lg-9 justify-content-lg-end">

              <li class="nav-item">
                <a class="btn btn-lg btn-outline-primary m-1" href="./addExpense">Nowy wydatek</a>
              </li>

              <li class="nav-item">
                <a class="btn btn-lg btn-outline-primary m-1" href="./addIncome">Nowy przychód</a>
              </li>

              <li class="nav-item">
                <a class="btn btn-lg btn-outline-primary m-1" href="./bilans">Aktualny bilans</a>
              </li>              

              <li class="nav-item">
                <a class="btn btn-lg btn-outline-primary m-1" href="#">Ustawienia</a>
              </li>

              <li class="nav-item">
                <a class="btn btn-lg btn-outline-primary m-1" href="./logout">Wyloguj</a>
              </li>
            </ul>
          </div>

        <?php else : ?>
        
        <div class="collapse navbar-collapse d-lg-flex" id="logNavbar">
          <a href="./"><i class="fa-solid fa-house-chimney" style="color: #2861c3;"></i></a>
          <h1><a class="navbar-brand col-lg-3 me-0" href="./">&nbsp;Budżet online</a></h1>
          <ul class="navbar-nav col-lg-9 justify-content-lg-end">
            <li class="nav-item">
              <a class="btn btn-lg btn-primary m-1" href="./login">Logowanie</a>
            </li>
            <li class="nav-item">
              <a class="btn btn-lg btn-outline-primary m-1" href="./register">Rejestracja</a>
            </li>
          </ul>
        </div>
        
        <?php endif; ?>

        </div>
      </div>

    </nav>