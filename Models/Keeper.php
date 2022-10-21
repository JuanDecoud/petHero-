<?php 
    namespace Models ;

    class Keeper extends User {

        
        private $tipoMascota ;
        private $remuneracion ;
        private $fechasDisponibles = array();

        

    

        public function __construct($username , $contrasena , $tipocuenta , $tipoMascota , $remuneracion)
        {
            parent::__construct($username,$contrasena);
            $this->setContrasena($contrasena);
            $this->setTipodecuenta($tipocuenta);
            $this->tipoMascota = $tipoMascota;          
            $this->remuneracion = $remuneracion ;
        }

        public function getTipo (){return $this->tipoMascota;}
        public function getRemuneracion (){return $this->remuneracion;}
        public function setFechas ($fechas){
            $this->fechasDisponibles = $fechas ;
        }
        public function getFechas (){
            return $this->fechasDisponibles ;
        }

        public function agregarFecha ($fecha){
            array_push($this->fechasDisponibles , $fecha);
        }

    }

?>