<?php
require_once "sql/queries.php";

$errorLogin = "";
if (isset($_POST["login"])) {
    if (empty($_POST["usuario"]) || empty($_POST["password"])) {
        $errorLogin = "Introducir todos los campos";
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
    <title>Inicio de sesión</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a81368914c.js"></script>
    <link rel="stylesheet" href="registro.css">
    <link rel="shorcut icon" href="img/iconTitle.png">
    <script src="js/script.js"></script>
</head>

<body>
    <div class="container">
        <div class="img">
            <img src="img/logo.png">
        </div>
        <div class="login-content">
            <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
                <img src="https://img.icons8.com/cotton/64/000000/user-male-circle.png" />
                <h2 class="title">Bienvenido</h2>
                <div class="input-div one">
                    <div class="i">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="div">
                        <input type="text" name="usuario" placeholder="Usuario" class="form-control">
                    </div>
                </div>
                <div class="input-div pass">
                    <div class="i">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="div">
                        <input type="password" name="password" placeholder="Contraseña" class="form-control">
                    </div>
                </div>
                <a href="https://www.google.com/search?q=como+recuperar+contrase%C3%B1as+no+guardadas+en+google+chrome&rlz=1C1CHBF_esES857ES857&oq=como+rec&aqs=chrome.1.69i57j69i59j0l6.1949j0j4&sourceid=chrome&ie=UTF-8">He olvidado mi contraseña</a>
                <input type="submit" name="login" class="boton" value="ENTRAR">
            </form>
            <?php if (!empty($errorLogin) || !empty($camposSinIntroducir)) : ?>
                <div class='alert alert-danger mt-3 col-3 offset-5' role='alert'>
                    <?= $errorLogin ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>