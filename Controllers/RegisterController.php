<?php 
    namespace Controllers ;

    //use DAO\KeeperDAOSQL as KeeperDao;
    use DAO\OwnerDAOSQL as OwnerDAO;
    //use DAO\OwnerDAO as OwnerDAO;
    use DAO\PetDAO as PetDAO;
    use DAO\UserDAO;
    use DAO\KeeperDAO ;
    use Models\Keeper as Keeper;
    use Models\Owner as Owner;
    use Models\Pet as Pet;
   // use DAO\OwnerdbDAO as OwnerdbDAO ;
    use Exception;

    class RegisterController {

        
        private $keeperDAO ;
        private $ownerDAO ;
        private $userDAO;
        //private $ownerdb ;


        public function __construct()
        {
            $this->keeperDAO = new KeeperDAO ();
            $this->ownerDAO = new OwnerDAO ();
            $this->userDAO = new UserDAO;
            //$this->ownerdb = new OwnerdbDAO() ;
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

          /*  // Base De Datos 
            try
            {
                if ($userName != null && $contrasena !=null){
                    strtolower($userName);
                    $usuarios = array ();
                    $usuarios = $this->ownerdb->owner_getAll();
                    
                    $comprobarUser = null ;
                    foreach ($usuarios as $usuario){
                        if ($usuario == $userName){
                            $comprobarUser = $userName;
                        }
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
                        $this->ownerdb->add($owner);
                        $this->login();
                    }   
            }
        }
        catch(Exception $ex)
        {
            echo '<script language="javascript">alert("Nombre de usuario ya existe");</script>';
            $this->registrarOwner();
        }
*/
        //resguardo en JSON


        if ($userName != null && $contrasena !=null){
            strtolower($userName);
            $usuarios = array ();
            $comprobarUser = null ;

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
                $this->ownerDAO->Add($owner);
                $this->login();
            }
            else {
                echo '<script language="javascript">alert("Nombre de usuario ya existe");</script>';
                $this->registrarOwner();
            }

        }
        else {
            echo '<script language="javascript">alert("Complete todos los campos");</script>';
            $this->registrarOwner();
        }


            

        }

        public function agregarKeeper ($nombre,$apellido,$dni,$telefono,$userName,$contrasena,$remuneracion,$arrayTipo ){

            $tipoMascota = $arrayTipo ;
          

            if ($userName !=null && $contrasena!=null){
                strtolower($userName);
                $comprobarUser = $this->keeperDAO->obtenerUser($userName);
                if ($comprobarUser==null){
                    $comprobarUser=$this->ownerDAO->obtenerUser($userName);
                }
                

                if ($comprobarUser == null){
                    $keeper = new Keeper($userName,$contrasena,$_SESSION['keeper'],$tipoMascota,$remuneracion,$nombre, $apellido,$dni,$telefono);
                    $this->keeperDAO->addKeeper($keeper);
                    $this->login();
                }
                else {
                    echo '<script language="javascript">alert("Nombre de usuario ya existe");</script>';
                    $this->registrarKeeper();
    
                }
            }
            else {
                echo '<script language="javascript">alert("Complete todos los campos");</script>';
                $this->registrarKeeper();
            }
            
          
        }

    }
?>