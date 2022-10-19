<?php
    abstract class User{
        private $id;
        private $nombreUser;
        private $contrasena;
        
        /**
         * Get the value of id
         */
        public function getId()
        {
                return $this->id;
        }

        /**
         * Set the value of id
         */
        public function setId($id): self
        {
                $this->id = $id;

                return $this;
        }

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