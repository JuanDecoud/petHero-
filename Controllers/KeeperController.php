<?php 
    namespace Controllers ;

    //SQL-------------

    use DAOSQL\KeeperDAO as KeeperDAO;
    use DAOSQL\ReservaDAO as ReservaDAO ;
    
    //JSON-------------
    //use DAO\KeeperDAO as KeeperDAO;
    //use DAO\ReservaDAO as ReservaDAO;

    use Models\FechasEstadias;
    use Models\Estadoreserva;
    use Exception;


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
            try
            {
                $fechas = $this->keeperDao->buscarEstadias($keeper->getNombreUser());
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
        
        

        public function asignarFecha ($desde , $hasta ){

            try
            {
                $keeper = $_SESSION['loggedUser'];
                $verificar = null;
                $verificar=$this->keeperDao->verificarRangos ($desde,$hasta,$keeper->getNombreUser() );
                
               if ($verificar ==null){
                    $estadia = new FechasEstadias($desde , $hasta);
                    $this->keeperDao->agregarFecha($estadia , $keeper->getNombreUser() );
                    $this->principalKeeper(); 
               }
               else {
                    echo '<script language="javascript">alert("Rango de fechas repetido o fecha ingresada inferior a la actual");</script>';
                    $this->principalKeeper();
               }

            }
            catch (Exception $ex)
            {
                echo '<script language="javascript">alert("Error");</script>';
                $this->principalKeeper();
            }

        }

        public function quitarFecha ($desde , $hasta ){

           try
           {
                $estadia = new FechasEstadias($desde , $hasta);
                $user = $_SESSION['loggedUser'];
                $this->keeperDao->quitarFecha($user->getNombreUser(),$estadia);
                $this->principalKeeper();

           }
           catch (Exception $ex)
           {
                throw $ex;
           }

        }


    }
?>