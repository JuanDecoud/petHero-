<?php 
    namespace Controllers ;

use DAO\KeeperDAO;

    class KeeperController {
        private $keeperDao ;

        public function __construct()
        {
            $this->keeperDao = new KeeperDAO();
        }

        
        public function principalKeeper (){
            require_once(VIEWS_PATH."mainKeeper.php");
        }


        public function asignarFecha ($fecha ){
            $keeper = $_SESSION['loggedUser'];
            echo $fecha ;
            $this->keeperDao->agregarFecha($fecha , $keeper->getNombreUser() );
            $this->principalKeeper();   
        }

        public function quitarFecha ($fecha ){
           
            $user = $_SESSION['loggedUser'];
            $this->keeperDao->quitarFecha($user->getNombreUser(),$fecha);
            $this->principalKeeper();
            

        }



    }
?>