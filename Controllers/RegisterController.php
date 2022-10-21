<?php 
    namespace Controllers ;

    use DAO\KeeperDAO as KeeperDao;
    use DAO\OwnerDAO as OwnerDAO;
    use Models\Keeper as Keeper;
    use Models\Owner as Owner;

    class RegisterController {

        private $keeperDAO ;
        private $homeController ;
        private $OwnerDAO ;


        public function __construct()
        {
            $this->keeperDAO = new KeeperDAO ();
            $this->ownerDAO = new OwnerDAO ();
            $this->homeController = new HomeController ();
        }

        public function login (){
            require_once(VIEWS_PATH."Sign-up.php");
        }


        public function registrarKeeper (){
            
            require_once(VIEWS_PATH."Sign-upKeeper.php");
        }

        

        public function agregarKeeper ($userName , $contrasena , $remuneracion){

            
            $tipoMascota = array ();
            for ($x=1; $x <=3 ; $x++){
                if ($_POST['mascota'.$x] !=null){
                    array_push ($tipoMascota , $_POST['mascota'.$x]);
                }
            }
            $keeper = new Keeper($userName,$contrasena,$_SESSION['keeper'],$tipoMascota,$remuneracion);
            $this->keeperDAO->addKeeper($keeper);
            $this->registrarKeeper();
          
            
        }

        public function registrarOwner (){
            
            require_once(VIEWS_PATH."Sign-upOwner.php");
        }

        

        public function agregarOwner ($userName , $contrasena){

            
            $owner = new Owner($userName,$contrasena,$_SESSION['owner']);
            $this->ownerDAO->addKeeper($owner);
            $this->registrarKeeper();
          
            
        }







    }
?>