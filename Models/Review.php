<?php 
 namespace Models ;

    class Review {
        private $description ;
        private $fecha;
        private $Keeper ;
        private $Pet ;
        private $puntaje ;


        public function __construct()
        {

        }


        public function setDescription ($description){$this->description = $description;}
        public function getDescription (){return $this->description;}

        public function setFecha ($fecha){$this->fecha = $fecha;}
        public function getFecha (){return $this->fecha;}

        public function setKeeper ( Keeper $keeper){$this->Keeper = $keeper;}
        public function getKeeper (){return $this->Keeper;}

        public function setPet ( Pet $pet){$this->Pet = $pet;}
        public function getPet (){return $this->Pet;}

        public function setPuntaje ($puntaje){$this->puntaje = $puntaje;}
        public function getPuntaje (){return $this->puntaje;}

    }

  
    





?>