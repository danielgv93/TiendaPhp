<?php
require_once "funciones.php";

session_start();
if (!isset($_SESSION["carrito"])) {
    $_SESSION["carrito"][] = array("id" => 2, "modelo" => "One Plus 3", "imagen" => "img/dispositivos/OnePlus Nord.jpg",
        "precio" => 30);
}

?>
<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <title>Cesta</title>
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

                <form method="post" class="perfil form-inline my-2 my-lg-0" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
                    <div class="usuario d-inline ml-1">
                        <a href="perfil.php"><?= $_SESSION["visitante"]["nombre"] . " " . $_SESSION["visitante"]["apellidos"] ?><i class="fas fa-user-tie fa-2x ml-2"></i></a>
                    </div>
                    <div class="logout d-inline ml-2">
                        <a href="index.php"><i class="fas fa-sign-out-alt fa-2x"></i></a>
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
                                    <h1 class="display-4">Cesta de la compra</h1>
                                    <p class="lead mb-0">Suscríbete a nuestro catálogo y disfruta de nuestros descuentos para socios!</p>
                                </div>
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
                                                            <div class="py-2 text-uppercase">Precio</div>
                                                        </th>
                                                        <th scope="col" class="border-0 bg-light">
                                                            <div class="py-2 text-uppercase">Cantidad</div>
                                                        </th>
                                                        <th scope="col" class="border-0 bg-light">
                                                            <div class="py-2 text-uppercase">Eliminar</div>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <!-- Esto lo metes en uno de esos bucles tuyos rechingones bien vergosos
                                            y sacas todos los productos que haya añadidos asin en esa tablita -->
                                                <tbody>
                                                <?php foreach($_SESSION["carrito"] as $producto) : ?>
                                                    <tr>
                                                        <th scope="row" class="border-0">
                                                            <div class="p-2">
                                                                <img src="<?= $producto["imagen"] ?>" alt="" width="70" class="img-fluid rounded shadow-sm">
                                                                <div class="ml-3 d-inline-block align-middle">
                                                                    <h5 class="mb-0"> <a href="#" class="text-dark d-inline-block align-middle">Poco Phone mi abuelo</a></h5><span class="text-muted font-weight-normal font-italic d-block">Categoría: Smartwaches</span>
                                                                </div>
                                                            </div>
                                                        </th>
                                                        <td class="border-0 align-middle"><strong>tu vaina php</strong></td>
                                                        <td class="border-0 align-middle"><strong>tu vaina php</strong></td>
                                                        <td class="align-middle"><button class="btn"><i class="fas fa-trash"></i></button>
                                                    </tr>
                                                <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>

                                <div class="row py-5 p-4 bg-white rounded shadow-sm">
                                    <div class="col-lg-6">
                                        <div class="bg-light px-4 py-3 text-uppercase font-weight-bold">Codigo de descuento</div>
                                        <div class="p-4">
                                            <p class="font-italic mb-4">Si tiene codigo de descuento, introducelo debajo</p>
                                            <div class="input-group mb-4 border p-2">
                                                <input type="text" placeholder="Cupón descuento" aria-describedby="button-addon3" class="form-control border-0">
                                                <div class="input-group-append border-0">
                                                    <button id="button-addon3" type="button" class="btn btn-dark px-4"><i class="fa fa-gift mr-2"></i>Aplicar cupón</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bg-light px-4 py-3 text-uppercase font-weight-bold">Comentarios para el vendedor</div>
                                        <div class="p-4">
                                            <p class="font-italic mb-4">Si tiene algún comentario o sugerencia para el vendedor, por favor escríbela debajo</p>
                                            <textarea name="" cols="30" rows="2" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="bg-light px-4 py-3 text-uppercase font-weight-bold">Resumen del pedido</div>
                                        <div class="p-4">
                                            <p class="font-italic mb-4">Gastos de envío y descuentos calculados a continuación</p>
                                            <ul class="list-unstyled mb-4">
                                                <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Total pedido </strong><strong>
                                                        <!-- tu vaina php --></strong></li>
                                                <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Envío y procesamiento</strong><strong>
                                                        <!-- tu vaina php --></strong></li>
                                                <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">IVA</strong><strong>
                                                        <!-- tu vaina php --></strong></li>
                                                <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Total</strong>
                                                    <h5 class="font-weight-bold">
                                                        <!-- tu vaina php -->
                                                    </h5>
                                                </li>
                                            </ul><a href="#" class="btn btn-dark py-2 btn-block">Continuar al pago</a>
                                        </div>
                                    </div>
                                </div>

                            </div>
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

</html>