<?php
require_once "sql/Conexion.php";

/**
 * Añade un usuario de tipo normal a la base de datos. Comprueba primero si existe un nombre de usuario igual en la BBDD.
 * Devuelve true si consigue insertar el usuario y falso junto con la excepción si no se inserta.
 * @param $nombre String de 20 caracteres como maximo con el nombre real del usuario.
 * @param $apellidos String de 50 caracteres como maximo con los apellidos del usuario.
 * @param $email String con el email del usuario.
 * @param $usuario String con el nickname o username del usuario.
 * @param $password String de 50 caracteres como maximo con la contraseña del usuario
 * @return bool
 */
function addUsuario($nombre, $apellidos, $email, $usuario, $password)
{
    $conexion = getConexionPDO();
    try {
        if (!checkUsuario($usuario)) {
            $sql = "INSERT INTO usuarios (usuario, pass, nombre, apellidos, email) VALUES (?, MD5(?), ?, ?, ?);";
            $consulta = $conexion->prepare($sql);
            $consulta->bindParam(1, $usuario);
            $consulta->bindParam(2, $password);
            $consulta->bindParam(3, $nombre);
            $consulta->bindParam(4, $apellidos);
            $consulta->bindParam(5, $email);
            if ($consulta->execute()) {
                unset($conexion);
                return true;
            } else {
                throw new Exception("Error al insertar usuario");
            }
        } else {
            throw new Exception("El usuario ya existe");
        }
    } catch (Exception $e) {
        unset($conexion);
        return false;
    }

}

/**
 * Comprueba si un usuario es Administrador a partir de un nombre de usuario y contraseña
 * @param $usuario
 * @param $password
 * @return int 0 si es normal, 1 si es administrador
 */
function isAdmin($usuario, $password)
{
    $conexion = getConexionPDO();
    $sql = "SELECT admin from usuarios where usuario = ? AND pass = MD5(?)";
    $consulta = $conexion->prepare($sql);
    $consulta->bindParam(1, $usuario);
    $consulta->bindParam(2, $password);
    $consulta->execute();
    $fila = $consulta->fetch();
    unset($conexion);
    return $fila["admin"];
}

function checkUsuario($usuario)
{
    $conexion = getConexionPDO();
    $sql = "SELECT usuario from usuarios where usuario = ?";
    $consulta = $conexion->prepare($sql);
    $consulta->bindParam(1, $usuario);
    if ($consulta->execute()) {
        while ($fila = $consulta->fetch()) {
            $datos[] = array("usuario" => $fila['usuario']);
        }
    }
    if (isset($datos)) {
        return count($datos);
    } else {
        return 0;
    }
}

function checkUsuarioPass($usuario, $password)
{
    $conexion = getConexionPDO();
    $sql = "SELECT usuario, pass from usuarios where usuario = ? AND pass = MD5(?)";
    $consulta = $conexion->prepare($sql);
    $consulta->bindParam(1, $usuario);
    $consulta->bindParam(2, $password);
    if ($consulta->execute()) {
        while ($fila = $consulta->fetch()) {
            $datos[] = array("usuario" => $fila['usuario'], "password" => $fila['password']);
        }
    }
    if (isset($datos)) {
        return count($datos);
    } else {
        return 0;
    }
}

function getDispositivos()
{
    $conexion = getConexionPDO();
    $sql = "SELECT * from dispositivos;";
    $resultado = $conexion->query($sql);
    $resultado->bindColumn(1, $id);
    $resultado->bindColumn(2, $modelo);
    $resultado->bindColumn(3, $precio);
    $resultado->bindColumn(4, $gama);
    $resultado->bindColumn(5, $anio);
    $resultado->bindColumn(6, $ram);
    $resultado->bindColumn(7, $almacenamiento);
    $resultado->bindColumn(8, $procesador);
    $resultado->bindColumn(9, $bateria);
    $resultado->bindColumn(10, $pulgadas);
    $resultado->bindColumn(11, $stock);
    while ($resultado->fetch(PDO::FETCH_BOUND)) {
        $datos[$id] = array("modelo" => $modelo, "precio" => $precio, "gama" => $gama, "anio" => $anio,
            "ram" => $ram, "almacenamiento" => $almacenamiento, "procesador" => $procesador, "bateria" => $bateria,
            "pulgadas" => $pulgadas, "stock" => $stock);
    }
    return $datos;
}

