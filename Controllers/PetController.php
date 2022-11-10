<?php 
    namespace Controllers ;
    
    use DAO\OwnerDAOSQL as OwnerDao;
    //use DAO\OwnerDao;
    use DAO\PetDAO as petDAO;
    use Models\Pet as Pet ;

    class PetController {

        private $petDao ;
        private $ownerDao ;


        public function __construct()
        {
            $this->petDao = new PetDAO ();
            $this->ownerDao = new OwnerDao();
        }
/*
        public function agregarMascota ($nombre , $raza, $tamano, $planVacunacion, $observacionesGrals){
            $owner = $_SESSION['loggedUser'];
            $pet = new Pet ();
            $pet->setNombre($nombre);
            $pet->setOwner($owner);
            $pet->setRaza($raza);
            $pet->setTamano($tamano);
            $pet->setPlanVacunacion($planVacunacion);
            $pet->setObservacionesGrals($observacionesGrals);
            $this->petDAO->Add($pet);
            $this->agregarPet();
        }
*/
        public function agregarMascota ($nombre , $raza ,$tamanio , $observacion ){
          
            
            $target_dir = VIEWS_PATH."/img/uploads/";
            $target_file1 = $target_dir.basename($_FILES["imagenPerfil"]["name"]);
            $target_file2 = $target_dir.basename($_FILES["vacunacion"]["name"]);
            $target_file3 = $target_dir.basename($_FILES["video"]["name"]);

            move_uploaded_file($_FILES["imagenPerfil"]["tmp_name"], $target_file1);
            move_uploaded_file($_FILES["vacunacion"]["tmp_name"], $target_file2);
            move_uploaded_file($_FILES["video"]["tmp_name"], $target_file3);

            $owner = $_SESSION['loggedUser'];
            $pet = new Pet ();
            $pet->setNombre($nombre);
            $pet->setOwner($owner);
            $pet->setRaza($raza);
            $pet->setTamano($tamanio);
            $pet->setImg(FRONT_ROOT.VIEWS_PATH."/img/uploads/".basename($_FILES['imagenPerfil']['name']));
            $pet->setPlanVacunacion(FRONT_ROOT.VIEWS_PATH."/img/uploads/".basename($_FILES['vacunacion']['name']));
            $pet->setVideo(FRONT_ROOT.VIEWS_PATH."/img/uploads/".basename($_FILES['video']['name']));
            $pet->setObservacionesGrals($observacion);
            $this->petDao->GetAll();
            $this->petDao->Add($pet);
            var_dump($owner);
        
            // asocia al owner con la mascota
            $this->ownerDao->agregarPets($owner->getNombreUser() , $pet);
            $this->principalOwner();

       
        }

        public function principalOwner (){
            require_once(VIEWS_PATH."menu-owner.php");
        }

      

        public function agregarPet (){
            require_once(VIEWS_PATH."registrarMascota.php");
        }
    }
?>