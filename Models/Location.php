<?php

    namespace Models;

    class Location {
        private $id;
        private $name;
        private $postalCode;
        private $idProvince;

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
         * Get the value of name
         */ 
        public function getName()
        {
                return $this->name;
        }

        /**
         * Set the value of name
         *
         * @return  self
         */ 
        public function setName($name)
        {
                $this->name = $name;

                return $this;
        }

        /**
         * Get the value of postalCode
         */ 
        public function getPostalCode()
        {
                return $this->postalCode;
        }

        /**
         * Set the value of postalCode
         *
         * @return  self
         */ 
        public function setPostalCode($postalCode)
        {
                $this->postalCode = $postalCode;

                return $this;
        }

        /**
         * Get the value of idProvince
         */ 
        public function getIdProvince()
        {
                return $this->idProvince;
        }

        /**
         * Set the value of idProvince
         *
         * @return  self
         */ 
        public function setIdProvince($idProvince)
        {
                $this->idProvince = $idProvince;

                return $this;
        }
    }
?>