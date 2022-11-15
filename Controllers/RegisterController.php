<?php 
    namespace Controllers ;

    //SQL

    use DAOSQL\KeeperDAO as KeeperDao;
    use DAOSQL\OwnerDAO as OwnerDAO;

    //JSON 
    //use DAO\OwnerDAO as OwnerDAO;
    //use DAO\KeeperDAO as KeeperDAO ;

    //Models
    use Models\Keeper as Keeper;
    use Models\Owner as Owner;
    use Exception;

    class RegisterController {

        
        private $keeperDAO ;
        private $ownerDAO ;

        public function __construct()
        {
            $this->keeperDAO = new KeeperDAO ();
            $this->ownerDAO = new OwnerDAO ();
        }

        public function login (){
            require_once(VIEWS_PATH."Login.php");
        }

        public function registrarKeeper (){
            
            require_once(VIEWS_PATH."Sign-upKeeper.php");
        }
        public function registrarOwner (){
            
            require_once(VIEWS_PATH."Sing-upOwner.php");
        }
  

        public function menuOwner (){
            require_once(VIEWS_PATH."menu-owner.php");
        }

        public function agregarOwner ($nombre,$apellido,$dni,$telefono,$userName,$contrasena ){

         
                    strtolower($userName);
                    $comprobarUser=null;
                    $comprobarUser = $this->keeperDAO->obtenerUser($userName);
                    if ($comprobarUser==null){
                        $comprobarUser=$this->ownerDAO->obtenerUser($userName);
                        
                    }

                    if ($comprobarUser == null){
                        $owner = new Owner ();
                        $owner->setNombre($nombre);
                        $owner->setApellido($apellido);
                        $owner->setDni($dni);
                        $owner->setTelefono($telefono);
                        $owner->setNombreUser($userName);
                        $owner->setContrasena($contrasena);
                        $owner->setTipodecuenta($_SESSION['owner']);
             
                        $this->ownerDAO->add($owner);
                        $this->login();
                    }
                    else 
                    {
                        echo '<script language="javascript">alert("Nombre de usuario ya existe");</script>';
                        $this->registrarOwner();

                    }   
            
    

        }

        public function agregarKeeper ($nombre,$apellido,$dni,$telefono,$userName,$contrasena,$remuneracion,$arrayTipo ){

            $tipoMascota = $arrayTipo ;
            strtolower($userName);

            try
            {
                $comprobarUser = $this->keeperDAO->obtenerUser($userName);
                if ($comprobarUser==null){
                    $comprobarUser=$this->ownerDAO->obtenerUser($userName);
                }

                if ($comprobarUser == null){
                    $keeper = new Keeper($userName,$contrasena,$_SESSION['keeper'],$remuneracion,$nombre, $apellido,$dni,$telefono);
                    $keeper->setTipoMascota($arrayTipo);
                    $this->keeperDAO->addKeeper($keeper);
                    $this->login();
                }
                else {
                    echo '<script language="javascript">alert("Nombre de usuario ya existe");</script>';
                    $this->registrarKeeper();
                }

            }
            catch (Exception $ex)
            {
                    throw $ex;

            }

        }
    }      

    
?>