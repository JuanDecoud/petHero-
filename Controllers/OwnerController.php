<?php

    namespace Controllers ;

    use DAO\OwnerDao;
    use DAO\ReservaDAO;
    use Models\Tarjeta;
    use Models\Estadoreserva;

    class OwnerController {
        private $ownerdao ;
        private $reservaDao ;

        public function __construct()
        {
            $this->ownerdao=new OwnerDao();
            $this->reservaDao = new ReservaDAO();
        }

        public function principalOwner (){
            require_once (VIEWS_PATH."menu-owner.php");
        }

        
        public function vistaNuevatarjeta (){
            require_once(VIEWS_PATH."agregarTarjeta.php");
        }

 
        public function vistaSimulacionpago (){
            require_once (VIEWS_PATH."simulacionPago.php");
        }

        public function AgregarTarjeta ($nombre , $apellido , $numero , $codigo ,$vencimiento){
            $owner = $_SESSION['loggedUser'];
            $tarjeta = new Tarjeta($numero , $nombre , $apellido , $codigo , $vencimiento );
            $this->ownerdao->agregarTarjeta($owner->getNombreUser() ,$tarjeta);
            $this->vistaSimulacionpago();
        }

   

    }


?>