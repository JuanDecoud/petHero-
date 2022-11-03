<?php 
    namespace Controllers ;

    use DAO\KeeperDAO;
    use DAO\PetDAO ;
    use DAO\ReservaDAO ;
    use Models\Estadoreserva;
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

            $user = $_SESSION['loggedUser'];
            $this->reservaDao->cambiarEstado($desde , $hasta , $user->getNombreUser() , Estadoreserva::Aceptada);
            $estadia = new FechasEstadias($desde , $hasta);
            
            $this->keeperdao->quitarFecha($user->getNombreUser(), $estadia);
            $this->vistaKeeper();
        }

        public function vistaPago (){
            require_once(VIEWS_PATH."simulacionPago.php");
        }


        public function  simulacionPago ($desde , $hasta ,$keeper, $importe){

 
            $user = $_SESSION['loggedUser'];
            // Confirma la reserva
            $this->reservaDao->cambiarEstado($desde , $hasta , $keeper , Estadoreserva::Confirmada);

            // buscar y crea la reserva para guardarla en un session

            $lista=$this->reservaDao->getLista();
            $reservaLista = $this->reservaDao->buscarReservaEnCurso($lista,$keeper,Estadoreserva::Confirmada,$desde,$hasta);
            $reservaNueva = null ;
            foreach($reservaLista as $reserva){
                $reservaNueva = new Reserva ();
                $reservaNueva->setFechadesde($reserva->getFechadesde());
                $reservaNueva->setFechahasta($reserva->getFechahasta());
                $reservaNueva->setPet($reserva->getPet());
                $reservaNueva->setKeeper($reserva->getKeeper());
                $reservaNueva->setImporteTotal($reserva->getImporteTotal());
                $reservaNueva->setImporteReserva($reserva->getImporteReserva());
                $reservaNueva->setEstado ($reserva->getEstado());

            }
            $_SESSION['reserva'] = $reservaNueva;
        
           
            
            /// si el usuario no tiene tarjeta se ingresa una sino directamente se pasa al pago 

            if ($user->getTarjeta() == null){
                $this->agregarTarjeta();
            }
            else {
                $this->vistaPago();
            }
 
        }

        public function agregarTarjeta (){
            require_once(VIEWS_PATH."agregarTarjeta.php");
        }



    }
?>