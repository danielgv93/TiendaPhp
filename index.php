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
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
</head>
<body>
<?= $errorLogin ?> <!--RECOLOCAR-->
<form action="<?= $_SERVER["PHP_SELF"] ?>" method="post">
    <input type="text" name="usuario" placeholder="Introducir usuario" value="<?php if (isset($_POST["login"])) echo htmlEntities($_POST["usuario"], ENT_QUOTES); ?>">
    <input type="password" name="password" placeholder="Introducir contraseña">
    <input type="submit" name="login" value="Login">
</form>
<a href="registro.php"><input type="button" value="Registrarse"></a>
</body>
</html>
