<?php
require_once "Database.php";

class Carrito
{
    protected $productos = array();

    public function nuevoArticulo($id)
    {
        $producto = Database::getInstance()->getProducto($id);
        $this->productos[$id] = $producto;
    }

    public function getProductos()
    {
        return $this->productos;
    }

    public function guardaCesta()
    {
        $_SESSION['carrito'] = $this;
    }

    public static function cargaCesta()
    {
        if (!isset($_SESSION['carrito']))
            return new Carrito();
        else
            return ($_SESSION['carrito']);
    }
}