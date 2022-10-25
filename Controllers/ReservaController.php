<?php 
    namespace Controllers ;

    class ReservaController {

        public function prueba ($nombre , $fecha , $fecha2){
            echo $nombre.$fecha.$fecha2;
            $this->vistaOwner();
        }

        public function vistaOwner (){
            require_once (VIEWS_PATH."menu-owner.php");
        }
    }
?>