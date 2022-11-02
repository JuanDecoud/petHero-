<?php 
    namespace Controllers ;

    use DAO\KeeperDAO;
    use DAO\PetDAO ;
    use DAO\ReservaDAO ;
    use Models\Reserva ;
    use Models\FechasEstadias ;

    class ReservaController {

        private KeeperDAO $keeperdao;
        private PetDAO $petdao ;
        private ReservaDAO $reservaDao ;

        public function __construct()
        {
            $this->keeperdao = new KeeperDAO();
            $this->petdao = new PetDAO ();
            $this->reservaDao = new ReservaDAO ();
            
        }
        public function vistaKeeper (){
            require_once (VIEWS_PATH."mainKeeper.php");
        }

        public function vistaOwner (){
            require_once (VIEWS_PATH."menu-owner.php");
        }

        public function solicitadudEstadia ($nombreKeeper ,  $fechainicio , $fechaFin ,$nombreMascota ){
                $keeper = $this->keeperdao->obtenerUser($nombreKeeper);
                $pet = $this->petdao->retrievePet($nombreMascota);
                $importeTotal = $keeper->getRemuneracion ();
                $importeReserva = ($importeTotal/2) ;

                $reserva = new Reserva ();
                $reserva->setImporteTotal($importeTotal);
                $reserva->setImporteReserva($importeReserva);
                $reserva->setFechadesde($fechainicio);
                $reserva->setFechahasta($fechaFin);
                $reserva->setPet($pet);
                $reserva->setKeeper($keeper);
                $this->reservaDao->Add ($reserva);

                $this->vistaOwner();     
        }

        public function  keepersPorfecha ($desde , $hasta){
   
            $keeperlist = array ();
            $keeperlist = $this->keeperdao->estadiasPorfecha($desde , $hasta);
            require_once(VIEWS_PATH."menu-owner.php");
            require_once(VIEWS_PATH."actualizarKeepers.php");
        }


        public function listaKeepers (){

            $keeperlist = $this->keeperdao->getAll();
            $listaEstadias = $this->keeperdao->listaEstadias($keeperlist);
            require_once(VIEWS_PATH."menu-owner.php");
            require_once(VIEWS_PATH."actualizarKeepers.php");
        }

        public function aceptarReserva ($desde , $hasta){

            $this->reservaDao->cambiarEstado($desde , $hasta);
            $estadia = new FechasEstadias($desde , $hasta);
            $user = $_SESSION['loggedUser'];
            $this->keeperdao->quitarFecha($user->getNombreUser(), $estadia);
            $this->vistaKeeper();
        }

    

    }
?>