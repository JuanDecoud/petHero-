<?php 
    namespace DAO ;

use Models\Keep;

    interface IKeeperDAO {
        public function getALL ();
        public function addKeeper (Keep $keeper);
        
    }
?>