<?php
   namespace Models ;

        use DAO\UserDAO as UserDAO;

    abstract class User{
        private $id;
        //Hacer el id autoincremental dentro del construct y sacarlo de los parametros
        /**Pregunto porque cuando voy a crear un nuevo owner tengo el atributo id que no se como llenarlo */
        //Agregar Email en user podria ser mejor porque tanto owner como keeper lo requieren
        private $nombreUser;
        private $contrasena;
        private $tipodeCuenta;
        private $nombre;
        private $apellido;
        private $dni;
        private $telefono;

        public function __construct($nombreUser, $contrasena){
                $userDAO = new UserDAO();
                $this->id = ($userDAO -> GetMaxID()+1);
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
        public function getID(){
                return $this -> id;
        }

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

        public function getTipocuenta (){return $this->tipodeCuenta;}


        

        /**
         * Get the value of nombre
         */
        public function getNombre()
        {
                return $this->nombre;
        }

        /**
         * Set the value of nombre
         */
        public function setNombre($nombre): self
        {
                $this->nombre = $nombre;

                return $this;
        }

        /**
         * Get the value of apellido
         */
        public function getApellido()
        {
                return $this->apellido;
        }

        /**
         * Set the value of apellido
         */
        public function setApellido($apellido): self
        {
                $this->apellido = $apellido;

                return $this;
        }

        /**
         * Get the value of dni
         */
        public function getDni()
        {
                return $this->dni;
        }

        /**
         * Set the value of dni
         */
        public function setDni($dni): self
        {
                $this->dni = $dni;

                return $this;
        }

        /**
         * Get the value of telefono
         */
        public function getTelefono()
        {
                return $this->telefono;
        }

        /**
         * Set the value of telefono
         */
        public function setTelefono($telefono): self
        {
                $this->telefono = $telefono;

                return $this;
        }
    }
?>