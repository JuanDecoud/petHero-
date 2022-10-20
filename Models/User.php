<?php
   namespace Models ;

    abstract class User{
        private $id;
        private $nombreUser;
        private $contrasena;
        private $tipodeCuenta ;

        public function __construct($id, $nombreUser, $contrasena ){
                $this->id = $id ;
                $this->nombreUser = $nombreUser ;
                $this->contrasena = $contrasena ;

        }
        
        public function setTipodecuenta ($tipe){
                $this->tipodeCuenta = $tipe;
        }

        public function getTipodecuenta (){return $this->tipodeCuenta;}
        
        /**
         * Get the value of id
         */
 

        /**
         * Set the value of id
         */
   

        /**
         * Get the value of nombreUser
         */
        public function getNombreUser()
        {
                return $this->nombreUser;
        }
        
        /**
         * Set the value of nombreUser
         */
        public function setNombreUser($nombreUser): self
        {
                $this->nombreUser = $nombreUser;

                return $this;
        }

        /**
         * Get the value of contrasena
         */
        public function getContrasena()
        {
                return $this->contrasena;
        }

        /**
         * Set the value of contrasena
         */
        public function setContrasena($contrasena): self
        {
                $this->contrasena = $contrasena;

                return $this;
        }
    }
?>