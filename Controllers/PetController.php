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
            


            try {

                $owner = $_SESSION['loggedUser'];
                $idOwner = $this->ownerDao->buscarId($owner->getNombreUser());
                $targetdir = VIEWS_PATH."/img/uploads/";
       

                $target_file1 = $targetdir.basename($_FILES["imagenPerfil"]["name"]);
                $target_file2 = $targetdir.basename($_FILES["vacunacion"]["name"]);
                $target_file3 = $targetdir.basename($_FILES["video"]["name"]);

                
    
                move_uploaded_file($_FILES["imagenPerfil"]["tmp_name"], $target_file1);
                move_uploaded_file($_FILES["vacunacion"]["tmp_name"], $target_file2);
                move_uploaded_file($_FILES["video"]["tmp_name"], $target_file3);

                // valido que no haya ninguna pet registrada anteriormente con el mismo nombre 
                $validarPet = null ;
                strtolower($nombre);
                $validarPet = $this->petDao->comprobarPet($nombre , $idOwner);

                if ($validarPet == null){
                    $pet = new Pet ();
                    $pet->setNombre($nombre);
                    $pet->setOwner($owner);
                    $pet->setRaza($raza);
                    $pet->setTamano($tamanio);
                    $pet->setImg(FRONT_ROOT.VIEWS_PATH."/img/uploads/".basename($_FILES['imagenPerfil']['name']));
                    $pet->setPlanVacunacion(FRONT_ROOT.VIEWS_PATH."/img/uploads/".basename($_FILES['vacunacion']['name']));
                    $pet->setVideo(FRONT_ROOT.VIEWS_PATH."/img/uploads/".basename($_FILES['video']['name']));
                    $pet->setObservacionesGrals($observacion); 
                    $this->petDao->Add ($pet);
                    $this->principalOwner();
                }
                else {
                    echo '<script language="javascript">alert("Ya se encuentra registrada una mascota con ese nombre");</script>';
                    $this->principalOwner();
                }
    
            }
            catch (Exception $ex)  {
                throw $ex;
            }
            
            
        }

        public function principalOwner (){
            try
            {
                require_once(VIEWS_PATH."check.php");
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
            catch (Exception $ex)
            {   
                throw $ex ;

            }

        }


        public function agregarPet (){
            require_once(VIEWS_PATH."check.php");
            require_once(VIEWS_PATH."registrarMascota.php");
        }
    }
?>