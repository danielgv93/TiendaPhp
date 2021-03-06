<?php
require_once "classes/Database.php";
require_once "classes/Carrito.php";
session_start();

if (isset($_POST["ficha"])) {
    $idSelected = $_POST["id"];
    list($ficha, $tipo) = Database::getInstance()->getFicha($idSelected);
}
?>

<!doctype html>
<html lang="es">

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <title>P3 - <?= $ficha->getModelo() ?></title>
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' integrity='sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm' crossorigin='anonymous'>
    <link rel="shorcut icon" href="img/iconTitle.png">
    <link rel="stylesheet" href="/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />

</head>

<body>
    <?php if (isset($_SESSION["visitante"])) : ?>
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
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Categorías
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <form action="main.php" method="post">
                                <input type="hidden" name="telefonos">
                                <input type="submit" class="dropdown-item" value="Teléfonos">
                            </form>
                            <form action="main.php" method="post">
                                <input type="hidden" name="relojes">
                                <input type="submit" class="dropdown-item" value="Smartwaches">
                            </form>
                        </div>
                    </li>
                </ul>
                <div class="col-6">
                    <form method="post" action="main.php" class="form-inline my-2 my-lg-0 ml-5">
                        <input class="form-control buscador" name="busquedaInput" type="text" placeholder="Buscar" aria-label="Search" value="<?php if (isset($_POST["buscar"])) echo $_POST["busquedaInput"] ?>">
                        <button type="submit" class="btn btn-warning ml-1" name="buscar" id="buscar"> <i class="fas fa-search"></i></button>
                    </form>
                </div>
                <div class="dropdown">
                    <button class="btn bg-light dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Bienvenido <?= $_SESSION["visitante"]->getNombre() ?>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="perfil.php" title="perfil"><i class="fas fa-user mr-2"></i>Perfil</a>
                        <a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt mr-2"></i>Logout</a>
                    </div>
                </div>
                <div class="usuario d-inline ml-1">
                    <a </div> <div class="logout d-inline ml-2">
                    <a href="carro.php" title="cesta"><i class="fab fa-opencart fa-2x"></i></a>
                    <div class="contador d-inline">
                        <?php if(!isset ($_SESSION["carrito"])) {
                            echo 0;
                        }else echo count($_SESSION["carrito"]->getProductos());?>
                    </div>
                </div>
            </div>
        </nav>
        <div class="container">
            <div class="row">
                <div class="col-md-4 offset-1">
                    <div class="mt-5 divImagen">
                        <div class="card-body">
                            <img class="card-img-top img-fluid imagenP imagen-cursor" src="<?= $ficha->getImagen() ?>" alt="<?= $ficha->getModelo() ?>">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mb-3 mt-5 producto text-white" style="max-width: 700px;">
                        <div class="card-body">
                            <h3 class="card-title"><?= $ficha->getModelo() ?></h3>
                            <h4 class="card-text"><?= $ficha->getPrecio() ?> €</h4>
                            <hr>
                            <p class="card-text">Gama <?= $ficha->getGama() ?></p>
                            <?php if (!empty($ficha->getProcesador())) : ?>
                                <p class="card-text">Procesador: <?= $ficha->getProcesador() ?></p>
                            <?php endif; ?>
                            <?php if (!empty($ficha->getBateria())) : ?>
                                <p class="card-text">Batería: <?= $ficha->getBateria() ?>mAh</p>
                            <?php endif; ?>
                            <?php if (!empty($ficha->getPulgadas())) : ?>
                                <p class="card-text">Pantalla: <?= $ficha->getPulgadas() ?> pulgadas</p>
                            <?php endif; ?>
                            <p class="card-text">Stock en tienda: <?= $ficha->getStock() ?> unidades</p>
                            <?php if ($tipo == "movil") : ?>
                                <p class="card-text">Camara trasera: <?= $ficha->getCamara() ?>Mpx</p>
                                <p class="card-text">Tiene notch: <?php if ($ficha->getNotch()) {
                                                                        echo "Si";
                                                                    } else {
                                                                        echo "No";
                                                                    } ?></p>
                            <?php endif; ?>
                            <?php if ($tipo == "reloj") : ?>
                                <p class="card-text">Tarjeta SIM: <?php if ($ficha->getSim()) {
                                                                        echo "Si";
                                                                    } else {
                                                                        echo "No";
                                                                    } ?></p>
                            <?php endif; ?>
                            <form action="main.php" method="post">
                                <div class="col-2">
                                    <input type="hidden" name="id" value="<?= $_POST["id"] ?>">
                                    <button type="submit" class="btn btn-warning ml-4 d-inline cesta" name="cart" id="cart"><i class="fas fa-shopping-cart mr-3"></i> Añadir a la cesta </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="page-footer font-small blue">
            <div class="footer-copyright text-center py-3">&copy; 2020 Copyright:
                <a href="http://web2.iesmiguelherrero.com/"> IES Miguel Herrero</a>
                &reg; <a href="index.php">P3</a>
                <a href="https://www.instagram.com/josebaa11/" target="blank"> <i class="fab fa-instagram ml-3"></i></a>
                <a href="https://twitter.com/IbaiLlanos"> <i class="fab fa-twitter"></i></a>
            </div>
        </footer>
    <?php else : ?>
        <div class="container">
            <div>
                <div class="alert alert-warning aviso" role="alert">
                    Parece que aún no has <a href="index.php" class="alert-link">iniciado sesión</a>. No dudes en hacerlo!
                    <i class="far fa-comment-dots fa-8x"></i>
                </div>
            </div>
        </div>
    <?php endif ?>
</body>
<script src='https://code.jquery.com/jquery-3.2.1.slim.min.js' integrity='sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN' crossorigin='anonymous'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js' integrity='sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q' crossorigin='anonymous'></script>
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js' integrity='sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl' crossorigin='anonymous'></script>

</html>