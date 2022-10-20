<?php 
    namespace DAO ;

use Models\Keeper as Keeper;

    interface IKeeperDAO {
        public function getALL ();
        public function addKeeper (Keeper $keeper);
        
    }
?>