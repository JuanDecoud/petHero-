<?php
namespace Models;
use Models\User as User;

    class Pet{
        private $nombre;
        private $owner;
        private $raza;
        private $tamaño;
        private $planVacunacion;
        private $observacionesGrals;
        private $video;

        

        public function __construct($nombre,$owner,$raza,$tamaño,$planVacunacion,$observacionesGrals,$video)
        {
            


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
        public function setOwner($owner): self
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
         * Get the value of tama
         */
        public function getTama()
        {
                return $this->tama;
        }

        /**
         * Set the value of tama
         */
        public function setTama($tama): self
        {
                $this->tama = $tama;

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