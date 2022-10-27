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
            
            $keeper = $_SESSION['loggedUser'];
            $verificar = $this->keeperDao->verificarRangos ($desde,$hasta,$keeper->getNombreUser() );
            $fechaDeldia=$this->keeperDao->verificarFechadeldia($desde , $hasta);
            echo $fechaDeldia;

           if ($verificar ==null && $fechaDeldia ==true){
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



    }
?>