<?php 
   namespace Controllers ;

    use DAOSQL\ReviewDao;
    use DAOSQL\PetDAO ;
    use DAOSQL\ReservaDAO ;
    use DAOSQL\OwnerDAO ;

    use Exception;
    use Models\Keeper;
    use Models\Pet;
    use Models\Review;
    use Models\Estadoreserva;
    use Models\Reserva ;

 class ReviewController {

    private  $reviewdao ;
    private $petdao ;
    private $reservaDao ;
    private $ownerdao ;

    public function __construct()
    {
        $this->reviewdao = new ReviewDao();
        $this->petdao = new PetDAO ();
        $this->reservaDao = new ReservaDAO ();
        $this->ownerdao = new OwnerDAO ();
        
    }

    public function vistaReview ($nombrePet , $nombreKeeper){
        $reserva = $_SESSION['reserva'];
        $keeper = $reserva->getKeeper();
        $pet = $reserva->getPet();
        require_once(VIEWS_PATH."check.php");
        require_once (VIEWS_PATH."review.php");
       
        
    }

    public function agregarTarjeta (){
        require_once(VIEWS_PATH."check.php");
        require_once(VIEWS_PATH."agregarTarjeta.php");
    }

    public function vistaPago (){
            
        $owner = $_SESSION['loggedUser'];
        $tarjeta= null ;
        $ownerdao = new OwnerDao();
        $tarjeta = $ownerdao->buscarTarjeta($owner->getNombreUser());

        $reserva = $_SESSION['reserva'];
        $keeper = $reserva->getKeeper();
        $pet = $reserva->getPet();

        require_once(VIEWS_PATH."check.php");
        require_once(VIEWS_PATH."vistaCompletarPago.php");
    }

    public function  simulacionPago ( $pet,$keeper ,$arregloDias ){

        
        $user = $_SESSION['loggedUser'];

        // antes de completar la estadia comprobamos que realmenter allan pasado los dias correspondientes a la estadia 

        $fechadelDia = date ("Y-m-d");
        $date = $this->reservaDao->ComprobarFecha($arregloDias);
        $fechadelDia = "2022-11-28";
        if ($fechadelDia >= $date){
            try 
            {   
                $this->reservaDao->cambiarEstado($user->getNombreUser() , $pet , $keeper , Estadoreserva::Cumplida);
                // buscar y crea la reserva para guardarla en un session
                $lista=$this->reservaDao->getALL();
                $reservaLista = $this->reservaDao->buscarReservaEnCurso($lista,$user->getNombreUser(),Estadoreserva::Cumplida);
                $reservaNueva = null ;
    
            }
            catch (Exception $ex)
            {
                throw $ex ;
            }
    
            foreach($reservaLista as $reserva){
                $reservaNueva = new Reserva ();
                $reservaNueva->setDias($reserva->getDias());
                $reservaNueva->setPet($reserva->getPet());
                $reservaNueva->setKeeper($reserva->getKeeper());
                $reservaNueva->setImporteTotal($reserva->getImporteTotal());
                $reservaNueva->setImporteReserva($reserva->getImporteReserva());
                $reservaNueva->setEstado ($reserva->getEstado());
    
            }
    
            $_SESSION['reserva'] = $reservaNueva;
            $comprobartarjeta = $this->ownerdao->buscarTarjeta($user->getNombreUser());           
            /// si el usuario no tiene tarjeta se ingresa una sino directamente se pasa al pago 
    
           if ($comprobartarjeta == null){
                $this->agregarTarjeta();
            }
            else {
                $this->vistaPago();
            }

        }
        else {
            echo '<script language="javascript">alert("La Estadia aun no esta completa");</script>';
            $this->principal();
            
        }
       
    
    }

    public function principal (){
        require_once(VIEWS_PATH."check.php");
        $user = $_SESSION['loggedUser'];
        try
        {
            $petlist = $this->petdao->buscarPets($user->getNombreUser());
            $lista=$this->reservaDao->getAll();
            $listaAceptada = $this->reservaDao->buscarReservaxEstado($lista,$user->getNombreUser(), Estadoreserva::Aceptada);
            $ListaEnCurso = $this->reservaDao->buscarReservaxEstado($lista,$user->getNombreUser(),Estadoreserva::Confirmada);

        }
        catch (Exception $ex)
        {
            throw $ex ;
        }
        
        
        require_once(VIEWS_PATH."menu-owner.php");
    }

    public function guardarReview ($nombreKeeper , $nombrePet , $descripcion , $puntaje){
        try{
            
            $user = $_SESSION['loggedUser'];
            $review = new Review();
            $pet = new Pet();
            $pet->setOwner($user);
            $keeper = new Keeper($nombreKeeper,
            null,null,null,null,null,null,null);
            $pet->setNombre($nombrePet);
            $fecha = date('Y-m-d');
            $review->setDescription($descripcion);
            $review->setPuntaje($puntaje);
            $review->setFecha($fecha);
            $review->setPet($pet);
            $review->setKeeper($keeper);
           
            $this->reviewdao->add($review);
            $this->principal();

        }
        catch (Exception $ex) {
            throw $ex;
        }
    }

    public function historico (){

        require_once (VIEWS_PATH."check.php");
        $keeper = $_SESSION['loggedUser'];
        $listareviews = array ();
        try 
        {  
            $listareviews = $this->reviewdao->keeperReviews($keeper);
        }
        catch (Exception $ex)
        {
            throw $ex ;
        }
        
        require_once (VIEWS_PATH."navKeeper.php");
        require_once(VIEWS_PATH."historicoKeeper.php");
    }
 }

?>