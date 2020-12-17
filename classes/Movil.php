<?php


class Movil extends Dispositivo
{
    private $id_movil;
    private $camara;
    private $notch;

    public function __construct($id_dispositivo, $modelo, $precio, $gama, $anio, $ram, $almacenamiento, $procesador,
                                $bateria, $pulgadas, $stock, $imagen, $id_movil, $camara, $notch)
    {
        parent::__construct($id_dispositivo, $modelo, $precio, $gama, $anio, $ram, $almacenamiento, $procesador,
            $bateria, $pulgadas, $stock, $imagen);
        $this->id_movil = $id_movil;
        $this->camara = $camara;
        $this->notch=$notch;


    }

    /**
     * @return mixed
     */
    public function getIdMovil()
    {
        return $this->id_movil;
    }

    /**
     * @param mixed $id_movil
     */
    public function setIdMovil($id_movil)
    {
        $this->id_movil = $id_movil;
    }

    /**
     * @return mixed
     */
    public function getCamara()
    {
        return $this->camara;
    }

    /**
     * @param mixed $camara
     */
    public function setCamara($camara)
    {
        $this->camara = $camara;
    }

    /**
     * @return mixed
     */
    public function getNotch()
    {
        return $this->notch;
    }

    /**
     * @param mixed $notch
     */
    public function setNotch($notch)
    {
        $this->notch = $notch;
    }
}