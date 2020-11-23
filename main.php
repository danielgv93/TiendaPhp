<?php
require_once "sql/queries.php";



if (isset($_POST["buscar"])) {
    $arrayDispositivos = busqueda();
}


function busqueda()
{
    if (empty($_POST["busquedaInput"])) {
        $arrayDispositivos = getModelosBusqueda();
    } else {
        $busqueda = strtolower($_POST["busquedaInput"]);
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
    <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">

</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="main.php">
            <img src="img/logo.png" width="30" height="30" class="d-inline-block align-top">
            P3
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="main.php">Inicio <span class="sr-only"></span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="perfil.php">Perfil</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Categorías
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Teléfonos</a>
                        <a class="dropdown-item" href="#">Smartwaches</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Otra vaina</a>
                    </div>
                </li>

            </ul>
            <form method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" name="busquedaInput" type="search" placeholder="Buscar" aria-label="Search">
                <input type="submit" class="btn btn-primary btn-warning" name="buscar" id="buscar"> <span class="glyphicon glyphicon-stats"></span>

            </form>
        </div>
    </nav>
    <?php if (isset($_POST["buscar"])) : ?>
        <table>
            <?php foreach ($arrayDispositivos as $id => $producto) : ?>
                <tr>
                    <th><img src="<?= $producto["imagen"] ?>" style="width: 100px;"></th>
                </tr>
                <tr>
                    <td><?= $producto["modelo"] ?></td>
                </tr>
                <tr>
                    <td><?= $producto["precio"] ?> €</td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</body>
<script src='https://code.jquery.com/jquery-3.2.1.slim.min.js' integrity='sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN' crossorigin='anonymous'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js' integrity='sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q' crossorigin='anonymous'></script>
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js' integrity='sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl' crossorigin='anonymous'></script>

</html>