<?php 
    namespace Controllers ;

   // use DAO\KeeperDAOSQL as KeeperDAO;
    use DAO\KeeperDAO;
    use Models\FechasEstadias;
    use Models\Reserva;
    use DAO\ReservaDAO;
    use Models\Estadoreserva;
    use Models\Keeper;

    class KeeperController {
        private $keeperDao ;
        private $reservaDao ;

        public function __construct()
        {
            $this->keeperDao = new KeeperDAO();
            $this->reservaDao = new ReservaDAO();
        }

        
        public function principalKeeper (){

          require_once (VIEWS_PATH."navKeeper.php");

            $keeper = $_SESSION['loggedUser'];
            $fechas = $this->keeperDao->buscarEstadias($keeper->getNombreUser());
            $lista = $this->reservaDao->getAll();
            $listaReservas = $this->reservaDao->buscarReservaxEstadoKeeper($lista , $keeper->getNombreUser (),Estadoreserva::Pendiente);
            $listaAceptadas = $this->reservaDao->buscarReservaxEstadoKeeper( $lista ,$keeper->getNombreUser (), Estadoreserva::Aceptada);
            $listaConfirmadas = $this->reservaDao->buscarReservaxEstadoKeeper($lista , $keeper->getNombreUser() ,Estadoreserva::Confirmada );
            require_once(VIEWS_PATH."mainKeeper.php");
        }
        


        public function asignarFecha ($desde , $hasta ){

         
            $keeper = $_SESSION['loggedUser'];
            $verificar = null;
            $this->keeperDao->verificarRangos ($desde,$hasta,$keeper->getNombreUser() );
            $fechaDeldia=$this->keeperDao->verificarFechadeldia($desde , $hasta);
            $lista = $this->reservaDao->GetAll();
            $EstadiaEnCurso = $this->reservaDao->buscarReservaEnCurso($lista,$keeper->getNombreUser(),Estadoreserva::Confirmada ,$desde ,$hasta);

      
           if ($verificar ==null && $fechaDeldia ==true && $EstadiaEnCurso == null){
                $estadia = new FechasEstadias($desde , $hasta);
                $this->keeperDao->agregarFecha($estadia , $keeper->getNombreUser() );
                $this->principalKeeper(); 
           }
           else {
                echo '<script language="javascript">alert("Rango de fechas repetido o fecha ingresada inferior a la actual");</script>';
                $this->principalKeeper();
           }
  
        }

        public function quitarFecha ($desde , $hasta ){
            $estadia = new FechasEstadias($desde , $hasta);
            $user = $_SESSION['loggedUser'];
            $this->keeperDao->quitarFecha($user->getNombreUser(),$estadia);
            $this->principalKeeper();

        }
        /*
        public function rechazarReserva($petName){
            $borrarReserva = new ReservaDAO();

            $user = $_SESSION['loggedUser'];
            $borrarReserva -> borrarReservaxNombre($user->getNombre(),$petName);
            $this->principalKeeper();
        }

        
        public function aceptarReserva($petName){

            $buscarReserva = new ReservaDAO();
            $user = $_SESSION['loggedUser'];
            $reserva = new Reserva();
            $reserva = $buscarReserva -> buscarReserva($user->getNombre(), $petName);
            $keeper = $this->keeperDao->obtenerUser($user->getNombre());
            $keeper->agregarReservaAceptada($reserva);
        }
        */

    }
?>