function getModelosBusqueda()
{
    /*TODO: INTRODUCIR UN PARAMETRO DE BUSQUEDA DENTRO DE LA QUERY, EN LUGAR DE EN EL CODIGO CON LIKE %x%*/
    $conexion = getConexionPDO();
    $sql = "SELECT id_dispositivo, imagen, modelo, precio from dispositivos;";
    $resultado = $conexion->query($sql);
    $resultado->bindColumn(1, $id);
    $resultado->bindColumn(2, $imagen);
    $resultado->bindColumn(3, $modelo);
    $resultado->bindColumn(4, $precio);

    while ($resultado->fetch(PDO::FETCH_BOUND)) {
        $datos[$id] = array("imagen" => $imagen, "modelo" => $modelo, "precio" => $precio);
    }
    return $datos;
}

function getGamas()
{
    $conexion = getConexionPDO();
    $sql = "SELECT DISTINCT gama from dispositivos;";
    $resultado = $conexion->query($sql);
    $resultado->bindColumn(1, $gama);
    while ($resultado->fetch(PDO::FETCH_BOUND)) {
        $datos[] = $gama;
    }
    return $datos;
}

function updateStock($id, $stock)
{
    $conexion = getConexionPDO();
    $sql = "UPDATE dispositivos SET stock = ? WHERE id_dispositivo = ?;";
    $consulta = $conexion->prepare($sql);
    $consulta->bindParam(1, $stock);
    $consulta->bindParam(2, $id);
    if ($consulta->execute() != true) throw new Exception("No se ha podido actualizar el stock");
    unset($conexion);
    return true;

}

function addMovil($modelo, $precio, $gama, $anio, $ram, $almacenamiento, $procesador, $bateria, $pulgadas, $imagen,
                  $camara, $notch)
{
    $conexion = getConexionPDO();
    /* SE COMPRUEBA QUE NO HAY UN MISMO MODELO EN LA BASE DE DATOS */
    $sql = "SELECT COUNT(*) as iguales from dispositivos where modelo = ?;";
    $resultado = $conexion->prepare($sql);
    $resultado->bindParam(1, $modelo);
    $resultado->execute();
    $fila = $resultado->fetch();
    if ($fila["iguales"] != 0) {
        throw new Exception("Ya hay un modelo igual en la base de datos");
    }


    /* SE HACE INSERT CON TRANSACCIÓN EN dispositivos Y moviles */
    $conexion->beginTransaction();
    try {
        $sql = "INSERT INTO dispositivos (modelo, precio, gama, anio, ram, almacenamiento, procesador, bateria, pulgadas, imagen)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
        $insert = $conexion->prepare($sql);
        $insert->bindParam(1, $modelo);
        $insert->bindParam(2, $precio);
        $insert->bindParam(3, $gama);
        $insert->bindParam(4, $anio);
        $insert->bindParam(5, $ram);
        $insert->bindParam(6, $almacenamiento);
        $insert->bindParam(7, $procesador);
        $insert->bindParam(8, $bateria);
        $insert->bindParam(9, $pulgadas);
        $insert->bindParam(10, $imagen);
        if ($insert->execute() == false) {
            throw new Exception("Error al insertar el dispositivo");
        }
        $sql = "INSERT INTO moviles (id_movil, camara, notch) VALUES 
                    ((SELECT id_dispositivo from dispositivos order by id_dispositivo desc limit 1), ?, ?);";
        $insert = $conexion->prepare($sql);
        $insert->bindParam(1, $camara);
        $insert->bindParam(2, $notch);
        if ($insert->execute() == false) {
            throw new Exception("Error al insertar el movil");
        }
        $conexion->commit();
        unset($conexion);
        return true;
    } catch (Exception $e) {
        $conexion->rollBack();
        unset($conexion);
        return false;
    }
}

