<?php
require_once "sql/Conexion.php";

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

function getUsuario($id)
{
    $conexion = getConexionPDO();
    $sql = "SELECT * from usuarios where id = ? ";
    $consulta = $conexion->prepare($sql);
    $consulta->bindParam(1, $id);
    if ($consulta->execute()) {
        $consulta->bindColumn(1, $id);
        $consulta->bindColumn(2, $usuario);
        $consulta->bindColumn(3, $pass);
        $consulta->bindColumn(4, $nombre);
        $consulta->bindColumn(5, $apellidos);
        $consulta->bindColumn(6, $email);
        $consulta->bindColumn(7, $foto_perfil);
        $consulta->bindColumn(8, $admin);
        if ($consulta->fetch()) {
            return array(
                "id" => $id, "usuario" => $usuario, "nombre" => $nombre, "apellidos" => $apellidos, "email" => $email,
                "foto_perfil" => $foto_perfil, "admin" => $admin
            );
        }
    }
    return 0;
}

function checkUsuario($usuario)
{
    $conexion = getConexionPDO();
    $sql = "SELECT usuario from usuarios where usuario = ?";
    $consulta = $conexion->prepare($sql);
    $consulta->bindParam(1, $usuario);
    if ($consulta->execute()) {
        if ($consulta->fetch()) {
            return 1;
        }
    }
    return 0;
}

function checkUsuarioPass($usuario, $password)
{
    $conexion = getConexionPDO();
    $sql = "SELECT id, usuario, pass from usuarios where usuario = ? AND pass = MD5(?)";
    $consulta = $conexion->prepare($sql);
    $consulta->bindParam(1, $usuario);
    $consulta->bindParam(2, $password);
    if ($consulta->execute()) {
        $consulta->bindColumn(1, $id);
        if ($consulta->fetch()) {
            return $id;
        }
    }
    return 0;
}

