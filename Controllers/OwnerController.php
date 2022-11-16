<?php

    namespace Controllers ;

    ///use DAO\OwnerDao;
    use DAOSQL\OwnerDAO;
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
            echo "<script>if(confirm('Pago realizado con exito'));</script>";
            require_once (VIEWS_PATH."check.php");
            require_once (VIEWS_PATH."navOwner.php");
            require_once (VIEWS_PATH."menu-owner.php");
        }

        
        public function vistaNuevatarjeta (){
            require_once (VIEWS_PATH."check.php");
            require_once (VIEWS_PATH."navOwner.php");
            require_once(VIEWS_PATH."agregarTarjeta.php");
        }

 
        public function vistaSimulacionpago (){
            $owner = $_SESSION['loggedUser'];
            $tarjeta= null ;
            $ownerdao = new OwnerDao();
            $tarjeta = $ownerdao->buscarTarjeta($owner->getNombreUser());
            var_dump($tarjeta);
            $reserva = $_SESSION['reserva'];
            $keeper = $reserva->getKeeper();
            $pet = $reserva->getPet();
 
            require_once (VIEWS_PATH."simulacionPago.php");
        }

        public function AgregarTarjeta ($nombre , $apellido , $numero , $codigo ,$vencimiento){
            $owner = $_SESSION['loggedUser'];
            $tarjeta = new Tarjeta( );
            $tarjeta->setNombre($nombre);
            $tarjeta ->setNumero($numero);
            $tarjeta ->setCodigo($codigo);
            $tarjeta->setFechaVenc($vencimiento);
            $tarjeta->setApellido($apellido);
            $this->ownerdao->agregarTarjeta($owner->getNombreUser() ,$tarjeta);
            $this->vistaSimulacionpago();
        }

   

    }


?>