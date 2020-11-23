<?php
require_once "sql/queries.php";

$passRepetida = "";
$errorAddUser = "";
$camposSinIntroducir = "";
$errorLogin = "";
$correctAddUser = "";
if (isset($_POST["login"])) {
    if (checkUsuarioPass($_POST["usuario"], $_POST["contraseña"])) {
        header("Location: main.php");
        exit();
    } else {
        $errorLogin = "Usuario o contraseña incorrectos";
    }
}

if (isset($_POST["registro"])) {
    /* Comprobar si los dos campos de las contraseñas coinciden */
    if ($_POST["contraseña"] === $_POST["confirm-contraseña"]) {
        /* Comprobar si estan rellenos todos los campos */
        if (
            !empty($_POST["nombre"]) && !empty($_POST["apellidos"]) && !empty($_POST["email"])
            && !empty($_POST["usuario"]) && !empty($_POST["contraseña"])
        ) {
            /* Añadir usuario y redireccionar */
            if (addUsuario(
                $_POST["nombre"],
                $_POST["apellidos"],
                $_POST["email"],
                $_POST["usuario"],
                $_POST["contraseña"]
            ) === true) {
                $correctAddUser = "Usuario añadido correctamente!";
            } else {
                $errorAddUser = "El usuario ya existe";
            }
        } else {
            $camposSinIntroducir = "Hay campos sin introducir";
        }
    } else {
        $passRepetida = "Las contraseñas deben de ser iguales";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <link rel="stylesheet" href="css/estilo.css">
    <script src="js/script.js"></script>
    <link rel="shorcut icon" href="img/logo.png"
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card border-danger mb-3" style="width:32rem;">
                    <img class="card-img-top" src="img/logo3.jpg" alt="Card image cap">
                    <div class="card-body text-primary">
                        <h4 class="card-title">Conócenos</h4>
                        <p class="card-text">Tu tienda de informática online, y cada vez la de más gente. Precios imbatibles y calidad superior!</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-md-offset-2">
                <div class="panel panel-login">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-6">
                                <a href="#" class="active" id="login-form-link">Iniciar sesión</a>
                            </div>
                            <div class="col-xs-6">
                                <a href="#" id="register-form-link">Regístrate ahora</a>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <form id="login-form" action="<?= $_SERVER["PHP_SELF"] ?>" method="post" role="form" style="display: block;" >

                                    <div class="form-group">
                                        <input type="text" name="usuario" id="usuario" tabindex="1" class="form-control" placeholder="Usuario" value="<?php if ((isset($_POST["registro"]) || isset($_POST["login"])) && isset($_POST["usuario"])) echo htmlEntities($_POST["usuario"], ENT_QUOTES); ?>">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="contraseña" id="contraseña" tabindex="2" class="form-control" placeholder="Contraseña">
                                    </div>
                                    <div class="form-group text-center">
                                        <input type="checkbox" tabindex="3" class="" name="recordar" id="recordar">
                                        <label for="recordar"> Recordarme</label>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6 col-sm-offset-3">
                                                <input type="submit" name="login" id="login" tabindex="4" class="form-control btn btn-login" value="Iniciar sesión">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="text-center">
                                                    <a href="https://www.google.com/search?q=como+recuperar+contrase%C3%B1as+no+guardadas+en+google+chrome&rlz=1C1CHBF_esES857ES857&oq=como+&aqs=chrome.1.69i57j0i67j0i433j0l2j69i65j69i60l2.2247j0j4&sourceid=chrome&ie=UTF-8" target="blank" tabindex="5" class="olvido-contraseña">¿Has olvidado
                                                        tu contraseña?</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <form id="register-form" action="<?= $_SERVER["PHP_SELF"] ?>" method="post" role="form" style="display: none;">
                                    <div class="form-group">
                                        <input type="text" name="nombre" id="usuario" tabindex="1" class="form-control" placeholder="Nombre" required value="<?php if (isset($_POST["registro"]) && isset($_POST["nombre"])) echo htmlEntities($_POST["nombre"], ENT_QUOTES); ?>">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="apellidos" id="apellidos" tabindex="1" class="form-control" placeholder="Apellidos" required value="<?php if (isset($_POST["registro"]) && isset($_POST["apellidos"])) echo htmlEntities($_POST["apellidos"], ENT_QUOTES); ?>">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="usuario" id="usuario" tabindex="1" class="form-control" placeholder="Usuario" required value="<?php if (isset($_POST["registro"]) && isset($_POST["usuario"])) echo htmlEntities($_POST["usuario"], ENT_QUOTES); ?>">
                                    </div>
                                    <div class="form-group">
                                        <input type="email" name="email" id="email" tabindex="1" class="form-control" placeholder="Correo electronico" required value="<?php if (isset($_POST["registro"]) && isset($_POST["email"])) echo htmlEntities($_POST["email"], ENT_QUOTES); ?>">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="contraseña" id="contraseña" tabindex="2" class="form-control" placeholder="Contraseña" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="confirm-contraseña" id="confirm-contraseña" tabindex="2" class="form-control" placeholder="Confirmar contraseña" required>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6 col-sm-offset-3">
                                                <input type="submit" name="registro" id="registro" tabindex="4" class="form-control btn btn-register mb-2" value="Crear cuenta">
                                            </div>
                                        </div>
                                    </div>
                                    <?php if (!empty($errorLogin)) : ?>
                                        <div class='alert alert-danger mt-3 col-3 offset-5' role='alert'>
                                            <?= $errorLogin ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($correctAddUser)) : ?>
                                        <div class='alert alert-success mt-2 col-3 offset-5' role='alert'>
                                            <?= $correctAddUser ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($errorAddUser)) : ?>
                                        <div class='alert alert-danger mt-2 col-3 offset-5' role='alert'>
                                            <?= $errorAddUser ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($passRepetida)) : ?>
                                        <div class='alert alert-danger mt-3 col-3 offset-5' role='alert'>
                                            <?= $passRepetida ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($camposSinIntroducir)) : ?>
                                        <div class='alert alert-danger mt-3 col-3 offset-5' role='alert'>
                                            <?= $camposSinIntroducir ?>
                                        </div>
                                    <?php endif; ?>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid bg-primary navbar navbar-fixed-bottom" >
        <div class="row align-items-end">
            <div class="col-12  text-white text-center">
                <footer>
                    <p>&trade; TODOS LOS DERECHOS RESERVADOS</p>
                    <p><a href="http://web2.iesmiguelherrero.com/" class="alert-link" target="blank" style="color:white;">IES Miguel Herrero</a> </p>
                    <p>P3 &copy; 2020</p>
                </footer>
            </div>
        </div>
    </div>
</body>
</html>