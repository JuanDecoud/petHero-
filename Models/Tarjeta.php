<?php

namespace Models;

class Tarjeta
{
    private $numero;
    private $nombre;
    private $apellido ;
    private $fechaVenc;
    private $codigo;

   public function __construct()
   {

    
   }

   public function getApellido (){return $this->apellido;}
   public function setApellido ($apellido){$this->apellido = $apellido;}

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
    
    public function getList()
    {
        echo "Numero: ".$this->numero.
        "Nombre: ".$this->nombre.
        "Fecha de Vencimiento: ".$this->fechaVenc.
        "Codigo: ".$this->codigo;
    }

}

?>