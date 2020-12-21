<?php


class Cupon
{
    private $id_cupon;
    private $cupon;
    private $fecha_inicio;
    private $fecha_fin;
    private $descuento;

    /**
     * Cupon constructor.
     * @param $id_cupon
     * @param $cupon
     * @param $fecha_inicio
     * @param $fecha_fin
     * @param $descuento
     */
    public function __construct($id_cupon, $cupon, $fecha_inicio, $fecha_fin, $descuento)
    {
        $this->id_cupon = $id_cupon;
        $this->cupon = $cupon;
        $this->fecha_inicio = $fecha_inicio;
        $this->fecha_fin = $fecha_fin;
        $this->descuento = $descuento;
    }

    /**
     * @return mixed
     */
    public function getIdCupon()
    {
        return $this->id_cupon;
    }

    /**
     * @param mixed $id_cupon
     */
    public function setIdCupon($id_cupon)
    {
        $this->id_cupon = $id_cupon;
    }

    /**
     * @return mixed
     */
    public function getCupon()
    {
        return $this->cupon;
    }

    /**
     * @param mixed $cupon
     */
    public function setCupon($cupon)
    {
        $this->cupon = $cupon;
    }

    /**
     * @return mixed
     */
    public function getFechaInicio()
    {
        return $this->fecha_inicio;
    }

    /**
     * @param mixed $fecha_inicio
     */
    public function setFechaInicio($fecha_inicio)
    {
        $this->fecha_inicio = $fecha_inicio;
    }

    /**
     * @return mixed
     */
    public function getFechaFin()
    {
        return $this->fecha_fin;
    }

    /**
     * @param mixed $fecha_fin
     */
    public function setFechaFin($fecha_fin)
    {
        $this->fecha_fin = $fecha_fin;
    }

    /**
     * @return mixed
     */
    public function getDescuento()
    {
        return $this->descuento;
    }

    /**
     * @param mixed $descuento
     */
    public function setDescuento($descuento)
    {
        $this->descuento = $descuento;
    }


}