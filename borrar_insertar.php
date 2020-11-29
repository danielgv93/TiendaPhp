<!-- <div class='col-12 mt-3 alert alert-warning text-center' role='alert'>CLASE DE WARNING (NEUTRA)</div>
<div class='col-12 mt-3 alert alert-success text-center' role='alert'>CLASE DE EXITO</div>
<div class='col-12 mt-3 alert alert-danger text-center' role='alert'>CLASE DE FALLO</div> -->
<?php
require_once "sql/queries.php";

$mensajeError = "";
if (isset($_POST["updateStock"])) {
    try {
        updateStock($_POST["idModelo"], $_POST["stockDispositivo"]);
        $mensajeError = "El stock se ha modificado a " . $_POST["stockDispositivo"] . " unidades";
    } catch (Exception $e) {
        $mensajeError .= $e->getMessage();
    }
}
if (isset($_POST["insertarMovil"]) && $_POST["modelo"] && $_POST["precio"]) {
    try {
        if (($targetFile = getImagen()) !== false) {
            if (addMovil(
                $_POST["modelo"],
                $_POST["precio"],
                $_POST["gama"],
                $_POST["anio"],
                $_POST["ram"],
                $_POST["almacenamiento"],
                $_POST["procesador"],
                $_POST["bateria"],
                $_POST["pulgadas"],
                $targetFile,
                $_POST["camara"],
                $_POST["notch"]
            ))

                $mensajeError .= "Movil añadido con éxito!";
        }
    } catch (Exception $e) {
        $mensajeError .= $e->getMessage();
    }
}
if (isset($_POST["insertarReloj"]) && $_POST["modelo"] && $_POST["precio"]) {
    try {
        if (($targetFile = getImagen()) !== false) {
            if (addReloj(
                $_POST["modelo"],
                $_POST["precio"],
                $_POST["gama"],
                $_POST["anio"],
                $_POST["ram"],
                $_POST["almacenamiento"],
                $_POST["procesador"],
                $_POST["bateria"],
                $_POST["pulgadas"],
                $targetFile,
                $_POST["sim"]
            ))
                $mensajeError .= "Reloj añadido con éxito!";
        }
    } catch (Exception $e) {
        $mensajeError .= $e->getMessage();
    }
}
if (isset($_POST["borrar"])) {
    try {
        if (borrarModelo($_POST["modelo"])) {
            $mensajeError = "Se ha borrado el dispositivo!";
        }
    } catch (Exception $e) {
        $mensajeError .= $e->getMessage();
    }
}

function getImagen()
{

    $targetFile = "img/dispositivos/" . $_POST["modelo"] . "." . getExtension($_FILES["imagen"]["type"]);
    if (!file_exists($_FILES["imagen"]["tmp_name"])) {
        throw new Exception("Elige imagen para subir");
    }
    if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $targetFile)) {
        return $targetFile;
    }
    return false;
}

function getExtension($tipoImagen)
{
    try {
        if ($tipoImagen == null) {
            throw new Exception("Elige una imagen");
        }
        return explode("/", $tipoImagen)[1];
    } catch (Exception $e) {
    }
}


?>

