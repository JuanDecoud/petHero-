<?php

namespace Models;
use Models\User as User;
use Models\Tarjeta as Tarjeta;
use Models\Pet as Pet;

class Owner extends User
{
    private Tarjeta $tarjeta;
    private Pet $pet;

    public function __construct($username , $contrasena , $tipocuenta){
        parent::__construct($username,$contrasena);
        $this->setTipodecuenta($tipocuenta);
    }
    
    
    public function setTarjeta($numero, $nombre, $fechaVenc, $codigo)
    {
        $this->tarjeta->setNumero($numero);
        $this->tarjeta->setNombre($nombre);
        $this->tarjeta->setFechaVenc($fechaVenc);
        $this->tarjeta->setCodigo($codigo);
        return $this;
    }


}

?>