<?php
namespace Models;
use Models\Owner as Owner;

    class Pet{
        private $id;
        private $nombre;
        private Owner $owner ;
        private $raza;
        private $tamano;
        private $imagen ;
        private $planVacunacion;
        private $observacionesGrals;
        private $video;

        public function __construct()
        {
                
        }

        public function setImg ($img){$this->imagen = $img;}
        public function getImg (){return $this->imagen;}
        
        /*
        public function __construct($nombre,$owner,$raza,$tamano,$planVacunacion,$observacionesGrals,$video)
        {
            $this -> nombre = $nombre;
            $this -> owner = $owner;
            $this -> raza = $raza;
            $this -> tamano = $tamano;
            $this -> planVacunacion = $planVacunacion;
            $this -> observacionesGrals = $observacionesGrals;
            $this -> video = $video;

        }
        */
        
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
         * Get the value of owner
         */
        public function getOwner()
        {
                return $this->owner;
        }

        /**
         * Set the value of owner
         */
        public function setOwner(Owner $owner): self
        {
                $this->owner = $owner;

                return $this;
        }

        /**
         * Get the value of raza
         */
        public function getRaza()
        {
                return $this->raza;
        }

        /**
         * Set the value of raza
         */
        public function setRaza($raza): self
        {
                $this->raza = $raza;

                return $this;
        }

        /**
         * Get the value of tamano
         */
        public function getTamano()
        {
                return $this->tamano;
        }

        /**
         * Set the value of tamano
         */
        public function setTamano($tamano): self
        {
                $this->tamano = $tamano;

                return $this;
        }

        /**
         * Get the value of planVacunacion
         */
        public function getPlanVacunacion()
        {
                return $this->planVacunacion;
        }

        /**
         * Set the value of planVacunacion
         */
        public function setPlanVacunacion($planVacunacion): self
        {
                $this->planVacunacion = $planVacunacion;

                return $this;
        }

        /**
         * Get the value of observacionesGrals
         */
        public function getObservacionesGrals()
        {
                return $this->observacionesGrals;
        }

        /**
         * Set the value of observacionesGrals
         */
        public function setObservacionesGrals($observacionesGrals): self
        {
                $this->observacionesGrals = $observacionesGrals;

                return $this;
        }

        /**
         * Get the value of video
         */
        public function getVideo()
        {
                return $this->video;
        }

        /**
         * Set the value of video
         */
        public function setVideo($video): self
        {
                $this->video = $video;

                return $this;
        }
    }
?>