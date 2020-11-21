<?php
require_once "sql/queries.php";

$errorLogin = "";
if (isset($_POST["login"])) {
    if (checkUsuarioPass($_POST["usuario"], $_POST["password"])) {
        header("Location: main.php");
        exit();
    } else {
        $errorLogin = "Error de login";
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
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <img src="img/logo3.jpg" alt="">
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
                                <form id="login-form" action="#" method="post" role="form" style="display: block;">

                                    <div class="form-group">
                                        <input type="text" name="usuario" id="usuario" tabindex="1" class="form-control" placeholder="Usuario" value="<?php if (isset($_POST["register"]) && isset($_POST["usuario"])) echo htmlEntities($_POST["usuario"], ENT_QUOTES); ?>">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="contraseña" id="contraseña" tabindex="2" class="form-control" placeholder="Contraseña">
                                    </div>
                                    <div class="form-group text-center">
                                        <input type="checkbox" tabindex="3" class="" name="recordar" id="recordar">
                                        <label for="recordar">Recordarme</label>
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
                                                    <a href="https://www.google.com/search?q=como+recuperar+contrase%C3%B1as+no+guardadas+en+google+chrome&rlz=1C1CHBF_esES857ES857&oq=como+&aqs=chrome.1.69i57j0i67j0i433j0l2j69i65j69i60l2.2247j0j4&sourceid=chrome&ie=UTF-8" target="blank" tabindex="5" class="olvido-contraseña">¿Has olvidado tu contraseña?</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <form id="register-form" action="#" method="post" role="form" style="display: none;">
                                    <div class="form-group">
                                        <input type="text" name="nombre" id="usuario" tabindex="1" class="form-control" placeholder="Nombre" value="<?php if (isset($_POST["registro"]) && isset($_POST["nombre"])) echo htmlEntities($_POST["nombre"], ENT_QUOTES); ?>">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="apellidos" id="apellidos" tabindex="2" class="form-control" placeholder="Apellidos" value="<?php if (isset($_POST["registro"]) && isset($_POST["apellidos"])) echo htmlEntities($_POST["apellidos"], ENT_QUOTES); ?>">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="usuario" id="usuario" tabindex="3" class="form-control" placeholder="Usuario" value="<?php if (isset($_POST["registro"]) && isset($_POST["usuario"])) echo htmlEntities($_POST["usuario"], ENT_QUOTES); ?>">
                                    </div>
                                    <div class="form-group">
                                        <input type="email" name="email" id="email" tabindex="4" class="form-control" placeholder="Correo electronico" value="<?php if (isset($_POST["registro"]) && isset($_POST["email"])) echo htmlEntities($_POST["email"], ENT_QUOTES); ?>">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="contraseña" id="contraseña" tabindex="5" class="form-control" placeholder="Contraseña">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="confirm-contraseña" id="confirm-contraseña" tabindex="6" class="form-control" placeholder="Confirmar contraseña">
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6 col-sm-offset-3">
                                                <input type="submit" name="registro" id="registro" tabindex="7" class="form-control btn btn-register mb-2" value="Crear cuenta">
                                                <?php
                                                require_once "funciones.php";
                                                if (isset($_POST["registro"])) {
                                                    $usuario = $_POST["usuario"];
                                                    $contraseña = md5($_POST["contraseña"]);
                                                    $contraseña2 = md5($_POST["confirm-contraseña"]);

                                                    if (contraseñaCorrecta($contraseña, $contraseña2)) {
                                                        if (addUsuario($usuario, $contraseña)) {
                                                            echo "<div class='alert alert-success mt-2' role='alert'>";
                                                            echo "Usuario añadido correctamente!";
                                                            echo "</div>";
                                                        } else {
                                                            echo "<div class='alert alert-danger mt-2' role='alert'>";
                                                            echo "Error al registrarse!";
                                                            echo "</div>";
                                                        }
                                                    } else {
                                                        echo "<div class='alert alert-danger mt-3' role='alert'>";
                                                        echo "Las contraseñas no coinciden!";
                                                        echo "</div>";
                                                    }
                                                };
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>