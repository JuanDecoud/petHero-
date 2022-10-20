<?php
    namespace Controllers;

    class HomeController
    {
        private $registerC  ;

  
      public function __construct()
      {
        
      }

        public function Index($message = "")
        {
            require_once(VIEWS_PATH."Home.php");
        } 


        public function vistaTipocuenta (){
            require_once(VIEWS_PATH."tipodecuenta.php");
        }
        
    

        public function seleccinarCuenta ($tipoCuenta){
            $this->registerC = new RegisterController();
            $tipo = $tipoCuenta ;
            if ($tipo == "Keeper"){
                $_SESSION['keeper'] =$tipo; 
                $this->registerC->registrarKeeper();
            }

        }
    }
?>