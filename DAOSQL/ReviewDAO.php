<?php 

    namespace DAOSQL ;
    use Models\Review;
    use Models\Keeper;
    use DAO\IReviewDao;
    use DAOSQL\QueryType ;
use Exception;

    class ReviewDao implements IReviewDao {
        
        private $connection ;
        private $table = "reviews";


        public function add (Review $review){

            $pet = $review->getPet();
            $owner = $pet->getOwner() ;
            $parametrosReview = array();
            $keeper = $review->getKeeper();

            try
            {
                $query = "CALL agregar_Review (?,?,?,?,?)";
                $queryPet =" CALL buscarPetId_Nombre(?,?)";
                $queryKeeper=" CALL buscar_keeper(?)";

                $this->connection = Connection::GetInstance();

                // busco el id de la pet 
            
                $parametroPet['nombrePet'] = $pet->getNombre();
                $parametroPet['nombreUser'] = $owner->getNombreUser();

               $resultadoPet = $this->connection->Execute($queryPet,$parametroPet ,QueryType::StoredProcedure);

                foreach ($resultadoPet as $fila){
                    $parametrosReview['idPet'] =$fila[0];
                }

                //busco el id del keeper 
                $parametroKeeper['nombreUser'] = $keeper->getNombreUser();
                $resultadoKeeper = $this->connection->Execute($queryKeeper,$parametroKeeper ,QueryType::StoredProcedure);
                foreach ($resultadoKeeper as $fila){
                    $parametrosReview['idKeeper'] =$fila[0];
                }
                
                

                $parametrosReview['descripcion'] = $review->getDescription();
                $parametrosReview['fecha'] = $review->getFecha();
                $parametrosReview['puntuacion'] = $review->getPuntaje();

               

                $this->connection->ExecuteNonQuery($query, $parametrosReview, QueryType::StoredProcedure);

            }
            catch (Exception $ex)
            {
                throw $ex ;
            }

            
        }

        public function getAll (){
           

        }

        public function keeperReviews  ( Keeper $keeper){
            
            $listaReviews = array ();

            try
            {
                
                $queryKeeper = "Call buscar_Keeper(?)";
                $queryReview = "Call buscar_Review (?)";
    
                $parametroKeeper['nombreUser'] = $keeper->getNombreUser();
    
                $this->connection = Connection::GetInstance() ;
    
                $parametroReview = array ();

            
    
                $resultadokeeper = $this->connection->Execute($queryKeeper , $parametroKeeper , QueryType::StoredProcedure);
                foreach ($resultadokeeper as $fila){
                    $parametroReview['idKeeper'] = $fila[0];
                }


                
    
                $resultadoreviews = $this->connection->Execute ($queryReview , $parametroReview , QueryType::StoredProcedure);
               
                foreach ($resultadoreviews as $fila){
                    $review = new Review();
                    $review->setDescription($fila[0]);
                    $review->setFecha($fila[1]);
                    $review->setPuntaje($fila[2]);
                    array_push($listaReviews , $review);
                
                }

            }
            catch (Exception $Ex)
            {
                throw $Ex ;
            }


            return $listaReviews ;

        }
    }



?>