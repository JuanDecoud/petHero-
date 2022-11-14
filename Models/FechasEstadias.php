<?php 
    namespace Models ;

    class FechasEstadias {
        private $desde ;
        private $hasta ;
        private $estado ;
        private Keeper $keeper ;

        public function __construct($desde , $hasta)
        {
            $this->desde = $desde ;
            $this ->hasta = $hasta;
            $this->estado = Estadoreserva::Activo ;
        }

        public function getEstado (){return $this->estado;}
        public function setEstado ($estado){$this->estado = $estado;}
        public function setKeeper ($keeper){$this->keeper = $keeper ;}
        public function getKeeper (){return $this->keeper ;}
        public function setDesde ($desde){$this->desde = $desde;}
        public function getDesde (){return $this->desde;}
        public function setHasta ($hasta){$this->hasta = $hasta;}
        public function getHasta (){return $this->hasta;}


        

    }

?>