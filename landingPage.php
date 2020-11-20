<?php
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form action="<?= $_SERVER["PHP_SELF"] ?>" method="post">
    <input type="text" name="usuario" placeholder="Introducir usuario">
    <input type="text" name="password" placeholder="Introducir contraseña">
    <input type="submit" name="login" value="Login">
</form>
<a href="registro.php"><input type="button" value="Registrarse"></a>
</body>
</html>
