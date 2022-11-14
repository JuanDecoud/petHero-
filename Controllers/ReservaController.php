<?php 
    namespace Controllers ;

    //SQL 
    use DAOSQL\KeeperDAO as KeeperDAO ;
    use DAOSQL\ReservaDAO as ReservaDAO ;
    use DAOSQL\PetDAO as PetDAO ;
    use DAOSQL\OwnerDAO as OwnerDAO ;
use Exception;
//JSON
    /*
    use DAO\KeeperDAO as KeeperDAO;
    use DAO\OwnerDao as OwnerDAO ;
    use DAO\PetDAO as PetDao ;
    use DAO\ReservaDAO  as ReservaDAO;
    */
    //MODELS
    use Models\Estadoreserva;
    use Models\Reserva ;
    use Models\FechasEstadias ;
    use Models\Pet ;

    class ReservaController {

        private KeeperDAO $keeperdao;
        private PetDAO $petdao ;
        private ReservaDAO $reservaDao ;
        private OwnerDAO $ownerdao ;
        

        public function __construct()
        {
            $this->keeperdao = new KeeperDAO();
            $this->petdao = new PetDAO ();
            $this->reservaDao = new ReservaDAO ();
            $this->ownerdao = new OwnerDao();
            
        }
        public function vistaKeeper (){
            require_once (VIEWS_PATH."navKeeper.php");
            $keeper = $_SESSION['loggedUser'];
            $fechas = $this->keeperdao->buscarEstadias($keeper->getNombreUser());
            $lista = $this->reservaDao->getAll();
            $listaReservas = $this->reservaDao->buscarReservaxEstadoKeeper($lista , $keeper->getNombreUser (),Estadoreserva::Pendiente);
            $listaAceptadas = $this->reservaDao->buscarReservaxEstadoKeeper( $lista ,$keeper->getNombreUser (), Estadoreserva::Aceptada);
            $listaConfirmadas = $this->reservaDao->buscarReservaxEstadoKeeper($lista , $keeper->getNombreUser() ,Estadoreserva::Confirmada );
            require_once (VIEWS_PATH."mainKeeper.php");
        }

        public function vistaOwner (){
            require_once (VIEWS_PATH."check.php");
            require_once (VIEWS_PATH."navOwner.php");
            $user = $_SESSION['loggedUser'];
            $petlist = $this->petdao->buscarPets($user->getNombreUser());
            $lista=$this->reservaDao->getAll();
            $listaAceptada = $this->reservaDao->buscarReservaxEstado($lista,$user->getNombreUser(), Estadoreserva::Aceptada);
            $ListaEnCurso = $this->reservaDao->buscarReservaxEstado($lista,$user->getNombreUser(),Estadoreserva::Confirmada);
            require_once (VIEWS_PATH."menu-owner.php");
        }

        public function seleccionarDias ($nombreKeeper ,  $fechainicio , $fechaFin ,$nombreMascota ){

            $nombreKeeper = $nombreKeeper ;
            $nombreMascota = $nombreMascota ;
            $fechaInicio = $fechainicio ;
            $fechaFin = $fechaFin ;
            $array_fechas = $this->reservaDao->fechasRango($fechaInicio , $fechaFin ,$nombreKeeper);
            require_once(VIEWS_PATH."check.php");
            require_once (VIEWS_PATH."navOwner.php");
            require_once (VIEWS_PATH."mostrarFechas.php");

        }

        public function solicitadudEstadia ($nombreKeeper , $nombreMascota ,$arreglo ){

            try
            {
                $user = $_SESSION['loggedUser'];

                $keeper = $this->keeperdao->obtenerUser($nombreKeeper);
               
                $pet= $this->petdao->buscarPet($nombreMascota , $user);
                
                $importeTotal = $keeper->getRemuneracion();
                $importeTotal = floatval($importeTotal*(count($arreglo)));
                $importeReserva = ($importeTotal/2) ;
               

                $reserva = new Reserva ();
                $reserva->setImporteTotal($importeTotal);
                $reserva->setImporteReserva($importeReserva);
                $reserva->setDias($arreglo);
                $reserva->setPet($pet);
                $reserva->setKeeper($keeper);
                $this->reservaDao->Add ($reserva);

                $this->vistaOwner(); 

            }
            catch (Exception $ex)
            {
                throw $ex ;
            }

        }

        public function  keepersPorfecha ($desde , $hasta){
   
            $keeperlist = array ();
            $keeperlist = $this->keeperdao->estadiasPorfecha($desde , $hasta);
            $user = $_SESSION['loggedUser'];
            $petlist = $this->petdao->buscarPets($user->getNombreUser());
            $this->vistaOwner();
            require_once(VIEWS_PATH."actualizarKeepers.php");
        }

        public function listaKeepers (){

            $keeperlist = $this->keeperdao->getAll();
            $listaEstadias = $this->keeperdao->listaEstadias($keeperlist);
            $this->vistaOwner();
            $user = $_SESSION['loggedUser'];
            $petlist = $this->petdao->buscarPets($user->getNombreUser());
            require_once(VIEWS_PATH."actualizarKeepers.php");
        }

        public function aceptarReserva ($owner , $pet){

            echo $owner ;
            echo $pet ;
            $user = $_SESSION['loggedUser'];
            $this->reservaDao->cambiarEstado($owner , $pet , $user->getNombreUser() , Estadoreserva::Aceptada);
            //$estadia = new FechasEstadias($desde , $hasta);
            
            //$this->keeperdao->quitarFecha($user->getNombreUser(), $estadia);
            $this->vistaKeeper();
        }

        public function vistaPago (){
            require_once(VIEWS_PATH."simulacionPago.php");
        }


        public function  simulacionPago ($desde , $hasta ,$keeper, $importe){

 
            $user = $_SESSION['loggedUser'];
            // Confirma la reserva
            //$this->reservaDao->cambiarEstado($desde , $hasta , $keeper , Estadoreserva::Confirmada);

            // buscar y crea la reserva para guardarla en un session

            $lista=$this->reservaDao->getLista();
            //$reservaLista = $this->reservaDao->buscarReservaEnCurso($lista,$keeper,Estadoreserva::Confirmada,$desde,$hasta);
            $reservaNueva = null ;
           /* foreach($reservaLista as $reserva){
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
            $comprobartarjeta = $this->ownerdao->buscarTarjeta($user->getNombreUser());
        
            
            
            /// si el usuario no tiene tarjeta se ingresa una sino directamente se pasa al pago 

            if ($comprobartarjeta == null){
                $this->agregarTarjeta();
            }
            else {
                $this->vistaPago();
            }
            */
        }

        public function agregarTarjeta (){
            require_once(VIEWS_PATH."agregarTarjeta.php");
        }

        public function rechazarReserva($owner , $pet){
    
            $user = $_SESSION['loggedUser'];
            $this->reservaDao->borrarReserva($owner,$pet,$user->getNombreUser());
            $this->vistaKeeper();
        }

    }
?>