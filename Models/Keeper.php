<?php 
    namespace Models ;

    class Keeper extends User {

        
        private $tipoMascota ;
        private $remuneracion ;
        private $fechasDisponibles = array();

        

    

        public function __construct($username , $contrasena , $tipocuenta , $tipoMascota , $remuneracion)
        {
            $this->setNombreUser($username);
            $this->setContrasena($contrasena);
            $this->setTipodecuenta($tipocuenta);
            $this->tipoMascota = $tipoMascota;          
            $this->remuneracion = $remuneracion ;
        }

        public function getTipo (){return $this->tipoMascota;}
        public function getRemuneracion (){return $this->remuneracion;}
        public function setFechas ($fecha){
            $this->fechasDisponibles = $fecha ;
        }

        public function agregarFecha ($fecha){
            array_push($this->fechasDisponibles , $fecha);
        }

        public function getFechas (){return $this->fechasDisponibles;}


    }

?>