<!doctype html>
<html lang="es">

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <title>Configurar trastienda</title>
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' integrity='sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm' crossorigin='anonymous'>
    <link rel="shorcut icon" href="img/iconTitle.png">
    <link rel="stylesheet" href="/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
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
            <form method="post" class="perfil" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" class="form-inline my-2 my-lg-0">
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
        <div class="row justify-content-center mt-5">
            <div class="col-6">
                <!-- ELEGIR MODELO PARA CAMBIAR EL STOCK -->
                <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" class="border border-primary p-2 mb-3 rounded" name="formulario">
                    <legend class="text-center header">Modificar stock</legend>
                    <div class="form-group">
                        <select name="modelo" class="form-control">
                            <?php
                            $dispositivos = getDispositivos();
                            foreach ($dispositivos as $id => $dispositivo) : ?>
                                <option value="<?= $id ?>" <?php if (isset($_POST["elegirModelo"]) && ($id == $_POST["modelo"])) echo "selected" ?>><?= $dispositivo["modelo"] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <input type="submit" name="elegirModelo" class="btn btn-primary" value="Elegir Modelo">
                </form>

                <!-- CAMBIAR STOCK -->
                <?php if (isset($_POST["elegirModelo"])) : ?>
                    <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" class="border border-primary p-2 mb-3 rounded" name="formulario">
                        <legend class="text-center header">Modelo elegido<?= " " . $dispositivos[$_POST["modelo"]]["modelo"] ?></legend>
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="idModelo" value="<?= $_POST["modelo"] ?>">
                            <label for="numero">Número de stock:</label>
                            <input type="number" class="form-control" name="stockDispositivo" value="<?= $dispositivos[$_POST["modelo"]]["stock"] ?>">
                        </div>
                        <input type="submit" name="updateStock" class="btn btn-primary" value="Modificar Stock">
                    </form>
                <?php endif; ?>

                <!-- ELEGIR DISPOSITIVO PARA INSERTAR -->
                <!-- HABRÁ 2 FORMS EN FUNCIÓN DE LA ELECCIÓN -->
                <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" class="border border-primary p-2 mb- rounded" name="formulario">
                    <legend class="text-center header">Insertar dispositivo</legend>
                    <div class="form-group">
                        <select name="tipoDispositivo" class="form-control">
                            <option value="movil" <?php if (isset($_POST["submitTipoDisp"]) && ($_POST["tipoDispositivo"] == "movil")) echo "selected" ?>>
                                Móvil
                            </option>
                            <option value="reloj" <?php if (isset($_POST["submitTipoDisp"]) && ($_POST["tipoDispositivo"] == "reloj")) echo "selected" ?>>
                                Reloj
                            </option>
                        </select>
                    </div>
                    <input type="submit" name="submitTipoDisp" class="btn btn-primary" value="Elegir categoría">
                </form>


                <!-- INSERTAR MOVIL A LA BASE DE DATOS -->
                <?php if (isset($_POST["submitTipoDisp"]) && $_POST["tipoDispositivo"] == "movil") : ?>
                    <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" enctype="multipart/form-data" class="border border-primary p-2 mb-3 rounded">
                        <legend class="text-center header">Insertar caracterísiticas del teléfono</legend>
                        <div class="form-group">
                            <label for="modelo">Modelo:</label>
                            <input type="text" class="form-control" name="modelo" required>
                            <label for="precio">Precio:</label>
                            <input type="number" class="form-control" name="precio" step="any" min="0" required>
                        </div>
                        <div class="form-group">
                            <label for="gama">Gama:</label>
                            <select name="gama" class="form-control">
                                <option value="alta">Alta</option>
                                <option value="media">Media</option>
                                <option value="baja">Baja</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="año">Año de lanzamiento:</label>
                            <input type="number" class="form-control" name="anio">
                            <label for="ram">RAM:</label>
                            <input type="text" class="form-control" name="ram">
                            <label for="Almacenamiento">Almacenamiento:</label>
                            <input type="number" class="form-control" name="almacenamiento">
                            <label for="procesador">Procesador:</label>
                            <input type="text" class="form-control" name="procesador">
                            <label for="bateria">Batería:</label>
                            <input type="number" class="form-control" name="bateria">
                            <label for="pulgadas">Pulgadas:</label>
                            <input type="number" class="form-control" name="pulgadas" step="any">
                            <label for="camara">Mpx:</label>
                            <input type="number" class="form-control" name="camara" step="any">
                        </div>
                        <form-group>
                            <label for="notch">Notch:</label>
                            <select name="notch" class="form-control">
                                <option value="1">Si</option>
                                <option value="0">No</option>
                            </select>
                        </form-group>
                        <input type="file" name="imagen" class="btn btn-secondary mt-2">
                        <input type="submit" name="insertarMovil" value="Insertar Móvil" class="btn btn-success">
                    </form>
                <?php endif; ?>
                <!-- INSERTAR RELOJ A LA BASE DE DATOS -->
                <?php if (isset($_POST["submitTipoDisp"]) && $_POST["tipoDispositivo"] == "reloj") : ?>
                    <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" enctype="multipart/form-data" class="border border-primary p-2 mb-3 rounded">
                        <legend class="text-center header">Insertar caracterísiticas del reloj</legend>
                        <div class="form-group">
                            <label for="modelo">Modelo:</label>
                            <input type="text" class="form-control" name="modelo" required>
                            <label for="precio">Precio:</label>
                            <input type="number" class="form-control" name="precio" step="any" min="0" required>
                        </div>
                        <div class="form-group">
                            <label for="gama">Gama:</label>
                            <select name="gama" class="form-control">
                                <option value="alta">Alta</option>
                                <option value="media">Media</option>
                                <option value="baja">Baja</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="año">Año de lanzamiento:</label>
                            <input type="number" class="form-control" name="anio">
                            <label for="ram">RAM:</label>
                            <input type="text" class="form-control" name="ram">
                            <label for="Almacenamiento">Almacenamiento:</label>
                            <input type="number" class="form-control" name="almacenamiento">
                            <label for="procesador">Procesador:</label>
                            <input type="text" class="form-control" name="procesador">
                            <label for="bateria">Batería:</label>
                            <input type="number" class="form-control" name="bateria">
                            <label for="pulgadas">Pulgadas:</label>
                            <input type="number" class="form-control" name="pulgadas" step="any">

                        </div>
                        <form-group>
                            <label for="sim">SIM:</label>
                            <select name="sim" class="form-control">
                                <option value="1">Si</option>
                                <option value="0">No</option>
                            </select>
                        </form-group>
                        <input type="file" name="imagen" class="btn btn-secondary mt-2">
                        <input type="submit" name="insertarReloj" value="Insertar Reloj" class="btn btn-success">
                    </form>
                <?php endif; ?>
                <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" class="border border-primary p-2 mt-3 rounded">
                    <legend class="text-center header">Borrar dispositivo</legend>
                    <select name="modelo" class="form-control">
                        <?php
                        $dispositivos = getDispositivos();
                        foreach ($dispositivos as $id => $dispositivo) : ?>
                            <option value="<?= $id ?>" <?php if (isset($_POST["elegirModelo"]) && ($id == $_POST["modelo"])) echo "selected" ?>><?= $dispositivo["modelo"] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="submit" name="borrar" value="Borrar Modelo" class="btn btn-danger mt-2">
                </form>
                <?= $mensajeError ?>
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