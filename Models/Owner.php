<?php

namespace Models;
use Models\User as User;
use Models\Tarjeta as Tarjeta;
use Models\Pet as Pet;

class Owner extends User
{
    private   $tarjeta = array() ;
    private $pet =array() ;

   

    /*function __construct($username , $contrasena , $tipocuenta){
        parent::__construct($username,$contrasena);
        $this->setTipodecuenta($tipocuenta);
    }*/

    function __construct()
    {
        
    }
    
    
    public function setTarjeta(Tarjeta $tarjeta){
        $this->tarjeta = $tarjeta ;
    }
    public function getTarjeta (){
       
        return $this->tarjeta;
    }
    public function getPet (){return $this->pet;}
    public function  setPet ($pets){
        $this->Pet = $pets ;
    }

    public function getPetList (){
        return $this->pet ;
    }

    public function agregarPet (Pet $pet){
        array_push($this->pet , $pet );
    }

    //public function getTarjeta (){return $this->tarjeta;}

    



}