function addReloj($modelo, $precio, $gama, $anio, $ram, $almacenamiento, $procesador, $bateria, $pulgadas,
                  $sim)
{
    $conexion = getConexionPDO();
    /* SE COMPRUEBA QUE NO HAY UN MISMO MODELO EN LA BASE DE DATOS */
    $sql = "SELECT COUNT(*) as iguales from dispositivos where modelo = ?;";
    $resultado = $conexion->prepare($sql);
    $resultado->bindParam(1, $modelo);
    $resultado->execute();
    $fila = $resultado->fetch();
    if ($fila["iguales"] != 0) {
        throw new Exception("Ya hay un modelo igual en la base de datos");
    }
    /* SE HACE INSERT CON TRANSACCIÓN EN dispositivos Y relojes */
    $conexion->beginTransaction();
    try {
        $sql = "INSERT INTO dispositivos (modelo, precio, gama, anio, ram, almacenamiento, procesador, bateria, pulgadas)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";
        $insert = $conexion->prepare($sql);
        $insert->bindParam(1, $modelo);
        $insert->bindParam(2, $precio);
        $insert->bindParam(3, $gama);
        $insert->bindParam(4, $anio);
        $insert->bindParam(5, $ram);
        $insert->bindParam(6, $almacenamiento);
        $insert->bindParam(7, $procesador);
        $insert->bindParam(8, $bateria);
        $insert->bindParam(9, $pulgadas);
        if ($insert->execute() == false) {
            throw new Exception("Error al insertar el dispositivo");
        }
        $sql = "INSERT INTO relojes (id_reloj, sim) VALUES 
                    ((SELECT id_dispositivo from dispositivos order by id_dispositivo desc limit 1), ?);";
        $insert = $conexion->prepare($sql);
        $insert->bindParam(1, $sim);
        if ($insert->execute() == false) {
            throw new Exception("Error al insertar el reloj");
        }
        $conexion->commit();
        unset($conexion);
        return true;
    } catch (Exception $e) {
        $conexion->rollBack();
        unset($conexion);
        return false;
    }
}

function getMoviles()
{
    $conexion = getConexionPDO();
    $sql = "SELECT * from dispositivos d inner join moviles m on d.id_dispositivo = m.id_movil;";
    $resultado = $conexion->query($sql);
    $resultado->bindColumn(1, $id);
    $resultado->bindColumn(2, $modelo);
    $resultado->bindColumn(3, $precio);
    $resultado->bindColumn(4, $gama);
    $resultado->bindColumn(5, $anio);
    $resultado->bindColumn(6, $ram);
    $resultado->bindColumn(7, $almacenamiento);
    $resultado->bindColumn(8, $procesador);
    $resultado->bindColumn(9, $bateria);
    $resultado->bindColumn(10, $pulgadas);
    $resultado->bindColumn(11, $stock);
    $resultado->bindColumn(12, $imagen);
    $resultado->bindColumn(13, $idMovil);
    $resultado->bindColumn(14, $camara);
    $resultado->bindColumn(15, $notch);
    while ($resultado->fetch(PDO::FETCH_BOUND)) {
        $datos[$id] = array("modelo" => $modelo, "precio" => $precio, "gama" => $gama, "anio" => $anio,
            "ram" => $ram, "almacenamiento" => $almacenamiento, "procesador" => $procesador, "bateria" => $bateria,
            "pulgadas" => $pulgadas,"imagen" => $imagen, "stock" => $stock, "camara" => $camara, "notch" => $notch);
    }
    return $datos;
}

function getMovil($idSelected)
{
    $conexion = getConexionPDO();
    $sql = "SELECT * from dispositivos d inner join moviles m on d.id_dispositivo = m.id_movil where id_dispositivo = ?;";
    $resultado = $conexion->prepare($sql);
    $resultado->bindParam(1, $idSelected);
    $resultado->execute();
    $resultado->bindColumn(1, $id);
    $resultado->bindColumn(2, $modelo);
    $resultado->bindColumn(3, $precio);
    $resultado->bindColumn(4, $gama);
    $resultado->bindColumn(5, $anio);
    $resultado->bindColumn(6, $ram);
    $resultado->bindColumn(7, $almacenamiento);
    $resultado->bindColumn(8, $procesador);
    $resultado->bindColumn(9, $bateria);
    $resultado->bindColumn(10, $pulgadas);
    $resultado->bindColumn(11, $stock);
    $resultado->bindColumn(12, $imagen);
    $resultado->bindColumn(13, $idMovil);
    $resultado->bindColumn(14, $camara);
    $resultado->bindColumn(15, $notch);
    while ($resultado->fetch(PDO::FETCH_BOUND)) {
        $datos[$id] = array("modelo" => $modelo, "precio" => $precio, "gama" => $gama, "anio" => $anio,
            "ram" => $ram, "almacenamiento" => $almacenamiento, "procesador" => $procesador, "bateria" => $bateria,
            "pulgadas" => $pulgadas,"imagen" => $imagen, "stock" => $stock, "camara" => $camara, "notch" => $notch);
    }
    return $datos;
}

