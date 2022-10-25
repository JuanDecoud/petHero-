<?php 
    namespace Models ;

    class Reserva {
        private $fdesde ;
        private $fhasta ;
        private Keeper $keeper ;
        private Pet $pet ;
        private $importeReserva ;
        private $importeTotal ;


        public function __construct($fdesde ,$fhasta , Keeper $keeper , Pet $pet , $importeReserva , $importeTotal )
        {
            $this->fdesde= $fdesde ;
            $this->fhasta= $fhasta ;
            $this->keeper= $keeper ;
            $this->pet= $pet ;
            $this->importeReserva= $importeReserva ;
            $this->importeTotal= $importeTotal ;

            
        }

        public function setFechadesde ($fdesde){$this->fdesde = $fdesde ;}
        public function getFechadesde (){ return $this->fdesde  ;}

        public function setFechahasta ($fhasta){$this->fdesde = $fhasta ;}
        public function getFechahasta (){ return $this->fhasta  ;}

        public function setKeeper ($keeper){$this->keeper = $keeper ;}
        public function getKeeper (){ return $this->keeper  ;}

        public function setPet ($pet){$this->pet = $pet ;}
        public function getPet (){ return $this->pet  ;}

        public function setImporteReserva ($importe){$this->importeReserva = $importe ;}
        public function getImporteReserva (){ return $this->importeReserva  ;}

        public function setImporteTotal ($importe){ $this->importeTotal = $importe;}
        public function getImporteTotal (){ return $this->importeTotal;}
        
}
?>