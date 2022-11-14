<?php 
    namespace Controllers ;

    // JSON-------------------
    //use DAO\OwnerDao as OwnerDao;
    //use DAO\PetDAO as petDAO;

    // SQL 
    use DAOSQL\PetDAO as PetDAO;
    use DAOSQL\OwnerDao  as OwnerDAO;
    use DAOSQL\ReservaDAO as ReservaDAO ;

    // models 
    use Models\Pet as Pet ;
    use Exception;
    use Models\Estadoreserva;


    class PetController {

        private $petDao ;
        private $ownerDao ;


        public function __construct()
        {
            $this->petDao = new PetDAO ();
            $this->ownerDao = new OwnerDAO();
            $this->reservadao = new ReservaDAO ;
           
        }


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
          
            try {
                
                $this->petDao->Add ($pet);
                $this->principalOwner();

            }
            catch (Exception $ex)  {
                throw $ex;
            }

       
        }

        public function principalOwner (){
            
            require_once (VIEWS_PATH."navOwner.php");
            $petDao = new PetDAO ();
            $user = $_SESSION['loggedUser'];
            $petlist = $petDao->buscarPets($user->getNombreUser());
            $reservadao = new ReservaDAO();
            $lista=$reservadao->GetAll();
            $listaAceptada = $this->reservadao->buscarReservaxEstado($lista,$user->getNombreUser(), Estadoreserva::Aceptada);
            $ListaEnCurso = $this->reservadao->buscarReservaxEstado($lista,$user->getNombreUser(),Estadoreserva::Confirmada);
            require_once(VIEWS_PATH."menu-owner.php");
        }


        public function agregarPet (){
            require_once(VIEWS_PATH."check.php");
            require_once(VIEWS_PATH."registrarMascota.php");
        }
    }
?>