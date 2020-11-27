<?php
require_once "sql/queries.php";

$passRepetida = "";
$errorAddUser = "";
$camposSinIntroducir = "";
$errorLogin = "";
$correctAddUser = "";
if (isset($_POST["login"])) {
    if (checkUsuarioPass($_POST["usuario"], $_POST["contraseña"])) {
        header("Location: index.php");
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
<html>

<head>
    <title>Registro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
    <link rel="stylesheet" href="style.css">
    <link rel="shorcut icon" href="img/iconTitle.png">
</head>

<body>
    <div class="container">
        <div class="registro">
            <div class="row">
                <div class="col-md-6">
                    <div class="izquierda">
                        <form class="formulario text-center" id="register-form" action="<?= $_SERVER["PHP_SELF"] ?>" method="post" role="form">
                            <header class="ml-4">Crear nueva cuenta</header>

                            <div class="form-group">
                                <i class="fas fa-signature"></i>
                                <input class="caja" type="text" name="nombre" id="nombre" placeholder="Nombre" required value="<?php if (isset($_POST["registro"]) && isset($_POST["nombre"])) echo htmlEntities($_POST["nombre"], ENT_QUOTES); ?>">
                            </div>

                            <div class="form-group">
                                <i class="fas fa-user"></i>
                                <input class="caja" type="text" name="usuario" id="usuario" required placeholder="Usuario" value="<?php if ((isset($_POST["registro"]) || isset($_POST["login"])) && isset($_POST["usuario"])) echo htmlEntities($_POST["usuario"], ENT_QUOTES); ?>">
                            </div>

                            <div class="form-group">
                                <i class="fas fa-envelope"></i>
                                <input class="caja" type="text" id="email" placeholder="Email" required value="<?php if (isset($_POST["registro"]) && isset($_POST["email"])) echo htmlEntities($_POST["email"], ENT_QUOTES); ?>">
                            </div>

                            <div class="form-group">
                                <i class="fas fa-lock"></i>
                                <input class="caja" type="password" id="contraseña" placeholder="Contraseña" required>
                            </div>

                            <div class="form-group">
                                <i class="fas fa-check-circle"></i>
                                <input class="caja" type="password" id="contraseña2" placeholder="Confimar contraseña" required>
                            </div>

                            <div class="form-group">
                                <label>
                                    <input id="check_1" name="check_1" type="checkbox" required><small> He leído y acepto la política de privacidad</small></input>
                                    <div class="invalid-feedback">Debes rellenar todos los campos</div>
                                </label>
                            </div>

                            <input type="submit" class="boton" value="CREAR CUENTA ">

                        </form>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="derecha">
                        <div class="info">
                            <header><img class="img-fluid ml-5" src="img/logo.png" alt="Logo corporativo"></header>
                            <p>Tu tienda de informática online, y cada día la de más gente!
                                Calidad superior a precios imbatibles
                            </p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>

</html>

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