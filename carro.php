<?php
require_once "classes/Database.php";
require_once "funciones.php";

session_start();

?>
<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <title>P3 - Cesta</title>
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
                        Bienvenido <?= $_SESSION["visitante"]->getNombre() ?>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="perfil.php" title="perfil"><i class="fas fa-user mr-2"></i>Perfil</a>
                        <a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt mr-2"></i>Logout</a>
                    </div>
                </div>
                <form method="post" class="perfil form-inline my-2 my-lg-0" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
                    <div class="usuario d-inline ml-1">
                        <a </div> <div class="logout d-inline ml-2">
                            <a href="carro.php" title="cesta"><i class="fab fa-opencart fa-2x"></i></a>
                            <div class="contador d-inline">
                                <?php if(!isset ($_SESSION["carrito"])) {
                                echo 0;
                            }else echo count($_SESSION["carrito"]);?>
                            </div>
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
                            <form action="compra.php" method="post">
                                <div class="row">
                                    <div class="col-lg-12 p-5 bg-white rounded shadow-sm mb-5">
                                        <button type="submit" name="borrar" class="btn mb-2 borrar"><i class="fas fa-trash fa-2x"></i> BORRAR CESTA</button>
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
                                                            <div class="py-2 px-5 text-uppercase">Cantidad</div>
                                                        </th>
                                                        <th scope="col" class="border-0 bg-light">
                                                            <div class="py-2 text-uppercase">Modificar</div>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <!-- Esto lo metes en uno de esos bucles tuyos rechingones bien vergosos
                                                y sacas todos los productos que haya añadidos asin en esa tablita -->
                                                <tbody>

                                                    <?php if (isset($_SESSION["carrito"]))  foreach ($_SESSION["carrito"] as $id => $producto) : ?>
                                                        <tr>
                                                            <input type="hidden" name="id[]" value="<?= $id ?>">
                                                            <th scope="row" class="border-0">
                                                                <div class="p-2">
                                                                    <img src="<?= $producto->getImagen() ?>" alt="Imagen de <?= $producto->getImagen() ?>" width="70" class="img-fluid imagenCesta rounded shadow-sm">
                                                                    <div class="ml-3 d-inline-block align-middle">
                                                                        <h5 class="mb-0 text-dark d-inline-block align-middle">
                                                                            <?= $producto->getModelo() ?>
                                                                        </h5>
                                                                        <span class="text-muted font-weight-normal font-italic d-block">
                                                                            Categoría: <?php if (Database::getInstance()->getTipoDispositivo($id) === "movil") echo "movil";
                                                                                        else echo "smartwatch" ?></span>
                                                                    </div>
                                                                </div>
                                                            </th>
                                                            <td class="border-0 align-middle text-center"><strong><?= $producto->getPrecio() ?>€</strong><input type="hidden" name="precio[]" value="<?= $producto->getPrecio() ?>" readonly></td>
                                                            <td class="border-0 align-middle"><input type="number" class="text-center cantidad" id="<?= $id ?>_cantidad" name="cantidad[]" value="1" oninput="calculo()" min="0" readonly></td>
                                                            <!-- BOTONES BIEN CHINGONES, FALTA QUE HAGAN ALGO -->
                                                            <td class="border-0 align-middle">
                                                                <button type="button" class="d-inline btn" onclick="(()=>{
                                                                    let cantidad = document.getElementById('<?= $id ?>_cantidad');
                                                                        if (cantidad.value > 0){
                                                                            cantidad.value--;
                                                                        }
                                                                })();calculo()" class="btn mr-2"><i class="fas fa-minus"></i></button>
                                                                <button type="button" class="d-inline btn" onclick="(()=>{
                                                                    let cantidad = document.getElementById('<?= $id ?>_cantidad');
                                                                        if (cantidad.value < <?= $producto->getStock() ?>){
                                                                            cantidad.value++;
                                                                        }
                                                                })();calculo()" class="btn"><i class="fas fa-plus"></i></button>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>

                                <div class="row py-5 p-4 bg-white rounded shadow-sm">
                                    <div class="col-lg-6">
                                        <div class="bg-light px-4 py-3 text-uppercase font-weight-bold">Codigo de
                                            descuento
                                        </div>
                                        <div class="p-4">
                                            <p class="font-italic mb-4">Si tiene codigo de descuento, introducelo
                                                debajo</p>
                                            <div class="input-group mb-4 border p-2">
                                                <input type="text" placeholder="Cupón descuento" aria-describedby="button-addon3" class="form-control">
                                                <div class="input-group-append border-0">
                                                    <button id="button-addon3" type="button" class="btn btn-dark px-4">
                                                        <i class="fa fa-gift mr-2"></i>Aplicar cupón
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bg-light px-4 py-3 text-uppercase font-weight-bold">Comentarios para
                                            el vendedor
                                        </div>
                                        <div class="p-4">
                                            <p class="font-italic mb-4">Si tiene algún comentario o sugerencia para el
                                                vendedor, por favor escríbela debajo</p>
                                            <textarea name="comentario" cols="30" rows="2" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="bg-light px-4 py-3 text-uppercase font-weight-bold">Resumen del
                                            pedido
                                        </div>
                                        <div class="p-4">
                                            <p class="font-italic mb-4">Gastos de envío y descuentos calculados a
                                                continuación</p>
                                            <ul class="list-unstyled mb-4">
                                                <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Total pedido </strong><strong>
                                                        <label id="subtotal-input"></label></strong></li>
                                                <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Envío y procesamiento</strong><strong>
                                                        <label id="envio-input">0</label></strong></li>
                                                <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Total</strong>
                                                    <h5 class="font-weight-bold">
                                                        <label id="total-input"></label>
                                                    </h5>
                                                </li>
                                            </ul>
                                            <button type="submit" name="pago" class="btn btn-dark py-2 btn-block">Continuar al pago</button>

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
    <?php /*if (isset($_POST["borrar"])) : */ ?>
    /*
            Swal.fire({
                icon: 'warning',
                title: '¿Quieres borrar el elemento?',
                backdrop: `rgba(0,0,123,0.4)`,
                width: 400,
                showConfirmButton: false
            })
    */
    <?php /*endif */ ?>
</script>

</html>