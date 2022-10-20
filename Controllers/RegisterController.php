<?php 
    namespace Controllers ;

    use DAO\KeeperDAO as KeeperDao;
    use Models\Keeper as Keeper;

    class RegisterController {

        private $keeperDAO ;
        private $OwnerDAO ;


        public function __construct()
        {
            $this->keeperDAO = new KeeperDAO ();
        }

        public function login (){
            require_once(VIEWS_PATH."Sign-up.php");
        }


        public function registrar (){
            require_once(VIEWS_PATH."Sign-upKeeper.php");
        }

        public function agregar ($userName , $contrasena , $remuneracion){


            $tipoMascota = array ();
            for ($x=1; $x <=3 ; $x++){
                if ($_POST['mascota'.$x] !=null){
                    array_push ($tipoMascota , $_POST['mascota'.$x]);
                }
            }
            $keeper = new Keeper($userName,$contrasena,"Keeper",$tipoMascota,$remuneracion);
            $this->keeperDAO->addKeeper($keeper);
            $this->registrar();
          
            
        }



    }
?>