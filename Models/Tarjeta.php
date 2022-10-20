<?php

namespace Models;

class Tarjeta
{
    private $numero;
    private $nombre;
    private $fechaVenc;
    private $codigo;

    public function __construct($numero, $nombre, $fechaVenc, $codigo)
    {
        $this->numero=$numero;
        $this->nombre=$nombre;
        $this->fechaVenc=$fechaVenc;
        $this->codigo=$codigo;
    }
    


    /**
     * Get the value of numero
     */ 
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set the value of numero
     *
     * @return  self
     */ 
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get the value of nombre
     */ 
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     *
     * @return  self
     */ 
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get the value of fechaVenc
     */ 
    public function getFechaVenc()
    {
        return $this->fechaVenc;
    }

    /**
     * Set the value of fechaVenc
     *
     * @return  self
     */ 
    public function setFechaVenc($fechaVenc)
    {
        $this->fechaVenc = $fechaVenc;

        return $this;
    }

    /**
     * Get the value of codigo
     */ 
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set the value of codigo
     *
     * @return  self
     */ 
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }
}

?>