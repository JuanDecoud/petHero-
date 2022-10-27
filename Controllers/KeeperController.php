<?php 
    namespace Controllers ;

    use DAO\KeeperDAO;
    use Models\FechasEstadias;

    class KeeperController {
        private $keeperDao ;

        public function __construct()
        {
            $this->keeperDao = new KeeperDAO();
        }

        
        public function principalKeeper (){
            require_once(VIEWS_PATH."mainKeeper.php");
        }


        public function asignarFecha ($desde , $hasta ){
            $estadia = new FechasEstadias($desde , $hasta);

           $verificar = $this->keeperDao->verificarRangos ($desde,$hasta,$_SESSION['loggedUser'] );

           if ($verificar == false){
                $keeper = $_SESSION['loggedUser'];
                $this->keeperDao->agregarFecha($estadia , $keeper->getNombreUser() );
                $this->principalKeeper(); 
           }
           else {
                echo '<script language="javascript">alert("Rango de fechas repetido");</script>';
                $this->principalKeeper();
           }
  
        }

        public function quitarFecha ($desde , $hasta ){
            $estadia = new FechasEstadias($desde , $hasta);
            $user = $_SESSION['loggedUser'];
            $this->keeperDao->quitarFecha($user->getNombreUser(),$estadia);
            $this->principalKeeper();

        }



    }
?>