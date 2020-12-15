<?php


class Reloj extends Dispositivo
{
    private $id_reloj;
    private $sim;

    public function __construct($id_dispositivo, $modelo, $precio, $gama, $anio, $ram, $almacenamiento, $procesador, $bateria, $pulgadas, $stock, $imagen, $id_reloj, $sim)
    {
        parent::__construct($id_dispositivo, $modelo, $precio, $gama, $anio, $ram, $almacenamiento, $procesador, $bateria, $pulgadas, $stock, $imagen);
        $this->id_reloj = $id_reloj;
        $this->$sim = $sim;
    }

    /**
     * @return mixed
     */
    public function getIdReloj()
    {
        return $this->id_reloj;
    }

    /**
     * @param mixed $id_reloj
     */
    public function setIdReloj($id_reloj)
    {
        $this->id_reloj = $id_reloj;
    }

    /**
     * @return mixed
     */
    public function getSim()
    {
        return $this->sim;
    }

    /**
     * @param mixed $sim
     */
    public function setSim($sim)
    {
        $this->sim = $sim;
    }


}