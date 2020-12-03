<?php
require_once "sql/queries.php";
session_start();

$carrito = "";

if (isset($_POST["buscar"])) {
    $arrayDispositivos = busqueda($_POST["busquedaInput"]);
}
if (isset($_POST["telefonos"])) {
    $arrayDispositivos = getMoviles();
}
if (isset($_POST["relojes"])) {
    $arrayDispositivos = getRelojes();
}

if (isset($_POST["cart"])) {
    $productoAñadido = getProducto($_POST["id"]);
    $_SESSION["carrito"][array_keys($productoAñadido)[0]] = array_values($productoAñadido)[0];
    $carrito = "Se añadió 1 " . $_SESSION["carrito"][$_POST["id"]]["modelo"] . " a la cesta.";
    $url = $_SESSION["carrito"][$_POST["id"]]["imagen"];
}

function busqueda($busquedaSelected)
{
    if (empty($busquedaSelected)) {
        $arrayDispositivos = getDispositivos();
    } else {
        $busqueda = strtolower($busquedaSelected);
        foreach (getDispositivos() as $id => $dispositivo) {
            if (strpos(strtolower($dispositivo["modelo"]), $busqueda) !== false) {
                $arrayDispositivos[$id] = $dispositivo;
            }
        }
    }
    if (isset($arrayDispositivos)) {
        return $arrayDispositivos;
    }
    return false;
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
    <link rel="shorcut icon" href="img/iconTitle.png">
    <link rel="stylesheet" href="/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
    <link rel="stylesheet" href="css/main.css">


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
                            <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
                                <input type="hidden" name="telefonos">
                                <input type="submit" class="dropdown-item" value="Teléfonos">
                            </form>
                            <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
                                <input type="hidden" name="relojes">
                                <input type="submit" class="dropdown-item" value="Smartwaches">
                            </form>
                        </div>
                    </li>
                </ul>
                <div class="col-6">
                    <form method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" class="form-inline my-2 my-lg-0 ml-5">
                        <input class="form-control buscador" name="busquedaInput" type="text" placeholder="Buscar" aria-label="Search" value="<?php if (isset($_POST["buscar"])) echo $_POST["busquedaInput"] ?>">
                        <button type="submit" class="btn btn-warning ml-1" name="buscar" id="buscar"> <i class="fas fa-search"></i></button>
                    </form>
                </div>
                <div class="dropdown">
                    <button class="btn bg-light dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Bienvenido <?= $_SESSION["visitante"]["nombre"] ?>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="perfil.php" title="perfil"><i class="fas fa-user mr-2"></i>Perfil</a>
                        <a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt mr-2"></i>Logout</a>
                    </div>
                </div>
                <form method="post" class="perfil form-inline my-2 my-lg-0" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
                    <div class="usuario d-inline ml-1">
                        <a 
                    </div>
                    <div class="logout d-inline ml-2">
                        <a href="carro.php" title="cesta"><i class="fas fa-shopping-cart fa-2x"></i></a>
                    </div>
                </form>
            </div>
        </nav>

        <div class="container">
            <div class="card-deck justify-content-center">
                <?php
                $elementoActual = 1;
                $limite = 5;
                if (isset($_POST["buscar"]) || isset($_POST["telefonos"]) || isset($_POST["relojes"])) : ?>
                    <?php if ($arrayDispositivos !== false) foreach ($arrayDispositivos as $id => $producto) : ?>
                        <!--AQUI VA CADA TARJETA DE LA BUSQUEDA-->
                        <?php if ($elementoActual === 1) echo "<div class='row'>" ?>
                        <div class="card text-white mt-4 carta">
                            <form action="producto.php" method="get" class="d-inline">
                                <div class="imagenCarta">
                                    <button type="submit" name="ficha" id="ficha"> <img class="card-img-top" src="<?= $producto["imagen"] ?>" alt="<?= $producto["modelo"] ?>"> </button>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title"><?= $producto["modelo"] ?></h5>
                                    <p class="card-text"><?= $producto["precio"] ?> €</p>
                                    <input type="hidden" name="id" value="<?= $id ?>">
                            </form>
                            <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
                                <input type="hidden" name="id" value="<?= $id ?>">
                                <button type="submit" class="btn btn-warning ml-4 d-inline cesta" name="cart" id="cart"><i class="fas fa-shopping-cart mr-3"></i> Añadir a la cesta </button>
                            </form>
                        </div>

            </div>
            <?php if ($elementoActual === $limite - 1) echo "</div>";
                        $elementoActual++;
                        if ($elementoActual === $limite) $elementoActual = 1; ?>
        <?php endforeach; ?>
        <?php if ($elementoActual !==  1) echo "</div>"; ?>
    <?php endif; ?>
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
    <?php endif; ?>
</body>
<script src='https://code.jquery.com/jquery-3.2.1.slim.min.js' integrity='sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN' crossorigin='anonymous'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js' integrity='sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q' crossorigin='anonymous'></script>
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js' integrity='sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl' crossorigin='anonymous'></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<?php if (isset($_POST["cart"])) : ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: '<?= $carrito ?>',
            backdrop: `rgba(0,0,123,0.4)`,
            imageUrl: '<?= $url ?>',
            width: 400,
            imageClass: 'sa2-image',
            showConfirmButton: false,
            timer: 2000
        })
    </script>
<?php endif ?>

</html>