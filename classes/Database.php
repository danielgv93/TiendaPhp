<?php


class Database
{
    private static $instance = null;
    const HOST = "localhost";
    const USERNAME = "root";
    const PASSWORD = "";
    const DATABASE = "tienda_moviles";

    private function __construct(){
        $opciones = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
        return new PDO(
            'mysql:host='.self::HOST.';dbname='.self::DATABASE,
            self::USERNAME,
            self::PASSWORD,
            $opciones
        );
    }

    /**
     * @return null
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }
}