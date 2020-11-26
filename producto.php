<?php
require_once "sql/queries.php";
if (isset($_GET["ficha"])) {
    $idSelected = $_GET["id"];
    list($ficha, $tipo) = getFicha($idSelected);
    $ficha = $ficha[$idSelected];
}
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $ficha["modelo"] ?></title>
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css'
          integrity='sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm' crossorigin='anonymous'>
    <link rel="shorcut icon" href="img/logo.png">
    <link rel="stylesheet" href="/font-awesome-4.7.0/css/font-awesome.min.css">
</head>
<body>
<a href="main.php"><input type="button" value="VOLVER"></a>
<table>
    <tr>
        <th><img src="<?= $ficha["imagen"] ?>" style="width: 300px;"></th>
    </tr>
    <tr>
        <td>Nombre: <?= $ficha["modelo"] ?></td>
    </tr>
    <tr>
        <td>Precio: <?= $ficha["precio"] ?> €</td>
    </tr>
    <tr>
        <td>Gama: <?= $ficha["gama"] ?></td>
    </tr>
    <tr>
        <td>Procesador: <?= $ficha["procesador"] ?></td>
    </tr>
    <tr>
        <td>Bateria: <?= $ficha["bateria"] ?> mAh</td>
    </tr>
    <tr>
        <td><?= $ficha["pulgadas"] ?> pulgadas</td>
    </tr>
    <tr>
        <td><?= $ficha["stock"] ?> unidades en stock</td>
    </tr>
    <?php if ($tipo == "movil") : ?>
    <tr>
        <td><?= $ficha["camara"] ?> Mpx</td>
    </tr>
    <tr>
        <td>Tiene notch: <?php if($ficha["notch"]){
                echo "Si";
            } else {
                echo "No";
            }  ?></td>
    </tr>
    <?php endif; ?>
    <?php if ($tipo == "reloj") : ?>
        <tr>
            <td>Tarjeta SIM: <?php if($ficha["sim"]){
                    echo "Si";
                } else {
                echo "No";
                }  ?></td>
        </tr>
    <?php endif; ?>
</table>
</body>
<script src='https://code.jquery.com/jquery-3.2.1.slim.min.js'
        integrity='sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN'
        crossorigin='anonymous'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js'
        integrity='sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q'
        crossorigin='anonymous'></script>
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js'
        integrity='sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl'
        crossorigin='anonymous'></script>
</html>
