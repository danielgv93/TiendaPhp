<?php
require_once "Usuario.php";
require_once "Compra.php";
require_once "Dispositivo.php";
require_once "Movil.php";
require_once "Reloj.php";

class Database
{
    private static $instance = null;
    const HOST = "localhost";
    const USERNAME = "root";
    const PASSWORD = "";
    const DATABASE = "tienda_moviles";

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConexion()
    {
        $opciones = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
        return new PDO(
            'mysql:host=' . self::HOST . ';dbname=' . self::DATABASE,
            self::USERNAME,
            self::PASSWORD,
            $opciones
        );
    }

    //Hecho Dani
    public function addUsuario($usuario)
    {
        $conexion = $this->getConexion();
        try {
            if (!Database::checkUsuario($usuario)) {
                $sql = "INSERT INTO usuarios (usuario, pass, nombre, apellidos, email) VALUES (?, MD5(?), ?, ?, ?);";
                $consulta = $conexion->prepare($sql);
                $consulta->bindValue(1, $usuario->getUsuario());
                $consulta->bindValue(2, $usuario->getPass());
                $consulta->bindValue(3, $usuario->getNombre());
                $consulta->bindValue(4, $usuario->getApellidos());
                $consulta->bindValue(5, $usuario->getEmail());
                if ($consulta->execute()) {
                    return true;
                } else {
                    throw new Exception("Error al insertar usuario");
                }
            } else {
                throw new Exception("El usuario ya existe");
            }
        } catch (Exception $e) {
            return false;
        }
    }

    //Hecho Dani
    public function checkUsuario($usuario)
    {
        $conexion = $this->getConexion();
        $sql = /** @lang MariaDB */
            "SELECT usuario from usuarios where usuario = ?";
        $consulta = $conexion->prepare($sql);
        $consulta->bindValue(1, $usuario->getNombre());
        if ($consulta->execute()) {
            if ($consulta->fetch()) {
                return 1;
            }
        }
        return 0;
    }

