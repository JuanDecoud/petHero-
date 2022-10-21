<?php
    namespace Controllers;

use DAO\KeeperDAO;

    class HomeController
    {
        private $keeperDao ;

        public function __construct()
        {
            $this->keeperDao = new KeeperDAO();
        }

  

        public function Index($message = "")
        {
            require_once(VIEWS_PATH."mainKeeper.php");
        } 


        public function vistaTipocuenta (){
            require_once(VIEWS_PATH."tipodecuenta.php");
        }

        public function registerKeeper (){
            require_once (VIEWS_PATH."Sign-upKeeper.php");
        }
        
    

        public function seleccinarCuenta ($tipoCuenta){
           
            $tipo = $tipoCuenta ;
            if ($tipo == "Keeper"){
                $_SESSION['keeper'] =$tipo; 
                $this->registerKeeper();
                
            }
            else if($tipo == "Owner")
            {
                $_SESSION['owner'] =$tipo; 
                $this->registerC->registrarOwner();
            }

        }

    }
?>