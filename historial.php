<?php
require_once "sql/queries.php";
require_once "funciones.php";

session_start();
$historiales=getHistorial($_SESSION["visitante"]["id"]);
?>
<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <title>Historial</title>
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
                </ul>
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
                        <a </div> <div class="logout d-inline ml-2">
                            <a href="carro.php" title="cesta"><i class="fas fa-shopping-cart fa-2x"></i></a>
                    </div>
                </form>
            </div>
        </nav>
        <div class="container">
            <div class="row justify-content-center mt-5">
                <div class="px-4 px-lg-0">

                    <div class="pb-5">
                        <div class="container">
                            <div class="py-5 text-center">
                                <h1 class="display-4">Historial de compra</h1>
                            </div>
                            <form action="compra.php" method="post">
                                <div class="row">
                                    <div class="col-lg-12 p-5 bg-white rounded shadow-sm mb-5">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <!-- Esto asi a machete, no toques na -->
                                                <thead>
                                                    <tr>
                                                        <th scope="col" class="border-0 bg-light">
                                                            <div class="p-2 px-3 text-uppercase">Producto</div>
                                                        </th>
                                                        <th scope="col" class="border-0 bg-light">
                                                            <div class="py-2 px-5 text-uppercase">Precio</div>
                                                        </th>
                                                        <th scope="col" class="border-0 bg-light">
                                                            <div class="py-2 px-5 text-uppercase">Cantidad</div>
                                                        </th>
                                                        <th scope="col" class="border-0 bg-light">
                                                            <div class="py-2 px-5 text-uppercase">Fecha</div>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <!-- Esto lo metes en uno de esos bucles tuyos rechingones bien vergosos
                                                y sacas todos los productos que haya añadidos asin en esa tablita -->
                                                <tbody>

                                                    <?php foreach ($historiales as $id => $producto) : ?>
                                                        <tr>
                                                            <th scope="row" class="border-0">
                                                                <div class="p-2">
                                                                    <img src="<?= $producto["imagen"] ?>" alt="Imagen de <?= $producto["imagen"] ?>" width="70" class="img-fluid imagenCesta rounded shadow-sm">
                                                                    <div class="ml-3 d-inline-block align-middle">
                                                                        <h5 class="mb-0 text-dark d-inline-block align-middle">
                                                                            <?= $producto["modelo"] ?>
                                                                        </h5>
                                                                    </div>
                                                                </div>
                                                            </th>
                                                            <input type="hidden" name="id[]" value="<?= $id ?>">
                                                            <td class="border-0 align-middle text-center"><strong><?= $producto["precio"] ?>€</strong><input type="hidden" name="precio[]" value="<?= $producto["precio"] ?>" readonly></td>
                                                            <td class="border-0 align-middle text-center"><strong><?= $producto["cantidad"] ?></strong></td>
                                                            <td class="border-0 align-middle text-center">
                                                                <p class="mb-0 text-dark d-inline-block align-middle"><?= $producto["fecha"] ?></p>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
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
                    <i class="far fa-comment-dots"></i>
                </div>
            </div>
        </div>
    <?php endif; ?>
</body>
<script src='https://code.jquery.com/jquery-3.2.1.slim.min.js' integrity='sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN' crossorigin='anonymous'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js' integrity='sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q' crossorigin='anonymous'></script>
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js' integrity='sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl' crossorigin='anonymous'></script>
<script>
    let subtotal = document.getElementById("subtotal-input");
    let envio = document.getElementById("envio-input");
    let total = document.getElementById("total-input");
    let precios = document.getElementsByName("precio[]");
    let cantidades = document.getElementsByName("cantidad[]");
    calculo();

    function getArray(coleccion) {
        let array = Array();
        for (let i = 0; i < coleccion.length; i++) {
            array.push(coleccion[i].value);
        }
        return array;
    }

    function calculo() {
        let facturaTotal = 0;
        let arrayPrecios = getArray(precios);
        let arrayCtd = getArray(cantidades);
        for (let i = 0; i < getArray(precios).length; i++) {
            facturaTotal += arrayPrecios[i] * arrayCtd[i];
        }
        subtotal.innerHTML = facturaTotal.toFixed(2) + " €";
        getPrecioEnvio();
        total.innerHTML = (parseInt(subtotal.innerText) + parseInt(envio.innerText)).toFixed(2);
    }

    function getPrecioEnvio() {
        let precioEnvio1 = 35;
        let precioEnvio2 = 0;
        if (parseInt(subtotal.innerText) < 1500) {
            envio.innerHTML = precioEnvio1.toFixed(2) + " €";
        } else {
            envio.innerHTML = precioEnvio2.toFixed(2) + " €";
        }
    }
</script>

</html>