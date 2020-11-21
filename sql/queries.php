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
        $datos[] = array("id" => $id, "modelo" => $modelo, "precio" => $precio, "gama" => $gama, "anio" => $anio,
            "ram" => $ram, "almacenamiento" => $almacenamiento, "procesador" => $procesador, "bateria" => $bateria,
            "pulgadas" => $pulgadas, "stock" => $stock, );
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

;