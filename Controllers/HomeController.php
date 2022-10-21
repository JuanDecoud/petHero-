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


        public function principalKeeper (){
            require_once(VIEWS_PATH."mainKeeper.php");
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

        public function menuOwner (){
            require_once(VIEWS_PATH."menu-owner.php");
        }


        public function login ($usuario , $contraseña){
             $userkeeper = $this->keeperDao->obtenerUser($usuario , $contraseña);
             $userOwner = $this->ownerDao->obtenerUser($usuario , $contraseña);

            
             

             if ($userkeeper !=null){
                $_SESSION['loggedUser'] = $userkeeper ;
                $this->principalKeeper();  
             }
             else if ($userOwner !=null){
                $_SESSION['loggedUser'] = $userOwner ;
                $this->menuOwner();
             }
             

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