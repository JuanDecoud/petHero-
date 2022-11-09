<?php 
   namespace Controllers ;

    use DAO\ReviewDao;
    use Exception;
    use Models\Review;

 class ReviewController {

    private  ReviewDao $reviewdao ;

    public function __construct()
    {
        $this->reviewdao = new ReviewDao();
        
    }

    public function vistaReview ($nombrePet , $nombreKeeper){
        $nombreKeeper = $nombreKeeper ;
        $nombrePet = $nombrePet ;

        require_once (VIEWS_PATH."review.php");
        
    }

    public function principal (){
        require_once(VIEWS_PATH."menu-owner.php");
    }

    public function guardarReview ($nombreKeeper , $nombrePet , $descripcion , $puntaje){
        try{
            $user = $_SESSION['loggedUser'];
            $review = new Review();
           
            $fecha = date('Y-m-d H:i:s');
            $review->setDescription($descripcion);
            $review->setPuntaje($puntaje);
            $review->setFecha($fecha);
            $this->reviewdao->add($review);
            $this->principal();

        }
        catch (Exception $ex) {
            throw $ex;
        }
    }
 }

?>