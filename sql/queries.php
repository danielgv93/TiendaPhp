<?php
require_once "sql/Conexion.php";

function addUsuario($usuario, $password)
{
    $conexion = getConexionPDO();
    try {
        $sql = "INSERT INTO usuarios (usuario, password) VALUES (?,MD5(?));";
        $consulta = $conexion->prepare($sql);
        $consulta->bindParam(1, $usuario);
        $consulta->bindParam(2, $password);
        if ($consulta->execute()) {
            unset($conexion);
            return true;
        } else{
            throw new Exception("Error al insertar usuario");
        }
    } catch (Exception $e) {
        echo $e->getMessage();
        unset($conexion);
        return false;
    }

}
function checkUsuario($usuario, $password)
{
    $conexion = getConexionPDO();
    $sql = "SELECT usuario, password from usuarios where usuario = ? AND password = MD5(?)";
    $consulta = $conexion->prepare($sql);
    $consulta->bindParam(1, $usuario);
    $consulta->bindParam(2, $password);
    if ($consulta->execute()) {
        while ($fila = $consulta->fetch()) {
            $datos[] = array("usuario" => $fila['usuario'], "password" => $fila['password']);
        }
    }
    return count($datos);
}