function getDispositivos()
{
    $conexion = getConexionPDO();
    $sql = "SELECT * from dispositivos order by modelo";
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
    while ($resultado->fetch(PDO::FETCH_BOUND)) {
        $datos[$id] = array(
            "modelo" => $modelo, "precio" => $precio, "gama" => $gama, "anio" => $anio,
            "ram" => $ram, "almacenamiento" => $almacenamiento, "procesador" => $procesador, "bateria" => $bateria,
            "pulgadas" => $pulgadas, "stock" => $stock, "imagen" => $imagen
        );
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

/*function getStock($id)
{
    $conexion = getConexionPDO();
    $sql = "SELECT stock from dispositivos where id_dispositivo = ?;";
    $resultado = $conexion->prepare($sql);
    $resultado->bindParam(1, $idSelected);
    $resultado->execute();
    $resultado->bindColumn(1, $stock);
    $resultado->fetch(PDO::FETCH_BOUND);
    return $stock;
}*/

function addMovil(
    $modelo,
    $precio,
    $gama,
    $anio,
    $ram,
    $almacenamiento,
    $procesador,
    $bateria,
    $pulgadas,
    $imagen,
    $camara,
    $notch
) {
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

function addReloj(
    $modelo,
    $precio,
    $gama,
    $anio,
    $ram,
    $almacenamiento,
    $procesador,
    $bateria,
    $pulgadas,
    $imagen,
    $sim
) {
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
    $sql = "SELECT * from dispositivos d inner join moviles m on d.id_dispositivo = m.id_movil order by modelo;";
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
        $datos[$id] = array(
            "modelo" => $modelo, "precio" => $precio, "gama" => $gama, "anio" => $anio,
            "ram" => $ram, "almacenamiento" => $almacenamiento, "procesador" => $procesador, "bateria" => $bateria,
            "pulgadas" => $pulgadas, "imagen" => $imagen, "stock" => $stock, "camara" => $camara, "notch" => $notch
        );
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
    $resultado->fetch(PDO::FETCH_BOUND);
    $datos[$id] = array(
        "modelo" => $modelo, "precio" => $precio, "gama" => $gama, "anio" => $anio,
        "ram" => $ram, "almacenamiento" => $almacenamiento, "procesador" => $procesador, "bateria" => $bateria,
        "pulgadas" => $pulgadas, "imagen" => $imagen, "stock" => $stock, "camara" => $camara, "notch" => $notch
    );
    unset($conexion);
    return $datos;
}

function getRelojes()
{
    $conexion = getConexionPDO();
    $sql = "SELECT * from dispositivos d inner join relojes m on d.id_dispositivo = m.id_reloj order by modelo;";
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
        $datos[$id] = array(
            "modelo" => $modelo, "precio" => $precio, "gama" => $gama, "anio" => $anio,
            "ram" => $ram, "almacenamiento" => $almacenamiento, "procesador" => $procesador, "bateria" => $bateria,
            "pulgadas" => $pulgadas, "imagen" => $imagen, "stock" => $stock, "sim" => $sim
        );
    }
    unset($conexion);
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
    $resultado->fetch(PDO::FETCH_BOUND);
    $datos[$id] = array(
        "modelo" => $modelo, "precio" => $precio, "gama" => $gama, "anio" => $anio,
        "ram" => $ram, "almacenamiento" => $almacenamiento, "procesador" => $procesador, "bateria" => $bateria,
        "pulgadas" => $pulgadas, "imagen" => $imagen, "stock" => $stock, "sim" => $sim
    );
    unset($conexion);
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

function getProducto($id)
{
    if (getTipoDispositivo($id) == "movil") {
        return getMovil($id);
    } else {
        return getReloj($id);
    }
}

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

function borrarModelo($id)
{
    $conexion = getConexionPDO();
    $sql = "DELETE FROM dispositivos WHERE id_dispositivo = ?;";
    $delete = $conexion->prepare($sql);
    $delete->bindParam(1, $id);
    if ($delete->execute() == false) {
        throw new Exception("No se pudo borrar el modelo seleccionado");
    }
    unset($conexion);
    return true;
}

function registrarCompra_RetirarStock($idUsuario, $idProducto, $cantidad)
{
    $conexion = getConexionPDO();
    try {
        $conexion->beginTransaction();
        $sql = "INSERT INTO compras (id_usuario, id_dispositivo, unidades) VALUES (?,?,?)";
        $consulta = $conexion->prepare($sql);
        $consulta->bindParam(1, $idUsuario);
        $consulta->bindParam(2, $idProducto);
        $consulta->bindParam(3, $cantidad);
        if ($consulta->execute() != true) {
            throw new Exception("Error al registrar la compra");
        }
        $sql = "SELECT stock FROM dispositivos WHERE id_dispositivo = ?;";
        $consulta = $conexion->prepare($sql);
        $consulta->bindParam(1, $idProducto);
        $consulta->execute();
        $consulta->bindColumn(1, $stockTienda);
        $consulta->fetch(PDO::FETCH_BOUND);
        if ($stockTienda < $cantidad) {
            throw new Exception("No se ha realizado la compra. Stock menor al elegido");
        }
        $sql = "UPDATE dispositivos SET stock = (stock - ?) WHERE id_dispositivo = ?;";
        $consulta = $conexion->prepare($sql);
        $consulta->bindParam(1, $cantidad);
        $consulta->bindParam(2, $idProducto);
        if ($consulta->execute() != true) {
            throw new Exception("Error al actualizar el stock");
        }
        $conexion->commit();
        unset($conexion);
        return true;
    } catch (Exception $e) {
        $conexion->rollBack();
        unset($conexion);
        return $e->getMessage();
    }
}

function updateUsuario($id, $nombre, $apellidos, $usuario, $email, $contraseña)
{
    $conexion = getConexionPDO();
    $sql = "UPDATE usuarios SET nombre = ?, apellidos = ?, usuario = ?, email = ?, pass = MD5(?)  WHERE id = ?;";
    $consulta = $conexion->prepare($sql);
    $consulta->bindParam(1, $nombre);
    $consulta->bindParam(2, $apellidos);
    $consulta->bindParam(3, $usuario);
    $consulta->bindParam(4, $email);
    $consulta->bindParam(5, $contraseña);
    $consulta->bindParam(6, $id);
    if ($consulta->execute()){
        unset($conexion);
        return true;
    }
    unset($conexion);
    return false;
}

function updateFotoUsuario($id, $imagen)
{
    $conexion = getConexionPDO();
    $sql = "UPDATE usuarios SET foto_perfil = ?  WHERE id = ?;";
    $consulta = $conexion->prepare($sql);
    $consulta->bindParam(1, $imagen);
    $consulta->bindParam(2, $id);
    if ($consulta->execute()){
        unset($conexion);
        return true;
    }
    unset($conexion);
    return false;
}

function getHistorial($idUsuario)
{

    $conexion = getConexionPDO();
    $datos = null;
    $sql = "SELECT id_compra, c.id_dispositivo, imagen, modelo, precio, unidades, fecha from dispositivos d left join compras c on d.id_dispositivo = c.id_dispositivo where c.id_usuario = ?;";
    $resultado = $conexion->prepare($sql);
    $resultado->bindParam(1, $idUsuario);
    $resultado->execute();
    $resultado->bindColumn(1, $idCompra);
    $resultado->bindColumn(2, $id);
    $resultado->bindColumn(3, $imagen);
    $resultado->bindColumn(4, $modelo);
    $resultado->bindColumn(5, $precio);
    $resultado->bindColumn(6, $cantidad);
    $resultado->bindColumn(7, $fecha);
    while ($resultado->fetch(PDO::FETCH_BOUND)) {
        $datos[] = array(
            "id_compra" => $idCompra, "id"=> $id, "imagen" => $imagen,"modelo" => $modelo, "precio" => $precio, "cantidad"=>$cantidad, "fecha"=>$fecha
        );
    }
    unset($conexion);
    return $datos;
}
