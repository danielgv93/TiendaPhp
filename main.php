<?php
require_once "sql/queries.php";


if (isset($_POST["buscar"])) {
    $arrayDispositivos = busqueda($_POST["busquedaInput"]);
}
if (isset($_POST["telefonos"])) {
    $arrayDispositivos = getMoviles();
}
if (isset($_POST["relojes"])) {
    $arrayDispositivos = getRelojes();
}

function busqueda($busquedaSelected)
{
    if (empty($busquedaSelected)) {
        $arrayDispositivos = getModelosBusqueda();
    } else {
        $busqueda = strtolower($busquedaSelected);
        foreach (getModelosBusqueda() as $id => $dispositivo) {
            if (strpos(strtolower($dispositivo["modelo"]), $busqueda) !== false) {
                $arrayDispositivos[$id] = $dispositivo;
            }
        }
    }
    return $arrayDispositivos;
}

?>

<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <title>Encuentra tu dispositivo</title>
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
            <span class="navbar-toggler-icon"></span>
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
                        <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
                            <input type="hidden" name="telefonos">
                            <input type="submit" class="dropdown-item" value="Teléfonos">
                            <!--RATON MANO EN HOVER POR CSS-->
                        </form>
                        <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
                            <input type="hidden" name="relojes">
                            <input type="submit" class="dropdown-item" value="Smartwaches">
                            <!--RATON MANO EN HOVER POR CSS-->
                        </form>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Otra vaina</a>
                    </div>
                </li>

            </ul>
            <div class="col-6">
                <form method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" class="form-inline my-2 my-lg-0">
                    <input class="form-control" name="busquedaInput" type="text" placeholder="Buscar" aria-label="Search">
                    <input type="submit" class="btn btn-warning ml-2" name="buscar" value="" id="buscar"> <i class="fas fa-binoculars"></i>
                </form>
            </div>
            <form method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" class="form-inline my-2 my-lg-0">
            Bienvenido<a href="perfil.php"><img class="img-fluid ml-2 user" src="img/user.png" alt="Logo Corporativo"></a>
            </form>
        </div>
    </nav>


    <div class="container">
        <div class="card-deck justify-content-center">
            <?php if (isset($_POST["buscar"]) || isset($_POST["telefonos"]) || isset($_POST["relojes"])) :
                $elementoActual = 1;
                $limite = 5; ?>
                <?php foreach ($arrayDispositivos as $id => $producto) : ?>
                <!--AQUI VA CADA TARJETA DE LA BUSQUEDA-->
                <?php if ($elementoActual === 1) echo "<div class='row'>" ?>
                <div class="card mt-4">
                    <form action="producto.php" method="get">
                        <img class="card-img-top" src="<?= $producto["imagen"] ?>" alt="<?= $producto["modelo"] ?>">
                        <div class="card-body">
                            <input type="hidden" name="id" value="<?= $id ?>">
                            <h5 class="card-title"><?= $producto["modelo"] ?></h5>
                            <p class="card-text"><?= $producto["precio"] ?> €</p>
                            <p class="card-text"><small class="text-muted"><input type="submit" name="ficha"
                                                                                  value="Ver Ficha"></small></p>
                        </div>
                    </form>
                </div>
                <?php if ($elementoActual === $limite - 1) echo "</div>";
                $elementoActual++;
                if ($elementoActual === $limite) $elementoActual = 1; ?>
            <?php endforeach; ?>
            <?php endif; ?>
            <?php if ($elementoActual !==  1) echo "</div>";?>
        </div>
    </div>


    <footer>
        <div class="text-center">
            pisicing olestias debitis dolor pariatur quam offic
        </div>
    </footer>
</body>
<script src='https://code.jquery.com/jquery-3.2.1.slim.min.js' integrity='sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN' crossorigin='anonymous'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js' integrity='sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q' crossorigin='anonymous'></script>
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js' integrity='sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl' crossorigin='anonymous'></script>

</html>