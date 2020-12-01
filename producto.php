<?php
require_once "sql/queries.php";
session_start();

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />

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
         
            <form method="post" class="perfil form-inline my-2 my-lg-0" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
                <div class="usuario d-inline ml-1">
                    <a href="perfil.php">Bienvenido<i class="fas fa-user-tie fa-2x ml-2"></i></a>
                </div>
                <div class="logout d-inline ml-2">
                    <a href="index.php"><i class="fas fa-sign-out-alt fa-2x"></i></a>
                </div>
            </form>
        </div>
    </nav>
    <div class="container">
    <div class="row justify-content-center">
        <div class="card text-white mt-4 carta">
            <img class="card-img-top img-fluid" src="<?= $ficha["imagen"] ?>" alt="<?= $ficha["modelo"] ?>">
            <div class="card-body">
                <h5 class="card-title text-center text-warning"><?= $ficha["modelo"] ?></h5>
                <hr>
                <p class="card-text">Precio: <?= $ficha["precio"] ?> €</p>
                <p class="card-text">Gama <?= $ficha["gama"] ?></p>
                <?php if(!empty($ficha["procesador"])) : ?>
                <p class="card-text">Procesador: <?= $ficha["procesador"] ?></p>
                <?php endif; ?>
                <?php if(!empty($ficha["bateria"])) : ?>
                <p class="card-text">Batería: <?= $ficha["bateria"] ?>mAh</p>
                <?php endif; ?>
                <?php if(!empty($ficha["pulgadas"])) : ?>
                <p class="card-text">Pantalla: <?= $ficha["pulgadas"] ?> pulgadas</p>
                <?php endif; ?>
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
<footer class="page-footer font-small blue">
        <div class="footer-copyright text-center py-3">&copy; 2020 Copyright:
            <a href="http://web2.iesmiguelherrero.com/"> IES Miguel Herrero</a>
            &reg; <a href="index.php">P3</a>
            <a href="https://www.instagram.com/?hl=es"> <i class="fab fa-instagram ml-3"></i></a>
            <a href="https://twitter.com/IbaiLlanos"> <i class="fab fa-twitter"></i></a>
        </div>
    </footer>
</body>
<script src='https://code.jquery.com/jquery-3.2.1.slim.min.js' integrity='sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN' crossorigin='anonymous'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js' integrity='sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q' crossorigin='anonymous'></script>
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js' integrity='sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl' crossorigin='anonymous'></script>

</html>