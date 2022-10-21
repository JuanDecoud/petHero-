<?php
    namespace Controllers;

    use DAO\KeeperDAO as KeeperDAO ;
    use  DAO\OwnerDao as OwnerDAO ;

    class HomeController
    {
        private $keeperDao ;
        private $ownerDao ;

        public function __construct()
        {
            $this->keeperDao = new KeeperDAO();
            $this->ownerDao = new OwnerDAO ();
        }

  

        public function Index($message = "")
        {
            require_once(VIEWS_PATH."Home.php");
        } 


        public function vistaTipocuenta (){
            require_once(VIEWS_PATH."tipodecuenta.php");
        }

        public function registerKeeper (){
            require_once (VIEWS_PATH."Sign-upKeeper.php");
        }
        
        public function vistaLogin (){
            require_once(VIEWS_PATH."Login.php");
        }


        public function login ($usuario , $contraseña){
           $listaOwners = array () ;
           $listaKeepers = $this->keeperDao->obtenerDatos() ;

        }

        public function registrarOwner (){
            require_once(VIEWS_PATH."Sing-upOwner.php");
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
                $this->registrarOwner();
            }

        }

    }
?>