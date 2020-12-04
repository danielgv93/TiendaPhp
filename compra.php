<?php
require_once "sql/queries.php";
session_start();

$texto = "Compra realizada con éxito";
$icono = "success";
// INSERTAR COMPRA EN BBDD Y QUITAR STOCK DEL DISPOSITIVO

    for ($i = 0; $i < count($_POST["id"]); $i++) {
        if (($error = registrarCompra_RetirarStock($_SESSION["visitante"]["id"], $_POST["id"][$i], $_POST["cantidad"][$i])) !== true) {
            $texto = $error;
            $icono = "error";
            break;
        }
    }
unset($_SESSION["carrito"]);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <title>Cargando...</title>
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' integrity='sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm' crossorigin='anonymous'>
    <link rel="shorcut icon" href="img/iconTitle.png">
    <link rel="stylesheet" href="/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
    <link rel="stylesheet" href="css/main.css">

</head>
<body>
</body>
</html>
<script src='https://code.jquery.com/jquery-3.2.1.slim.min.js' integrity='sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN' crossorigin='anonymous'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js' integrity='sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q' crossorigin='anonymous'></script>
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js' integrity='sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl' crossorigin='anonymous'></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    function sleep(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }
    addEventListener("load", redirigir, false);
    async function redirigir() {
        Swal.fire({
            title: 'Se esta procesando su compra...',
            timer: 2000,
            icon: 'warning',
            showConfirmButton: false,
            backdrop: `rgba(0,0,123,0.4)`,
        })
        await sleep(2000);
        Swal.fire({
            title: '<?= $texto ?>',
            timer: 2000,
            icon: '<?= $icono ?>',
            backdrop: `rgba(0,0,123,0.4)`,
        });
        await sleep(2000);
        window.location.href = "main.php";
    }

</script>
