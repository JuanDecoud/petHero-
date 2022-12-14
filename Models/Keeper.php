<?php 
    namespace Models ;

    class Keeper extends User {

        
        private $tipoMascota = array() ;
        private $remuneracion ;
        private $fechasDisponibles = array();
        //private $reservasAceptadas = array();
        

    
        
        public function __construct($username , $contrasena , $tipocuenta , $remuneracion, $nombre, $apellido,$dni,$telefono)
        {
            parent::__construct($username,$contrasena);
            $this->setContrasena($contrasena);
            $this->setTipodecuenta($tipocuenta);
            $this->setNombre($nombre);
            $this->setApellido($apellido);
            $this->setDni($dni);
            $this->setTelefono($telefono);         
            $this->remuneracion = $remuneracion ;
        }
        

        public function getTipo (){return $this->tipoMascota;}
        public function getRemuneracion (){return $this->remuneracion;}
        public function setFechas ($fechas){
            $this->fechasDisponibles = $fechas ;
        }
        public function getFechas (){
            return $this->fechasDisponibles;
        }

        public function setTipoMascota($tipoMascota){
            $this -> tipoMascota = $tipoMascota;
        }

        public function setRemuneracion($remuneracion){
            $this -> remuneracion = $remuneracion;
        }

        public function agregarFecha (FechasEstadias $estadia){
            array_push($this->fechasDisponibles , $estadia);
        }
        /*
        public function agregarReservaAceptada(Reserva $reserva){
            array_push($this -> reservasAceptadas, $reserva);
        }
        */
        /*public function getReservas(){
            return $this -> reservasAceptadas;
        }
        */
    }


?>