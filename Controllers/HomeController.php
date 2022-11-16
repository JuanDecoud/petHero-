<?php
    namespace Controllers;

    //json

    //use DAO\KeeperDAO as KeeperDAO ;
    //use DAO\OwnerDao as OwnerDAO ;
   // use DAO\ReservaDAO as ReservaDAO ;
    // use DAO\PetDAO as PetDAO ;

    //sql
    use DAOSQL\KeeperDAO as KeeperDAO ;
    use DAOSQL\OwnerDAO as OwnerDAO ;
    use DAOSQL\ReservaDAO as ReservaDAO;
    USE DAOSQL\PetDAO as PetDAO ;
use Exception;
use Models\Estadoreserva ;
    

    class HomeController
    {
        private $keeperDao ;
        private $ownerDao ;
        private $petDao ;
        private $reservadao ;

        public function __construct()
        {
            $this->keeperDao = new KeeperDAO();
            $this->ownerDao = new OwnerDAO ();
            $this->petDao = new PetDAO ();
            $this->reservadao = new ReservaDAO ();
        }

        public function cerrarSession (){
            require_once(VIEWS_PATH."Logout.php");

        }

        public function Index($message = "")
        {   
            require_once(VIEWS_PATH."Home.php");
        } 

        public function principalKeeper (){

            require_once (VIEWS_PATH."check.php");
            require_once (VIEWS_PATH."navKeeper.php");

            try 
            {
                $keeper = $_SESSION['loggedUser'];
                $userName = $keeper->getNombreUser();
                $fechas = $this->keeperDao->buscarEstadias($userName);
                $lista = $this->reservadao->getAll();
                $listaReservas = $this->reservadao->buscarReservaxEstadoKeeper($lista , $keeper->getNombreUser (),Estadoreserva::Pendiente);
                $listaAceptadas = $this->reservadao->buscarReservaxEstadoKeeper( $lista ,$keeper->getNombreUser (), Estadoreserva::Aceptada);
                $listaConfirmadas = $this->reservadao->buscarReservaxEstadoKeeper($lista , $keeper->getNombreUser() ,Estadoreserva::Confirmada );

            }
            catch (Exception $ex)
            {
                throw $ex ;
            }
    

            require_once(VIEWS_PATH."mainKeeper.php");
        }

        public function menuOwner (){
            require_once (VIEWS_PATH."check.php");
            require_once (VIEWS_PATH."navOwner.php");

            try 
            {
                $user = $_SESSION['loggedUser'];
                $petlist = $this->petDao->buscarPets($user->getNombreUser());
                $lista=$this->reservadao->GetAll();
                $listaAceptada = $this->reservadao->buscarReservaxEstado($lista,$user->getNombreUser(), Estadoreserva::Aceptada);
                $ListaEnCurso = $this->reservadao->buscarReservaxEstado($lista,$user->getNombreUser(),Estadoreserva::Confirmada);
                
            }
            catch (Exception $ex)
            {
                throw $ex ;

            }

            require_once(VIEWS_PATH."menu-owner.php");

        }

        public function vistaTipocuenta (){
            
            require_once(VIEWS_PATH."tipodecuenta.php");
        }

        public function registerKeeper (){
           
            require_once (VIEWS_PATH."Sign-upKeeper.php");
        }

        public function registrarOwner (){
           
            require_once(VIEWS_PATH."Sing-upOwner.php");
        }

        public function registrarMascota (){
            require_once (VIEWS_PATH."check.php");
            require_once(VIEWS_PATH."Sing-upMascota.php");
        }
        
        public function vistaLogin (){

            
            require_once(VIEWS_PATH."Login.php");
            
        }
      
        public function login ($usuario , $contraseña){
            try 
            {
                $userkeeper = $this->keeperDao->comprobarLogin($usuario , $contraseña);
                $userOwner = $this->ownerDao->comprobarLogin($usuario , $contraseña);
    
                 if ($userkeeper !=null){
                    
                    $_SESSION['loggedUser'] = $userkeeper ;
                    $this->principalKeeper();  
                 }
                 else if ($userOwner !=null){
                    $_SESSION['loggedUser'] = $userOwner ;
                    $this->menuOwner();
                 }
                 else {
                    echo '<script language="javascript">alert("Nombre de usuario o contraseña incorrecto");</script>';
                    $this->vistaLogin();
                 }

            }
            catch (Exception $ex)
            {
                throw $ex ;
            }

        }

        public function seleccinarCuenta ($tipoCuenta){
           
            $tipo = $tipoCuenta ;
            if ($tipo == "Keeper"){
                $_SESSION['keeper'] =$tipo; 
                $this->registerKeeper();
                
            }
            else if($tipo == "Owner")
            {
                $_SESSION['owner'] =$tipo; 
                $this->registrarOwner();
            }
        }



    }
?>