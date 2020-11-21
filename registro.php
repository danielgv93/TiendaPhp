<?php
require_once "sql/queries.php";

$passRepetida = "";
$errorAddUser = "";
$camposSinIntroducir = "";

if (isset($_POST["register"])) {
    /* Comprobar si los dos campos de las contraseñas coinciden */
    if ($_POST["password"] === $_POST["passwordCheck"]) {
        /* Comprobar si estan rellenos todos los campos */
        if (isset($_POST["nombre"]) && isset($_POST["apellidos"]) && isset($_POST["email"])
                    && isset($_POST["usuario"]) && isset($_POST["password"])) {
            /* Añadir usuario y redireccionar */
            if (addUsuario($_POST["nombre"], $_POST["apellidos"], $_POST["email"], $_POST["usuario"], $_POST["password"])) {
                header("Location: index.php");
                exit();
            } else {
                $errorAddUser = "Error al introducir un usuario";
            }
        } else {
            $camposSinIntroducir = "Hay campos sin introducir";
        }
    } else {
        $passRepetida = "La contraseña no coincide";
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
    <title>Registro</title>
</head>
<body>
<a href="index.php"><input type="button" value="Volver al login"></a>
<form action="<?= $_SERVER["PHP_SELF"] ?>" method="post">
    <label>Nombre:
        <input type="text" name="nombre" required value="<?php if (isset($_POST["register"]) && isset($_POST["nombre"])) echo htmlEntities($_POST["nombre"], ENT_QUOTES); ?>">
    </label>
    <label>Apellidos:
        <input type="text" name="apellidos" required value="<?php if (isset($_POST["register"]) && isset($_POST["apellidos"])) echo htmlEntities($_POST["apellidos"], ENT_QUOTES); ?>">
    </label>
    <label>Email:
        <input type="email" name="email" required value="<?php if (isset($_POST["register"]) && isset($_POST["email"])) echo htmlEntities($_POST["email"], ENT_QUOTES); ?>">
    </label>
    <label>Usuario:
        <input type="text" name="usuario" required value="<?php if (isset($_POST["register"]) && isset($_POST["usuario"])) echo htmlEntities($_POST["usuario"], ENT_QUOTES); ?>">
    </label>
    <label>Contraseña:
        <input type="password" name="password" required>
    </label>
    <label>Repita la contraseña:
        <input type="password" name="passwordCheck" required>
    </label>
    <?= $passRepetida ?>
    <input type="submit" name="register" value="Registrarse">
</form>
</body>
</html>
