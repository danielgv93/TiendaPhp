<?php
require_once "sql/queries.php";
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
<!--TODO: CREAR FUNCION PARA UPDATEAR-->
Modificar
<form action="<?= $_SERVER["PHP_SELF"] ?>" method="post">
    <select>
        <?php foreach (getDispositivos() as $dispositivo) : ?>
            <option value="<?= $dispositivo["id"] ?>"><?= $dispositivo["modelo"] ?></option>
        <?php endforeach; ?>
    </select>
    <input type="number" name="stockDispositivo">
    <input type="submit" name="update" value="Actualizar Stock">
</form>
Insertar
<form action="<?= $_SERVER["PHP_SELF"] ?>" method="post">
    <input type="text" name="Modelo">
    <input type="number" name="precio" step="any">
    <!--TODO: SEGUIR CON LOS INPUTS-->
</form>
</body>
</html>