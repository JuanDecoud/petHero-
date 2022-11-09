<?php 

    namespace DAO ;
    use Models\Review;
    use DAO\QueryType ;
    

    class ReviewDao implements IReviewDao {
        
        private $connection ;
        private $table = "reviews";

        public function add (Review $review){

            $query = "CALL agregar_Review (?,?,?,?,?)";

            $parametros['descripcion'] = $review->getDescription();
            $parametros['fecha'] = $review->getFecha();
            $parametros['puntuacion'] = $review->getPuntaje();
            $parametros ['idKeeper'] = 1 ;
            $parametros['idPet']=1;

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parametros, QueryType::StoredProcedure);
        }

        public function getAll (){

        }
    }



?>