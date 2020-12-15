<?php


abstract class Dispositivo
{
    protected $id_dispositivo;
    protected $modelo;
    protected $precio;
    protected $gama;
    protected $anio;
    protected $ram;
    protected $almacenamiento;
    protected $procesador;
    protected $bateria;
    protected $pulgadas;
    protected $stock;
    protected $imagen;

    /**
     * Dispositivo constructor.
     * @param $id_dispositivo
     * @param $modelo
     * @param $precio
     * @param $gama
     * @param $anio
     * @param $ram
     * @param $almacenamiento
     * @param $procesador
     * @param $bateria
     * @param $pulgadas
     * @param $stock
     * @param $imagen
     */
    public function __construct($id_dispositivo, $modelo, $precio, $gama, $anio, $ram, $almacenamiento, $procesador, $bateria, $pulgadas, $stock, $imagen)
    {
        $this->id_dispositivo = $id_dispositivo;
        $this->modelo = $modelo;
        $this->precio = $precio;
        $this->gama = $gama;
        $this->anio = $anio;
        $this->ram = $ram;
        $this->almacenamiento = $almacenamiento;
        $this->procesador = $procesador;
        $this->bateria = $bateria;
        $this->pulgadas = $pulgadas;
        $this->stock = $stock;
        $this->imagen = $imagen;
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
    public function getModelo()
    {
        return $this->modelo;
    }

    /**
     * @param mixed $modelo
     */
    public function setModelo($modelo)
    {
        $this->modelo = $modelo;
    }

    /**
     * @return mixed
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * @param mixed $precio
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;
    }

    /**
     * @return mixed
     */
    public function getGama()
    {
        return $this->gama;
    }

    /**
     * @param mixed $gama
     */
    public function setGama($gama)
    {
        $this->gama = $gama;
    }

    /**
     * @return mixed
     */
    public function getAnio()
    {
        return $this->anio;
    }

    /**
     * @param mixed $anio
     */
    public function setAnio($anio)
    {
        $this->anio = $anio;
    }

    /**
     * @return mixed
     */
    public function getRam()
    {
        return $this->ram;
    }

    /**
     * @param mixed $ram
     */
    public function setRam($ram)
    {
        $this->ram = $ram;
    }

    /**
     * @return mixed
     */
    public function getAlmacenamiento()
    {
        return $this->almacenamiento;
    }

    /**
     * @param mixed $almacenamiento
     */
    public function setAlmacenamiento($almacenamiento)
    {
        $this->almacenamiento = $almacenamiento;
    }

    /**
     * @return mixed
     */
    public function getProcesador()
    {
        return $this->procesador;
    }

    /**
     * @param mixed $procesador
     */
    public function setProcesador($procesador)
    {
        $this->procesador = $procesador;
    }

    /**
     * @return mixed
     */
    public function getBateria()
    {
        return $this->bateria;
    }

    /**
     * @param mixed $bateria
     */
    public function setBateria($bateria)
    {
        $this->bateria = $bateria;
    }

    /**
     * @return mixed
     */
    public function getPulgadas()
    {
        return $this->pulgadas;
    }

    /**
     * @param mixed $pulgadas
     */
    public function setPulgadas($pulgadas)
    {
        $this->pulgadas = $pulgadas;
    }

    /**
     * @return mixed
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * @param mixed $stock
     */
    public function setStock($stock)
    {
        $this->stock = $stock;
    }

    /**
     * @return mixed
     */
    public function getImagen()
    {
        return $this->imagen;
    }

    /**
     * @param mixed $imagen
     */
    public function setImagen($imagen)
    {
        $this->imagen = $imagen;
    }

}