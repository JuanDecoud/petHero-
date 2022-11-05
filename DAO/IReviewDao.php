<?php 
    namespace DAO ;
    use Models\Review;

    interface IReviewDao {
        public function getall ();
        public function add (Review $review);
        
    }

?>