    //Hecho Dani
    function getUsuario($id)
    {
        $conexion = $this->getConexion();
        $sql = /** @lang MariaDB */
            "SELECT * from usuarios where id = ? ";
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
                return new Usuario($id, $usuario, $pass, $nombre, $apellidos, $email, $foto_perfil, $admin);
            }
        }
        return 0;
    }

    //HECHO DANI
    function checkUsuarioPass($usuario, $password)
    {
        $conexion = $this->getConexion();
        $sql = /** @lang MariaDB */
            "SELECT id, usuario, pass from usuarios where usuario = ? AND pass = MD5(?)";
        $consulta = $conexion->prepare($sql);
        $consulta->bindValue(1, $usuario);
        $consulta->bindValue(2, $password);
        if ($consulta->execute()) {
            $consulta->bindColumn(1, $id);
            if ($consulta->fetch()) {
                return $id;
            }
        }
        return 0;
    }
    //HECHO DANI
    function updateUsuario($id, $nombre, $apellidos, $usuario, $email, $contraseña)
    {
        $conexion = $this->getConexion();
        $sql = /** @lang MariaDB */
            "UPDATE usuarios SET nombre = ?, apellidos = ?, usuario = ?, email = ?, pass = MD5(?)  WHERE id = ?;";
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

    function getDispositivos()
    {
        $conexion = $this->getConexion();
        $sql = /** @lang MariaDB */
            "SELECT * from dispositivos order by modelo";
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
            $datos[$id] = new Dispositivo($id, $modelo, $precio, $gama, $anio, $ram, $almacenamiento, $procesador,
                $bateria, $pulgadas, $stock, $imagen);
        }
        return $datos;
    }
    //HECHO MACHETE

    function updateStock($id, $stock)
    {
        $conexion = $this->getConexion();
        $sql = /** @lang MariaDB */
            "UPDATE dispositivos SET stock = ? WHERE id_dispositivo = ?;";
        $consulta = $conexion->prepare($sql);
        $consulta->bindValue(1, $id);
        $consulta->bindValue(2, $stock);
        if ($consulta->execute() != true) throw new Exception("No se ha podido actualizar el stock");
        return true;
    }

    function getRelojes()
    {
        $conexion = $this->getConexion();
        $sql = /** @lang MariaDB */
            "SELECT * from dispositivos d inner join relojes m on d.id_dispositivo = m.id_reloj order by modelo;";
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
            $datos[$id] = new Reloj($id, $modelo, $precio, $gama, $anio, $ram, $almacenamiento, $procesador, $bateria,
            $pulgadas, $stock, $imagen, $idReloj, $sim);
        }
        return $datos;
    }

    function getReloj($idSelected)
    {
        $conexion = $this->getConexion();
        $sql = /** @lang MariaDB */
            "SELECT * from dispositivos d inner join relojes m on d.id_dispositivo = m.id_reloj where id_dispositivo = ?;";
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
        $datos[$id] = new Reloj($id, $modelo, $precio, $gama, $anio, $ram, $almacenamiento, $procesador, $bateria,
            $pulgadas, $stock, $imagen, $idReloj, $sim);
        return $datos;
    }

    function getMoviles()
    {
        $conexion = $this->getConexion();
        $sql = /** @lang MariaDB */
            "SELECT * from dispositivos d inner join moviles m on d.id_dispositivo = m.id_movil order by modelo;";
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
            $datos[$id] = new Movil($id, $modelo, $precio, $gama, $anio, $ram, $almacenamiento, $procesador, $bateria,
            $pulgadas, $stock, $imagen, $idMovil, $camara, $notch);
        }
        return $datos;
    }

    //HECHO MACHETE
    function getMovil($idSelected)
    {
        $conexion = $this->getConexion();
        $sql = /** @lang MariaDB */
            "SELECT * from dispositivos d inner join moviles m on d.id_dispositivo = m.id_movil where id_dispositivo = ?;";
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
        $datos[$id] = new Movil(            $id, $modelo, $precio, $gama, $anio, $ram, $almacenamiento, $procesador, $bateria,
            $pulgadas, $stock, $imagen, $idMovil, $camara, $notch);
        unset($conexion);
        return $datos;
    }
    function addMovil($movil)
    {
        $conexion = $this->getConexion();
        /* SE COMPRUEBA QUE NO HAY UN MISMO MODELO EN LA BASE DE DATOS */
        $sql = /** @lang MariaDB */
            "SELECT COUNT(*) as iguales from dispositivos where modelo = ?;";
        $resultado = $conexion->prepare($sql);
        $resultado->bindValue(1, $movil->getModelo());
        $resultado->execute();
        $fila = $resultado->fetch();
        if ($fila["iguales"] != 0) {
            throw new Exception("Ya hay un modelo igual en la base de datos");
        }
        /* SE HACE INSERT CON TRANSACCIÓN EN dispositivos Y moviles */
        $conexion->beginTransaction();
        try {
            $sql = /** @lang MariaDB */
                "INSERT INTO dispositivos (modelo, precio, gama, anio, ram, almacenamiento, procesador, bateria, pulgadas, imagen)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
            $insert = $conexion->prepare($sql);
            $insert->bindValue(1, $movil->getModelo());
            $insert->bindValue(2, $movil->getPrecio());
            $insert->bindValue(3, $movil->getGama());
            $insert->bindValue(4, $movil->getAnio());
            $insert->bindValue(5, $movil->getRam());
            $insert->bindValue(6, $movil->getAlmacenamiento());
            $insert->bindValue(7, $movil->getProcesador());
            $insert->bindValue(8, $movil->getBateria());
            $insert->bindValue(9, $movil->getPulgadas());
            $insert->bindValue(10, $movil->getImagen());
            if ($insert->execute() == false) {
                throw new Exception("Error al insertar el dispositivo");
            }
            $sql = /** @lang MariaDB */
                "INSERT INTO moviles (id_movil, camara, notch) VALUES 
                    ((SELECT id_dispositivo from dispositivos order by id_dispositivo desc limit 1), ?, ?);";
            $insert = $conexion->prepare($sql);
            $insert->bindValue(1, $movil->getCamara());
            $insert->bindValue(2, $movil->getNotch());
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

    //HECHO MACHETE
    function addReloj($reloj)
    {
        $conexion = $this->getConexion();
        /* SE COMPRUEBA QUE NO HAY UN MISMO MODELO EN LA BASE DE DATOS */
        $sql = /** @lang MariaDB */
            "SELECT COUNT(*) as iguales from dispositivos where modelo = ?;";
        $resultado = $conexion->prepare($sql);
        $resultado->bindValue(1, $reloj->getModelo());
        $resultado->execute();
        $fila = $resultado->fetch();
        if ($fila["iguales"] != 0) {
            throw new Exception("Ya hay un modelo igual en la base de datos");
        }
        /* SE HACE INSERT CON TRANSACCIÓN EN dispositivos Y relojes */
        $conexion->beginTransaction();
        try {
            $sql = /** @lang MariaDB */
                "INSERT INTO dispositivos (modelo, precio, gama, anio, ram, almacenamiento, procesador, bateria, pulgadas, imagen)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
            $insert = $conexion->prepare($sql);
            $insert->bindValue(1, $reloj->getModelo());
            $insert->bindValue(2, $reloj->getPrecio());
            $insert->bindValue(3, $reloj->getGama());
            $insert->bindValue(4, $reloj->getAnio());
            $insert->bindValue(5, $reloj->getRam());
            $insert->bindValue(6, $reloj->getAlmacenamiento());
            $insert->bindValue(7, $reloj->getProcesador());
            $insert->bindValue(8, $reloj->getBateria());
            $insert->bindValue(9, $reloj->getPulgadas());
            $insert->bindValue(10, $reloj->getImagen());
            if ($insert->execute() == false) {
                throw new Exception("Error al insertar el dispositivo");
            }
            $sql = /** @lang MariaDB */
                "INSERT INTO relojes (id_reloj, sim) VALUES 
                    ((SELECT id_dispositivo from dispositivos order by id_dispositivo desc limit 1), ?);";
            $insert = $conexion->prepare($sql);
            $insert->bindValue(1, $reloj->getSim());
            if ($insert->execute() == false) {
                throw new Exception("Error al insertar el reloj");
            }
            $conexion->commit();
            return true;
        } catch (Exception $e) {
            $conexion->rollBack();
            return false;
        }
    }
    function registrarCompra_RetirarStock($usuario, $dispositivo, $cantidad)
    {
        $conexion = $this->getConexion();
        try {
            $conexion->beginTransaction();
            $sql = /** @lang MariaDB */
                "INSERT INTO compras (id_usuario, id_dispositivo, unidades) VALUES (?,?,?)";
            $consulta = $conexion->prepare($sql);
            $consulta->bindParam(1, $usuario);
            $consulta->bindParam(2, $dispositivo);
            $consulta->bindParam(3, $cantidad);
            if ($consulta->execute() != true) {
                throw new Exception("Error al registrar la compra");
            }
            $sql = /** @lang MariaDB */
                "SELECT stock FROM dispositivos WHERE id_dispositivo = ?;";
            $consulta = $conexion->prepare($sql);
            $consulta->bindParam(1, $dispositivo);
            $consulta->execute();
            $consulta->bindColumn(1, $stockTienda);
            $consulta->fetch(PDO::FETCH_BOUND);
            if ($stockTienda < $cantidad) {
                throw new Exception("No se ha realizado la compra. Stock menor al elegido");
            }
            $sql = /** @lang MariaDB */
                "UPDATE dispositivos SET stock = (stock - ?) WHERE id_dispositivo = ?;";
            $consulta = $conexion->prepare($sql);
            $consulta->bindParam(1, $cantidad);
            $consulta->bindParam(2, $dispositivo);
            if ($consulta->execute() != true) {
                throw new Exception("Error al actualizar el stock");
            }
            $conexion->commit();
            return true;
        } catch (Exception $e) {
            $conexion->rollBack();
            return $e->getMessage();
        }
    }
    //HECHO DANI
    function borrarModelo($id)
    {
        $conexion = $this->getConexion();
        $sql = /** @lang MariaDB */
            "DELETE FROM dispositivos WHERE id_dispositivo = ?;";
        $delete = $conexion->prepare($sql);
        $delete->bindValue(1, $id);
        if ($delete->execute() == false) {
            throw new Exception("No se pudo borrar el modelo seleccionado");
        }
        return true;
    }

    //HECHO DANI

    function getHistorial($idUsuario)
    {

        $conexion = $this->getConexion();
        $datos = null;
        $sql = /** @lang MariaDB */
            "SELECT id_compra, c.id_dispositivo, imagen, modelo, precio, unidades, fecha from dispositivos d left join compras c on d.id_dispositivo = c.id_dispositivo where c.id_usuario = ?;";
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

        return $datos;
    }

    function getTipoDispositivo($id)
    {
        $conexion = $this->getConexion();
        $sql = /** @lang MariaDB */
            "SELECT COUNT(*) as iguales from moviles where id_movil = ?;";
        $resultado = $conexion->prepare($sql);
        $resultado->bindParam(1, $id);
        $resultado->execute();
        $fila = $resultado->fetch();
        if ($fila["iguales"] != 0) {
            return "movil";
        }
        return "reloj";
    }

    function getProducto($id)
    {
        if (self::getTipoDispositivo($id) == "movil") {
            return self::getMovil($id);
        } else {
            return self::getReloj($id);
        }
    }

    function updateFotoUsuario($id, $imagen)
    {
        $conexion = $this->getConexion();
        $sql = /** @lang MariaDB */
            "UPDATE usuarios SET foto_perfil = ?  WHERE id = ?;";
        $consulta = $conexion->prepare($sql);
        $consulta->bindParam(1, $imagen);
        $consulta->bindParam(2, $id);
        if ($consulta->execute()){
            return true;
        }
        return false;
    }

    function getFicha($id)
    {
        if (self::getTipoDispositivo($id) == "movil") {
            return [self::getMovil($id), "movil"];
        } else {
            return [self::getReloj($id), "reloj"];
        }
    }


}