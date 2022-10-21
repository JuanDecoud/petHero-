<?php 
    namespace Controllers ;

    use DAO\KeeperDAO as KeeperDao;
    use DAO\OwnerDAO as OwnerDAO;
    use DAO\PetDAO as PetDAO;
    use Models\Keeper as Keeper;
    use Models\Owner as Owner;
    use Models\Pet as Pet;

    class RegisterController {

        private $homeController ;
        private $keeperDAO ;
        private $ownerDAO ;
        private $petDAO ;


        public function __construct()
        {
            $this->keeperDAO = new KeeperDAO ();
            $this->ownerDAO = new OwnerDAO ();
            $this->petDAO = new PetDAO ();            
        }

        public function login (){
            require_once(VIEWS_PATH."Login.php");
        }

        public function registrarKeeper (){
            
            require_once(VIEWS_PATH."Sign-upKeeper.php");
        }
        public function registrarOwner (){
            
            require_once(VIEWS_PATH."Sign-upOwner.php");
        }
        public function registrarMascota (){
            
            require_once(VIEWS_PATH."Sign-upMascota.php");
        }

        public function principalKeeper (){
            require_once(VIEWS_PATH."mainKeeper.php");
        }
        public function menuOwner (){
            require_once(VIEWS_PATH."menu-owner.php");
        }

        public function agregarOwner ($userName , $contrasena ){

            $owner = new Owner ($userName ,$contrasena , $_SESSION['owner']);
            $this->ownerDAO->Add($owner);
            $this->login();
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

        public function agregarMascota ($nombre , $owner, $raza, $tamano, $planVacunacion, $observacionesGrals){

            $pet = new Pet ();
            $pet->setNombre($nombre);
            $pet->setOwner($owner);
            $pet->setRaza($raza);
            $pet->setTamano($tamano);
            $pet->setPlanVacunacion($planVacunacion);
            $pet->setObservacionesGrals($observacionesGrals);
            $this->petDAO->Add($pet);
            $this->registrarMascota();
        }

        public function asignarFecha ($fecha){
            $this->keeperDAO->agregarFecha($fecha);
            $this->principalKeeper();   
        }

        
        public function ShowListViewKeeper()
        {
            $keeperList = $this->keeperDAO->GetAll();

            require_once(VIEWS_PATH."List-AllKeepers.php");
        }




    }
?>