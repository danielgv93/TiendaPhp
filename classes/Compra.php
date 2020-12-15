<?php


class Compra
{
    private $id_compra;
    private $id_usuario;
    private $id_dispositivo;
    private $fecha;
    private $unidades;

    /**
     * Compra constructor.
     * @param $id_compra
     * @param $id_usuario
     * @param $id_dispositivo
     * @param $fecha
     * @param $unidades
     */
    public function __construct($id_compra, $id_usuario, $id_dispositivo, $fecha, $unidades)
    {
        $this->id_compra = $id_compra;
        $this->id_usuario = $id_usuario;
        $this->id_dispositivo = $id_dispositivo;
        $this->fecha = $fecha;
        $this->unidades = $unidades;
    }

    /**
     * @return mixed
     */
    public function getIdCompra()
    {
        return $this->id_compra;
    }

    /**
     * @param mixed $id_compra
     */
    public function setIdCompra($id_compra)
    {
        $this->id_compra = $id_compra;
    }

    /**
     * @return mixed
     */
    public function getIdUsuario()
    {
        return $this->id_usuario;
    }

    /**
     * @param mixed $id_usuario
     */
    public function setIdUsuario($id_usuario)
    {
        $this->id_usuario = $id_usuario;
    }

    /**
     * @return mixed
     */
    public function getIdDispositivo()
    {
        return $this->id_dispositivo;
    }

    /**
     * @param mixed $id_dispositivo
     */
    public function setIdDispositivo($id_dispositivo)
    {
        $this->id_dispositivo = $id_dispositivo;
    }

    /**
     * @return mixed
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param mixed $fecha
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    /**
     * @return mixed
     */
    public function getUnidades()
    {
        return $this->unidades;
    }

    /**
     * @param mixed $unidades
     */
    public function setUnidades($unidades)
    {
        $this->unidades = $unidades;
    }


}