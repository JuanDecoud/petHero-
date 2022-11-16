<?php 
   namespace Controllers ;

    use DAOSQL\ReviewDao;
    use DAOSQL\PetDAO ;
    use DAOSQL\ReservaDAO ;

    use Exception;
    use Models\Keeper;
    use Models\Pet;
    use Models\Review;
    use Models\Estadoreserva;

 class ReviewController {

    private  $reviewdao ;
    private $petdao ;
    private $reservaDao ;

    public function __construct()
    {
        $this->reviewdao = new ReviewDao();
        $this->petdao = new PetDAO ();
        $this->reservaDao = new ReservaDAO ();
        
    }

    public function vistaReview ($nombrePet , $nombreKeeper){
        $nombreKeeper = $nombreKeeper ;
        $nombrePet = $nombrePet ;
        require_once(VIEWS_PATH."check.php");
        require_once (VIEWS_PATH."review.php");
        
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
 }

?>