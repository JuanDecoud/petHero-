<?php 
    namespace Models ;

    class Reserva {
        private $diasReservados = array ();
        private Keeper $keeper ;
        private Pet $pet ;
        private $importeReserva ;
        private $importeTotal ;
        private $estado ;
  

        public function __construct()
        {
            
        }

        
        public function setDias ($listReservados){$this->diasReservados = $listReservados;}
        public function getDias (){return $this->diasReservados;}

        public function setFechahasta ($fhasta){$this->fhasta = $fhasta ;}
        public function getFechahasta (){ return $this->fhasta  ;}

        public function setKeeper ( Keeper $keeper){$this->keeper = $keeper ;}
        public function getKeeper (){ return $this->keeper  ;}

        public function setPet (Pet $pet){$this->pet = $pet ;}
        public function getPet (){ return $this->pet  ;}

        public function setImporteReserva ($importe){$this->importeReserva = $importe ;}
        public function getImporteReserva (){ return $this->importeReserva  ;}

        public function setImporteTotal ($importe){ $this->importeTotal = $importe;}
        public function getImporteTotal (){ return $this->importeTotal;}

        public function setEstado ($estado){$this->estado = $estado ;}
        public function getEstado (){return $this->estado;}
        
}
?>