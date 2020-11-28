<?php
require_once "sql/queries.php";
if (isset($_GET["ficha"])) {
    $idSelected = $_GET["id"];
    list($ficha, $tipo) = getFicha($idSelected);
    $ficha = $ficha[$idSelected];
}
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <title><?= $ficha["modelo"] ?></title>
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' integrity='sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm' crossorigin='anonymous'>
    <link rel="shorcut icon" href="img/logo.png">
    <link rel="stylesheet" href="/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navegador text-light">
    <a class="navbar" href="main.php">
        <img src="img/logo.png" class="d-inline-block align-top imagen">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fas fa-align-justify"></i>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="main.php">Inicio <span class="sr-only"></span></a>
            </li>
        </ul>

        <div class="perfil form-inline my-2 my-lg-0">
            <a href="perfil.php">Bienvenido<img class="img-fluid ml-3 user" src="img/user.png" alt="Logo Corporativo"></a>
            <a href="index.php"><img class="img-fluid ml-3 logout" src="img/logout.svg" alt="Logout"></a>
        </div>
    </div>
</nav>
<div class="container">
    <div class="row justify-content-center">
        <div class="card text-white mt-4">
            <img class="card-img-top img-fluid" src="<?= $ficha["imagen"] ?>" alt="<?= $ficha["modelo"] ?>">
            <div class="card-body">
                <h5 class="card-title text-center "><?= $ficha["modelo"] ?></h5>
                <hr>
                <p class="card-text">Precio: <?= $ficha["precio"] ?> €</p>
                <p class="card-text">Gama <?= $ficha["gama"] ?></p>
                <p class="card-text">Procesador: <?= $ficha["procesador"] ?></p>
                <p class="card-text">Batería: <?= $ficha["bateria"] ?>mAh</p>
                <p class="card-text">Pantalla: <?= $ficha["pulgadas"] ?> pulgadas</p>
                <p class="card-text">Stock en tienda: <?= $ficha["stock"] ?> unidades</p>
                <?php if ($tipo == "movil") : ?>
                    <p class="card-text">Camara trasera: <?= $ficha["camara"] ?>Mpx</p>
                    <p class="card-text">Tiene notch: <?php if ($ficha["notch"]) {
                            echo "Si";
                        } else {
                            echo "No";
                        } ?></p>
                <?php endif; ?>
                <?php if ($tipo == "reloj") : ?>
                    <p class="card-text">Tarjeta SIM: <?php if ($ficha["sim"]) {
                            echo "Si";
                        } else {
                            echo "No";
                        } ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
</body>
<script src='https://code.jquery.com/jquery-3.2.1.slim.min.js'
        integrity='sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN'
        crossorigin='anonymous'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js'
        integrity='sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q'
        crossorigin='anonymous'></script>
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js'
        integrity='sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl'
        crossorigin='anonymous'></script>
</html>
