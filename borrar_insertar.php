<?php
require_once "sql/queries.php";

$stockUpdated = "";
$dispositivoAdded = "";
if (isset($_POST["updateStock"])) {
    try {
        updateStock($_POST["idModelo"], $_POST["stockDispositivo"]);
        $stockUpdated = "El stock se ha modificado a " . $_POST["stockDispositivo"] . " unidades";
    } catch (Exception $e) {
        $stockUpdated = $e->getMessage();
    }
}
if (isset($_POST["insertarMovil"])) {
    try {
        if (addMovil($_POST["modelo"], $_POST["precio"], $_POST["gama"], $_POST["anio"], $_POST["ram"], $_POST["almacenamiento"],
            $_POST["procesador"], $_POST["bateria"], $_POST["pulgadas"], $_POST["camara"], $_POST["notch"]))
        $dispositivoAdded = "Movil añadido con éxito";
    } catch (Exception $e) {
        $dispositivoAdded = $e->getMessage();
    }
}
if (isset($_POST["insertarReloj"])) {
    try {
        if (addReloj($_POST["modelo"], $_POST["precio"], $_POST["gama"], $_POST["anio"], $_POST["ram"], $_POST["almacenamiento"],
            $_POST["procesador"], $_POST["bateria"], $_POST["pulgadas"], $_POST["sim"]))
            $dispositivoAdded = "Reloj añadido con éxito";
    } catch (Exception $e) {
        $dispositivoAdded = $e->getMessage();
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

<?= $stockUpdated ?>
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
<?= $dispositivoAdded ?>
<!-- INSERTAR MOVIL A LA BASE DE DATOS -->
<?php if (isset($_POST["submitTipoDisp"]) && $_POST["tipoDispositivo"] == "movil"): ?>
    <h2>Insertar Características del Móvil</h2>
    <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
        Modelo<input type="text" name="modelo">
        Precio<input type="number" name="precio" step="any">
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
        <input type="submit" name="insertarMovil" value="Insertar Móvil">
    </form>
<?php endif; ?>
<!-- INSERTAR RELOJ A LA BASE DE DATOS -->
<?php if (isset($_POST["submitTipoDisp"]) && $_POST["tipoDispositivo"] == "reloj"): ?>
    <h2>Insertar Características del Reloj</h2>
    <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
        Modelo<input type="text" name="modelo">
        Precio<input type="number" name="precio" step="any">
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
        SIM<select name="sim">
            <option value="1">Si</option>
            <option value="0">No</option>
        </select>
        <input type="submit" name="insertarReloj" value="Insertar Reloj">
    </form>
<?php endif; ?>
</body>
</html>