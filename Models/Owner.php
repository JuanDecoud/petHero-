<?php

namespace Models;
use Models\User as User;
use Models\Tarjeta as Tarjeta;

class Owner extends User
{
    private $dni;
    private $email;
    private Tarjeta $tarjeta;

    public function __construct($id, $nombreUser, $contrasena, $dni, $email, $tarjeta){
        parent::__construct($id, $nombreUser, $contrasena);
        $this->dni=$dni;
        $this->email=$email;
        $this->tarjeta=$tarjeta;
    }
    


    /**
     * Get the value of dni
     */ 
    public function getDni()
    {
        return $this->dni;
    }

    /**
     * Set the value of dni
     *
     * @return  self
     */ 
    public function setDni($dni)
    {
        $this->dni = $dni;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of tarjeta
     */ 
    public function getTarjeta()
    {
        return $this->tarjeta->getList();
    }

    /**
     * Set the value of tarjeta
     *
     * @return  self
     */ 
    public function setTarjeta($tarjeta)
    {
        $this->tarjeta = $tarjeta;

        return $this;
    }


}

?>