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
            if (addMovil($_POST["modelo"], $_POST["precio"], $_POST["gama"], $_POST["anio"], $_POST["ram"], $_POST["almacenamiento"],
                $_POST["procesador"], $_POST["bateria"], $_POST["pulgadas"], $targetFile, $_POST["camara"], $_POST["notch"]))
                $mensajeError .= "Movil añadido con éxito";
        }
    } catch (Exception $e) {
        $mensajeError .= $e->getMessage();
    }
}
if (isset($_POST["insertarReloj"]) && $_POST["modelo"] && $_POST["precio"]) {
    try {
        // TODO: AÑADIR IMAGEN DE RELOJES
        if (addReloj($_POST["modelo"], $_POST["precio"], $_POST["gama"], $_POST["anio"], $_POST["ram"], $_POST["almacenamiento"],
            $_POST["procesador"], $_POST["bateria"], $_POST["pulgadas"], $_POST["sim"]))
            $mensajeError .= "Reloj añadido con éxito";
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
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Borrar-Insertar</title>
</head>
<body>
<a href="perfil.php"><input type="button" value="Volver"></a>
<!-- ELEGIR MODELO PARA CAMBIAR EL STOCK -->
<h2>Modificar</h2>
<form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
    <select name="modelo">
        <?php
        $dispositivos = getDispositivos();
        foreach ($dispositivos as $id => $dispositivo) : ?>
            <option value="<?= $id ?>" <?php if (isset($_POST["elegirModelo"]) && ($id == $_POST["modelo"])) echo "selected" ?>><?= $dispositivo["modelo"] ?></option>
        <?php endforeach; ?>
    </select>
    <input type="submit" name="elegirModelo" value="Elegir Modelo">
</form>
<!-- CAMBIAR STOCK -->
<?php if (isset($_POST["elegirModelo"])): ?>
    <h3>Modelo elegido <?= $dispositivos[$_POST["modelo"]]["modelo"] ?></h3>
    <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
        <input type="hidden" name="idModelo" value="<?= $_POST["modelo"] ?>">
        <input type="number" name="stockDispositivo" value="<?= $dispositivos[$_POST["modelo"]]["stock"] ?>">
        <input type="submit" name="updateStock" value="Modificar Stock">
    </form>
<?php endif; ?>

<!-- ELEGIR DISPOSITIVO PARA INSERTAR -->
<!-- HABRÁ 2 FORMS EN FUNCIÓN DE LA ELECCIÓN -->
<h2>Insertar</h2>
<form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
    <select name="tipoDispositivo">
        <option value="movil"<?php if (isset($_POST["submitTipoDisp"]) && ($_POST["tipoDispositivo"] == "movil")) echo "selected" ?>>
            Móvil
        </option>
        <option value="reloj"<?php if (isset($_POST["submitTipoDisp"]) && ($_POST["tipoDispositivo"] == "reloj")) echo "selected" ?>>
            Reloj
        </option>
    </select>
    <input type="submit" name="submitTipoDisp" value="Elegir">
</form>
<!-- INSERTAR MOVIL A LA BASE DE DATOS -->
<?php if (isset($_POST["submitTipoDisp"]) && $_POST["tipoDispositivo"] == "movil"): ?>
    <h2>Insertar Características del Móvil</h2>
    <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" enctype="multipart/form-data">
        Modelo<input type="text" name="modelo" required>
        Precio<input type="number" name="precio" step="any" min="0" required>
        Gama<select name="gama">
            <option value="alta">Alta</option>
            <option value="media">Media</option>
            <option value="baja">Baja</option>
        </select>
        Año de lanzamiento<input type="number" name="anio">
        RAM<input type="text" name="ram">
        Almacenamiento<input type="number" name="almacenamiento">
        Procesador<input type="text" name="procesador">
        Batería<input type="number" name="bateria">
        Pulgadas pantalla<input type="number" name="pulgadas" step="any">
        Cámara <input type="number" name="camara" step="any">
        Notch<select name="notch">
            <option value="1">Si</option>
            <option value="0">No</option>
        </select>
        <input type="file" name="imagen">
        <input type="submit" name="insertarMovil" value="Insertar Móvil">
    </form>
<?php endif; ?>
<!-- INSERTAR RELOJ A LA BASE DE DATOS -->
<?php if (isset($_POST["submitTipoDisp"]) && $_POST["tipoDispositivo"] == "reloj"): ?>
    <h2>Insertar Características del Reloj</h2>
    <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
        Modelo<input type="text" name="modelo" required>
        Precio<input type="number" name="precio" step="any" min="0" required>
        Gama<select name="gama">
            <option value="alta">Alta</option>
            <option value="media">Media</option>
            <option value="baja">Baja</option>
        </select>
        Año de lanzamiento<input type="number" name="anio" min="0">
        RAM<input type="text" name="ram">
        Almacenamiento<input type="number" name="almacenamiento" min="0">
        Procesador<input type="text" name="procesador">
        Batería<input type="number" name="bateria" min="0">
        Pulgadas pantalla<input type="number" name="pulgadas" step="any">
        SIM<select name="sim">
            <option value="1">Si</option>
            <option value="0">No</option>
        </select>
        <input type="submit" name="insertarReloj" value="Insertar Reloj">
    </form>
<?php endif; ?>
<?= $mensajeError ?>
</body>
</html>