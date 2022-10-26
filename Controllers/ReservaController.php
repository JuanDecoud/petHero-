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


        public function prueba ($nombre , $fecha , $fecha2 , $pet){
            echo $nombre.$fecha.$fecha2.$pet;
            $this->vistaOwner();
        }

        public function vistaOwner (){
            require_once (VIEWS_PATH."menu-owner.php");
        }


        public function solicitadudEstadia ($nombreKeeper , $fechainicio , $fechaFin){
                $user = $this->keeperdao->obtenerUser($nombreKeeper);
                
        }

        public function listaKeepers (){
            
            $petdao = new PetDAO ();
            $user = $_SESSION['loggedUser'];
            $petlist = $petdao->buscarPets($user->getNombreUser());
            $keeperdao = new KeeperDAO();
            $keeperlist = $keeperdao->getAll();
            $listaEstadias = $keeperdao->listaEstadias($keeperlist);
            echo "hola";

            require_once(VIEWS_PATH."menu-owner.php");
            require_once(VIEWS_PATH."actualizarKeepers.php");
        }
    }
?>