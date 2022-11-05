<?php 
 namespace Models ;

    class Review {
        private $description ;
        private $fecha;
        private $idKeeper ;
        private $idPet ;
        private $puntaje ;


        public function __construct()
        {

        }


        public function setDescription ($description){$this->description = $description;}
        public function getDescription (){return $this->description;}

        public function setFecha ($fecha){$this->fecha = $fecha;}
        public function getFecha (){return $this->fecha;}

        public function setKeeper ( $keeper){$this->idKeeper = $keeper;}
        public function getKeeper (){return $this->idKeeper;}

        public function setOwner ($pet){$this->idPet = $pet;}
        public function getOwner (){return $this->idPet;}

        public function setPuntaje ($puntaje){$this->puntaje = $puntaje;}
        public function getPuntaje (){return $this->puntaje;}

    }

  
    





?>