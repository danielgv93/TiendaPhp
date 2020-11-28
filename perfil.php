<?php

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
    <link rel="stylesheet" href="/font-awesome-4.7.0/css/font-awesome.min.css">
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
                <a href="perfil.php">Bienvenido<img class="img-fluid ml-3 user" src="img/user.png" alt="Logo Corporativo"></a>
                <a href="index.php"><img class="img-fluid ml-3 logout" src="img/logout.svg" alt="Logout"></a>
            </form>
        </div>
    </nav>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-4">
                <legend>Configurar trastienda</legend>
                <a href="borrar_insertar.php"><img class="img-fluid stock" src="img/stock.svg" alt="Modificar Stock"></a>
            </div>
                <div class="col-4">
                    <legend>Cambiar el usuario</legend>
                    <a href="borrar_insertar.php"><img class="img-fluid stock" src="img/edit.png" alt="Modificar Stock"></a>
                </div>
        </div>
    </div>
</body>
<script src='https://code.jquery.com/jquery-3.2.1.slim.min.js' integrity='sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN' crossorigin='anonymous'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js' integrity='sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q' crossorigin='anonymous'></script>
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js' integrity='sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl' crossorigin='anonymous'></script>

</html>