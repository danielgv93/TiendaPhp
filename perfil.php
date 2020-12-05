<?php
session_start();
require_once "sql/queries.php";
require_once "funciones.php";

$texto = "";

if (isset($_POST["updateFoto"])) {
    try {
        if (($targetFile = guardarImagenUsuario($_SESSION["visitante"]["usuario"], $_FILES["imagen"])) !== false) {
            if (!updateFotoUsuario($_SESSION["visitante"]["id"], $targetFile)) {
                $_SESSION["visitante"] = getUsuario($_SESSION["visitante"]["id"]);
                $texto = "Error al actualizar la foto!";
            }
        }
    } catch (Exception $e) {
        $texto = $e->getMessage();
    }
}

if (isset($_POST["modificarPerfil"])) {
    if (!empty($_POST["contraseña"])) {
        if (updateUsuario($_SESSION["visitante"]["id"], $_POST["nombre"], $_POST["apellidos"], $_POST["usuario"], $_POST["email"], $_POST["contraseña"])) {
            $_SESSION["visitante"] = getUsuario($_SESSION["visitante"]["id"]);
            $texto = "Datos actualizados con exito!";
        } else {
            $texto = "Error al actualizar usuario!";
        }
    } else {
        $texto = "Falta de escribir la contraseña!";
    }
}
?>
<!DOCTYPE html>
<html lang='es'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <title>P3 - Perfil</title>
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' integrity='sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm' crossorigin='anonymous'>
    <link rel="shorcut icon" href="img/iconTitle.png">
    <link rel="stylesheet" href="/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/perfil.css">
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
            <div class="row profile">
                <div class="col-md-3">
                    <div class="profile-sidebar <?php if($_SESSION["visitante"]["admin"]==1)echo "gold"; ?>">
                        <div class="profile-userpic">
                            <img src="<?= $_SESSION["visitante"]["foto_perfil"] ?>" class="img-responsive ml-5 imagenPerfil" alt="Foto perfil">
                            <!-- TODO: CAMBIAR FOTO PERFIL -->
                            <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?= $_SESSION["visitante"]["id"] ?>">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="imagen" id="customFileLang" lang="es">
                                    <label class="custom-file-label" for="customFileLang">Seleccionar Foto</label>
                                </div>
                                <button type="submit" name="updateFoto" class="btn btn-info mt-2 ml-5">Actualizar foto</button>
                            </form>
                        </div>
                        <div class="profile-usertitle">
                            <div class="profile-usertitle-name mr-4 <?php if($_SESSION["visitante"]["admin"]==1)echo "gold-user"; ?>">
                                <?= $_SESSION["visitante"]["nombre"] . " " . $_SESSION["visitante"]["apellidos"] ?>
                            </div>
                            <div class="profile-usertitle-job mr-4 mb-4 <?php if($_SESSION["visitante"]["admin"]==1)echo "gold-user"; ?>">
                                <?php
                                if ($_SESSION["visitante"]["admin"] == 1) {
                                    echo "Administrador";
                                } else {
                                    echo "Usuario";
                                }
                                ?>
                            </div>
                            <div class="profile-usertitle-name mr-4">
                                <a href="historial.php" class="historial ml-3 btn btn-warning">Historial de compras</a>
                            </div>
                        </div>
                        <?php if ($_SESSION["visitante"]["admin"] == 1) : ?>
                            <div class="profile-userpic">
                                <img src="img/modificarTienda.svg" class="img-responsive ml-5 imagenPerfil" alt="Foto perfil">
                            </div>
                            <div class="profile-usertitle">
                                <a href="borrar_insertar.php" class="modificar btn btn-info">Modificar tienda</a>
                            </div>
                        <?php endif ?>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="row py-5 p-4 bg-white rounded shadow-sm">
                        <div class="col-lg-12">
                            <div class="bg-light px-4 py-3 datos mb-5">
                                Datos personales
                            </div>
                            <form class="formulario" id="modificar-perfil" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" role="form">
                                <label for="nombre">Nombre:</label>
                                <div class="form-group">
                                    <i class="fas fa-signature d-inline"></i>
                                    <input class="form-control d-inline" type="text" name="nombre" id="nombre" readonly value="<?= $_SESSION["visitante"]["nombre"] ?>">
                                    <button type="button" onclick="function habilitar() {
                                        let nombre = document.getElementById('nombre');
                                        nombre.readOnly=!nombre.readOnly;
                                    }
                                    habilitar()" class="btn btn-info"> <i class="far fa-edit  d-inline"></i></button>
                                </div>
                                <label for="apellidos">Apellidos:</label>
                                <div class="form-group">
                                    <i class="fas fa-signature d-inline"></i>
                                    <input class="form-control d-inline" type="text" name="apellidos" id="apellidos" readonly value="<?= $_SESSION["visitante"]["apellidos"] ?>">
                                    <button type="button" onclick="function habilitar() {
                                        let apellidos = document.getElementById('apellidos');
                                        apellidos.readOnly=!apellidos.readOnly;
                                    }
                                    habilitar()" class="btn btn-info"> <i class="far fa-edit  d-inline"></i></button>
                                </div>
                                <label for="usuario">Usuario:</label>
                                <div class="form-group">
                                    <i class="fas fa-user d-inline"></i>
                                    <input class="form-control d-inline" type="text" name="usuario" id="usuario" readonly value="<?= $_SESSION["visitante"]["usuario"] ?>">
                                    <button type="button" onclick="function habilitar() {
                                        let usuario = document.getElementById('usuario');
                                        usuario.readOnly=!usuario.readOnly;
                                    }
                                    habilitar()" class="btn btn-info"> <i class="far fa-edit  d-inline"></i></button>
                                </div>
                                <label for="email">Email:</label>
                                <div class="form-group">
                                    <i class="fas fa-envelope d-inline"></i>
                                    <input class="form-control d-inline" type="text" name="email" id="email" readonly value="<?= $_SESSION["visitante"]["email"] ?>">
                                    <button type="button" onclick="function habilitar() {
                                        let apellidos = document.getElementById('email');
                                        email.readOnly=!email.readOnly;
                                    }
                                    habilitar()" class="btn btn-info"> <i class="far fa-edit  d-inline"></i></button>
                                </div>
                                <label for="contraseña">Contraseña:</label>
                                <div class="form-group">
                                    <i class="fas fa-lock d-inline"></i>
                                    <input class="form-control d-inline" type="password" name="contraseña" id="contraseña" readonly>
                                    <button type="button" onclick="function habilitar() {
                                        let contraseña = document.getElementById('contraseña');
                                        contraseña.readOnly=!contraseña.readOnly;
                                    }
                                    habilitar()" class="btn btn-info"> <i class="far fa-edit  d-inline"></i></button>
                                </div>
                                <input type="submit" name="modificarPerfil" class="btn btn-primary" value="Modificar datos">

                            </form>
                        </div>

                    </div>
                    <?php if (!empty($texto)) :  ?>
                        <div class='col-12 mt-3 alert alert-warning text-center' role='alert'><?= $texto ?></div>
                    <?php endif ?>
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
    let apellidos = document.getElementById("apellidos");
    let usuario = document.getElementById("usuario");
    let email = document.getElementById("email");
    let contraseña = document.getElementById("contraseña");
</script>

</html>