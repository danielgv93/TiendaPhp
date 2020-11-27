<?php
require_once "sql/queries.php";

$errorLogin = "";
if (isset($_POST["login"])) {
    if (empty($_POST["usuario"]) || empty($_POST["password"])) {
        $errorLogin = "Debes introducir todos los campos";
    } else {
        if (checkUsuarioPass($_POST["usuario"], $_POST["password"])) {
            header("Location: main.php");
            exit();
        } else {
            $errorLogin = "Error de login";
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
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
                    <div class="derecha">
                        <div class="info">
                            <header><img class="img-fluid ml-2 logo" src="img/logo.png" alt="Icon de user"></header>
                            <p class="slogan">Choose the best, choose P3</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="izquierda">
                        <form class="formulario text-center" id="register-form" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" role="form">
                            <header class="ml-4">Iniciar sesión</header>

                            <div class="form-group">
                                <i class="fas fa-user"></i>
                                <input class="caja" type="text" name="usuario" id="usuario" required placeholder="Usuario" value="<?php if ((isset($_POST["registro"]) || isset($_POST["login"])) && isset($_POST["usuario"])) echo htmlEntities($_POST["usuario"], ENT_QUOTES); ?>">
                            </div>

                            <div class="form-group">
                                <i class="fas fa-lock"></i>
                                <input class="caja" name="password" type="password" id="contraseña" placeholder="Contraseña" required>
                            </div>
                            <a href="https://www.google.com/search?q=como+recuperar+contrase%C3%B1as+no+guardadas+en+google+chrome&rlz=1C1CHBF_esES857ES857&oq=como+rec&aqs=chrome.1.69i57j69i59j0l6.1949j0j4&sourceid=chrome&ie=UTF-8">He olvidado mi contraseña</a>
                            <input type="submit" class="boton mt-2" value="ENTRAR">
                            <a href="registro.php"><input type="button" class="boton mt-2" value="CREAR CUENTA"></a>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
<?php if (!empty($errorLogin) || !empty($camposSinIntroducir)) : ?>
    <div class='alert alert-danger mt-3 col-3 offset-5' role='alert'>
        <?= $errorLogin ?>
    </div>
<?php endif; ?>

</html>