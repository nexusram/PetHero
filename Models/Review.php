<?php

    namespace Models;

    class Review {
        private $id;
        private $idOwner;
        private $idKeeper;
        private $description;
        private $qualification;

        /**
         * Get the value of id
         */ 
        public function getId()
        {
                return $this->id;
        }

        /**
         * Set the value of id
         *
         * @return  self
         */ 
        public function setId($id)
        {
                $this->id = $id;

                return $this;
        }

        /**
         * Get the value of idOwner
         */ 
        public function getIdOwner()
        {
                return $this->idOwner;
        }

        /**
         * Set the value of idOwner
         *
         * @return  self
         */ 
        public function setIdOwner($idOwner)
        {
                $this->idOwner = $idOwner;

                return $this;
        }

        /**
         * Get the value of idKeeper
         */ 
        public function getIdKeeper()
        {
                return $this->idKeeper;
        }

        /**
         * Set the value of idKeeper
         *
         * @return  self
         */ 
        public function setIdKeeper($idKeeper)
        {
                $this->idKeeper = $idKeeper;

                return $this;
        }

        /**
         * Get the value of description
         */ 
        public function getDescription()
        {
                return $this->description;
        }

        /**
         * Set the value of description
         *
         * @return  self
         */ 
        public function setDescription($description)
        {
                $this->description = $description;

                return $this;
        }

        /**
         * Get the value of qualification
         */ 
        public function getQualification()
        {
                return $this->qualification;
        }

        /**
         * Set the value of qualification
         *
         * @return  self
         */ 
        public function setQualification($qualification)
        {
                $this->qualification = $qualification;

                return $this;
        }
    }
?>