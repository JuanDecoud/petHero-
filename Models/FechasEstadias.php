<?php 
    namespace Models ;

    class FechasEstadias {
        private $desde ;
        private $hasta ;

        public function __construct($desde , $hasta)
        {
            $this->desde = $desde ;
            $this ->hasta = $hasta;
            
        }

        public function setDesde ($desde){$this->desde = $desde;}
        public function getDesde (){return $this->desde;}
        public function setHasta ($hasta){$this->hasta = $hasta;}
        public function getHasta (){return $this->hasta;}
        

    }

?>