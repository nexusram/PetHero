<?php

    namespace Models;

    class Address {
        private $id;
        private $street;
        private $number;
        private $idLocation;

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
         * Get the value of street
         */ 
        public function getStreet()
        {
                return $this->street;
        }

        /**
         * Set the value of street
         *
         * @return  self
         */ 
        public function setStreet($street)
        {
                $this->street = $street;

                return $this;
        }

        /**
         * Get the value of number
         */ 
        public function getNumber()
        {
                return $this->number;
        }

        /**
         * Set the value of number
         *
         * @return  self
         */ 
        public function setNumber($number)
        {
                $this->number = $number;

                return $this;
        }

        /**
         * Get the value of idLocation
         */ 
        public function getIdLocation()
        {
                return $this->idLocation;
        }

        /**
         * Set the value of idLocation
         *
         * @return  self
         */ 
        public function setIdLocation($idLocation)
        {
                $this->idLocation = $idLocation;

                return $this;
        }
    }
?>