function getRelojes()
{
    $conexion = getConexionPDO();
    $sql = "SELECT * from dispositivos d inner join relojes m on d.id_dispositivo = m.id_reloj;";
    $resultado = $conexion->query($sql);
    $resultado->bindColumn(1, $id);
    $resultado->bindColumn(2, $modelo);
    $resultado->bindColumn(3, $precio);
    $resultado->bindColumn(4, $gama);
    $resultado->bindColumn(5, $anio);
    $resultado->bindColumn(6, $ram);
    $resultado->bindColumn(7, $almacenamiento);
    $resultado->bindColumn(8, $procesador);
    $resultado->bindColumn(9, $bateria);
    $resultado->bindColumn(10, $pulgadas);
    $resultado->bindColumn(11, $stock);
    $resultado->bindColumn(12, $imagen);
    $resultado->bindColumn(13, $idReloj);
    $resultado->bindColumn(14, $sim);
    while ($resultado->fetch(PDO::FETCH_BOUND)) {
        $datos[$id] = array("modelo" => $modelo, "precio" => $precio, "gama" => $gama, "anio" => $anio,
            "ram" => $ram, "almacenamiento" => $almacenamiento, "procesador" => $procesador, "bateria" => $bateria,
            "pulgadas" => $pulgadas,"imagen" => $imagen, "stock" => $stock, "sim" => $sim);
    }
    return $datos;
}

function getReloj($idSelected)
{
    $conexion = getConexionPDO();
    $sql = "SELECT * from dispositivos d inner join relojes m on d.id_dispositivo = m.id_reloj where id_dispositivo = ?;";
    $resultado = $conexion->prepare($sql);
    $resultado->bindParam(1, $idSelected);
    $resultado->execute();
    $resultado->bindColumn(1, $id);
    $resultado->bindColumn(2, $modelo);
    $resultado->bindColumn(3, $precio);
    $resultado->bindColumn(4, $gama);
    $resultado->bindColumn(5, $anio);
    $resultado->bindColumn(6, $ram);
    $resultado->bindColumn(7, $almacenamiento);
    $resultado->bindColumn(8, $procesador);
    $resultado->bindColumn(9, $bateria);
    $resultado->bindColumn(10, $pulgadas);
    $resultado->bindColumn(11, $stock);
    $resultado->bindColumn(12, $imagen);
    $resultado->bindColumn(13, $idReloj);
    $resultado->bindColumn(14, $sim);
    while ($resultado->fetch(PDO::FETCH_BOUND)) {
        $datos[$id] = array("modelo" => $modelo, "precio" => $precio, "gama" => $gama, "anio" => $anio,
            "ram" => $ram, "almacenamiento" => $almacenamiento, "procesador" => $procesador, "bateria" => $bateria,
            "pulgadas" => $pulgadas,"imagen" => $imagen, "stock" => $stock, "sim" => $sim);
    }
    return $datos;
}

function getFicha($id)
{
    if (getTipoDispositivo($id) == "movil") {
        return [getMovil($id), "movil"];
    } else {
        return [getReloj($id), "reloj"];
    }
}

;

function getTipoDispositivo($id)
{
    $conexion = getConexionPDO();
    $sql = "SELECT COUNT(*) as iguales from moviles where id_movil = ?;";
    $resultado = $conexion->prepare($sql);
    $resultado->bindParam(1, $id);
    $resultado->execute();
    $fila = $resultado->fetch();
    if ($fila["iguales"] != 0) {
        unset($conexion);
        return "movil";
    }
    unset($conexion);
    return "reloj";
}

;