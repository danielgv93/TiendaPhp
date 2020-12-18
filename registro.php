<?php
require_once "classes/Database.php";

$textoError = "";

if (isset($_POST["registro"])) {
    if (isset($_POST["check_1"])) {
        /* Comprobar si los dos campos de las contraseñas coinciden */
        if ($_POST["contraseña"] === $_POST["confirm-contraseña"]) {
            /* Comprobar si estan rellenos todos los campos */
            if (
                !empty($_POST["nombre"]) && !empty($_POST["apellidos"]) && !empty($_POST["email"])
                && !empty($_POST["usuario"]) && !empty($_POST["contraseña"])
            ) {
                /* Añadir usuario y redireccionar */
                if (Database::getInstance()->addUsuario(new Usuario(1,$_POST["usuario"], $_POST["contraseña"], $_POST["nombre"], $_POST["apellidos"], $_POST["email"], "", 0))) {
                    header("Location: index.php");
                    exit();
                } else {
                    $textoError = "El usuario ya existe!";
                }
            } else {
                $textoError = "Hay campos sin introducir!";
            }
        } else {
            $textoError = "Las contraseñas deben de ser iguales!";
        }
    } else {
        $textoError = "Acepte la politica de privacidad antes!";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset='UTF-8'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <title>Registro</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="shorcut icon" href="img/iconTitle.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container">
        <div class="registro">
            <div class="row">
                <div class="col-md-6">
                    <div class="izquierda">
                        <form class="formulario text-center" id="register-form" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" role="form">
                            <header class="ml-4">Crear nueva cuenta</header>

                            <div class="form-group">
                                <i class="fas fa-signature"></i>
                                <input class="caja" type="text" name="nombre" id="nombre" placeholder="Nombre" required value="<?php if (isset($_POST["registro"]) && isset($_POST["nombre"])) echo htmlEntities($_POST["nombre"], ENT_QUOTES); ?>">
                            </div>

                            <div class="form-group">
                                <i class="fas fa-signature"></i>
                                <input class="caja" type="text" name="apellidos" id="apellidos" placeholder="Apellidos" required value="<?php if (isset($_POST["registro"]) && isset($_POST["apellidos"])) echo htmlEntities($_POST["apellidos"], ENT_QUOTES); ?>">
                            </div>

                            <div class="form-group">
                                <i class="fas fa-user"></i>
                                <input class="caja" type="text" name="usuario" id="usuario" required placeholder="Usuario" value="<?php if ((isset($_POST["registro"]) || isset($_POST["login"])) && isset($_POST["usuario"])) echo htmlEntities($_POST["usuario"], ENT_QUOTES); ?>">
                            </div>

                            <div class="form-group">
                                <i class="fas fa-envelope"></i>
                                <input class="caja" type="text" name="email" id="email" placeholder="Email" required value="<?php if (isset($_POST["registro"]) && isset($_POST["email"])) echo htmlEntities($_POST["email"], ENT_QUOTES); ?>">
                            </div>

                            <div class="form-group">
                                <i class="fas fa-lock"></i>
                                <input class="caja" type="password" name="contraseña" id="contraseña" placeholder="Contraseña" required>
                            </div>

                            <div class="form-group">
                                <i class="fas fa-check-circle"></i>
                                <input class="caja" type="password" name="confirm-contraseña" id="contraseña2" placeholder="Confimar contraseña" required>
                            </div>

                            <div class="form-group">
                                <label>
                                    <input id="check_1" name="check_1" type="checkbox" required><small>He leído y acepto la política de privacidad</small></input>
                                    <div class="invalid-feedback">Debes rellenar todos los campos</div>
                                </label>
                            </div>

                            <input type="submit" name="registro" class="boton" value="CREAR CUENTA">

                            <a href="index.php"><button class="boton">VOLVER</button> </a>

                        </form>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="derecha">
                        <div class="info">
                            <header><img class="img-fluid ml-5" src="img/logo.png" alt="Logo corporativo"></header>
                            <p class="resumen">Tu tienda de informática online, y cada día la de más gente!
                                Calidad superior a precios imbatibles
                            </p>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row alerta">
                <?php if (!empty($textoError)) : ?>
                    <div class='col-12 mt-3 alert alert-danger text-center' role='alert'>
                        <?= $textoError ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
 

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>

</html>