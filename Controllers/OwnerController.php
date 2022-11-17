<?php

    namespace Controllers ;

    //SQL
    use DAOSQL\OwnerDAO;
    use DAOSQL\PetDAO;
    use DAOSQL\ReservaDAO;

    //JSON
    //use DAO\ReservaDAO;
    ///use DAO\OwnerDao;
   
    use Exception;
    use Models\Tarjeta;
        use Models\Estadoreserva;

    class OwnerController {
        private $ownerdao ;
        private $reservaDao ;
        private $petDao ;

        public function __construct()
        {
            $this->ownerdao=new OwnerDao();
            $this->reservaDao = new ReservaDAO();
            $this->petDao = new PetDAO ();
        }



        public function principalOwner (){
            echo "<script>if(confirm('Pago realizado con exito'));</script>";
            $user = $_SESSION['loggedUser'];
            try
            {
                $petlist = $this->petDao->buscarPets($user->getNombreUser());
                $lista=$this->reservaDao->GetAll();
                $listaAceptada = $this->reservaDao->buscarReservaxEstado($lista,$user->getNombreUser(), Estadoreserva::Aceptada);
                $ListaEnCurso = $this->reservaDao->buscarReservaxEstado($lista,$user->getNombreUser(),Estadoreserva::Confirmada);

            }
            catch (Exception $ex)
            {

                throw $ex ;
            }
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