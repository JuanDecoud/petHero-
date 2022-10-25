<?php 
    namespace Controllers ;

use DAO\KeeperDAO;
use DAO\PetDAO ;

    class ReservaController {

        private KeeperDAO $keeperdao;
        private PetDAO $petdao ;

        public function __construct()
        {
            $this->keeperdao = new KeeperDAO();
            $this->petdao = new PetDAO ();
            
        }


        public function prueba ($nombre , $fecha , $fecha2){
            echo $nombre.$fecha.$fecha2;
            $this->vistaOwner();
        }

        public function vistaOwner (){
            require_once (VIEWS_PATH."menu-owner.php");
        }


        public function solicitadudEstadia ($nombreKeeper , $fechainicio , $fechaFin){
                $user = $this->keeperdao->obtenerUser($nombreKeeper);
                
        }
    }
?>