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
    use Models\Reserva as Reserva;
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
            try
            {
                $fechas = $this->keeperdao->buscarEstadias($keeper->getNombreUser());
                $lista = $this->reservaDao->getAll();
                $listaReservas = $this->reservaDao->buscarReservaxEstadoKeeper($lista , $keeper->getNombreUser (),Estadoreserva::Pendiente);
                $listaAceptadas = $this->reservaDao->buscarReservaxEstadoKeeper( $lista ,$keeper->getNombreUser (), Estadoreserva::Aceptada);
                $listaConfirmadas = $this->reservaDao->buscarReservaxEstadoKeeper($lista , $keeper->getNombreUser() ,Estadoreserva::Confirmada );

            }
            catch (Exception $ex)
            {
                throw $ex ;
            }

            require_once (VIEWS_PATH."mainKeeper.php");
        }

        public function vistaOwner (){
            require_once (VIEWS_PATH."check.php");
            require_once (VIEWS_PATH."navOwner.php");
            $user = $_SESSION['loggedUser'];
            try
            { 

                $petlist = $this->petdao->buscarPets($user->getNombreUser());
                $lista=$this->reservaDao->getAll();
                $listaAceptada = $this->reservaDao->buscarReservaxEstado($lista,$user->getNombreUser(), Estadoreserva::Aceptada);
                $ListaEnCurso = $this->reservaDao->buscarReservaxEstado($lista,$user->getNombreUser(),Estadoreserva::Confirmada);
                require_once (VIEWS_PATH."menu-owner.php");
            
            }
            catch (Exception $ex)
            {
                throw $Ex;
            }

        }

        public function seleccionarDias ($nombreKeeper ,$tipoMascota,  $fechainicio , $fechaFin ,$nombreMascota ){

                $user = $_SESSION ['loggedUser'];

               

            try
            {   
               
              
                // busco las reservas 
                $listaReservas = $this->reservaDao->getALL();

                /* validaciones para las reservas
                ----------------------------------
                 Evitan que si una pet tiene ya iniciado el proceso de reserva 
                 no le permita hacer nuevas  hasta que el keeper acepte o rechace  y tambien que si la misma
                 fue confirmada, no le permita, realizar otra  antes de terminar la estadia . asi como tambien
                 verifican que el keeper cuide mascotas del tamaño solicitado por el owner*/
                 
                 
                $pet = $this->petdao->buscarPet($nombreMascota , $user);
                
                $tamanio = in_array ($pet->getTamano() , $tipoMascota);
                
                $buscarReservaPendiente = $this->reservaDao->buscarReservaxPet($listaReservas , $nombreMascota 
                ,$user->getNombreUser(), Estadoreserva::Pendiente);
                $reservaEncurso=$this->reservaDao->buscarReservaxPet($listaReservas , $nombreMascota
                ,$user->getNombreUser(), Estadoreserva::Confirmada);
                




                if ($tamanio == true && $buscarReservaPendiente == null && $reservaEncurso == null)
                {
                        $nombreKeeper = $nombreKeeper ;
                        $nombreMascota = $nombreMascota ;
                        $fechaInicio = $fechainicio ;
                        $fechaFin = $fechaFin ;
                        $array_fechas = $this->reservaDao->fechasRango($fechaInicio , $fechaFin ,$nombreKeeper);
                        require_once(VIEWS_PATH."check.php");
                        require_once (VIEWS_PATH."navOwner.php");
                        require_once (VIEWS_PATH."mostrarFechas.php");
                    
                }
                else {
                        
                         echo '<script language="javascript">alert("Tamaño de mascota no permitide por el cuidador o Pet ya posee una reserva");</script>';
                        $this->vistaOwner();
            
                    }
                    
                }
                catch (Exception $Ex)
                {
                    throw $Ex;
                }

        }

        public function solicitadudEstadia ($nombreKeeper , $nombreMascota ,$arregloDias ){

            try
            {
                $user = $_SESSION['loggedUser'];
                $keeper = $this->keeperdao->obtenerUser($nombreKeeper);
                $pet= $this->petdao->buscarPet($nombreMascota , $user);
                $importeTotal = $keeper->getRemuneracion();
                $importeTotal = floatval($importeTotal*(count($arregloDias)));
                $importeReserva = ($importeTotal/2) ;
                $reserva = new Reserva ();
                $reserva->setImporteTotal($importeTotal);
                $reserva->setImporteReserva($importeReserva);
                $reserva->setDias($arregloDias);
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
            try
            {
                $keeperlist = $this->keeperdao->estadiasPorfecha($desde , $hasta);
                $user = $_SESSION['loggedUser'];
                $petlist = $this->petdao->buscarPets($user->getNombreUser());
                $this->vistaOwner();
                require_once(VIEWS_PATH."actualizarKeepers.php");

            }
            catch (Exception $ex)
            {
                throw $ex;
            }

        }

        public function listaKeepers (){

            $keeperlist = $this->keeperdao->getAll();
           // $listaEstadias = $this->keeperdao->listaEstadias($keeperlist);
           
            $this->vistaOwner();
            $user = $_SESSION['loggedUser'];
            $petlist = $this->petdao->buscarPets($user->getNombreUser());
            require_once(VIEWS_PATH."actualizarKeepers.php");
        }

        public function aceptarReserva ($owner , $pet ,$arregloDias){

            $user = $_SESSION['loggedUser'];
            try
            {
                $this->reservaDao->cambiarEstado($owner , $pet , $user->getNombreUser() , Estadoreserva::Aceptada);
                $this->reservaDao->comprobarRango($user->getNombreUser());

            }
            catch (Exception $ex)
            {
                throw $ex ;
            }

            $this->vistaKeeper();
        }

        public function vistaPago (){
            
            $owner = $_SESSION['loggedUser'];
            $tarjeta= null ;
            $ownerdao = new OwnerDao();
            $tarjeta = $ownerdao->buscarTarjeta($owner->getNombreUser());

            $reserva = $_SESSION['reserva'];
            $keeper = $reserva->getKeeper();
            $pet = $reserva->getPet();
 
            require_once(VIEWS_PATH."check.php");
            require_once(VIEWS_PATH."simulacionPago.php");
        }


        public function  simulacionPago ( $pet,$keeper){

            $user = $_SESSION['loggedUser'];
            $this->reservaDao->cambiarEstado($user->getNombreUser() , $pet , $keeper , Estadoreserva::Confirmada);

            // buscar y crea la reserva para guardarla en un session
            $lista=$this->reservaDao->getALL();
            $reservaLista = $this->reservaDao->buscarReservaEnCurso($lista,$user->getNombreUser(),Estadoreserva::Confirmada);
            $reservaNueva = null ;

            foreach($reservaLista as $reserva){
                $reservaNueva = new Reserva ();
                $reservaNueva->setDias($reserva->getDias());
                $reservaNueva->setPet($reserva->getPet());
                $reservaNueva->setKeeper($reserva->getKeeper());
                $reservaNueva->setImporteTotal($reserva->getImporteTotal());
                $reservaNueva->setImporteReserva($reserva->getImporteReserva());
                $reservaNueva->setEstado ($reserva->getEstado());

            }

            $_SESSION['reserva'] = $reservaNueva;

            $comprobartarjeta = $this->ownerdao->buscarTarjeta($user->getNombreUser());
        
            var_dump($comprobartarjeta);
            
            /// si el usuario no tiene tarjeta se ingresa una sino directamente se pasa al pago 

           if ($comprobartarjeta == null){
                $this->agregarTarjeta();
            }
            else {
                $this->vistaPago();
            }
        
        }

        public function agregarTarjeta (){
            require_once(VIEWS_PATH."check.php");
            require_once(VIEWS_PATH."agregarTarjeta.php");
        }

        public function rechazarReserva($owner , $pet){
            try 
            {
                $user = $_SESSION['loggedUser'];
                $this->reservaDao->borrarReserva($owner,$pet,$user->getNombreUser());
                $this->vistaKeeper();

            }
            catch (Exception $ex)
            {
                throw $ex ;
            }

        }

    }
?>