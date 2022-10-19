<?php

    namespace Models;

    class Province {
        private $id;
        private $name;
        private $idCountry;

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
         * Get the value of idCountry
         */ 
        public function getIdCountry()
        {
                return $this->idCountry;
        }

        /**
         * Set the value of idCountry
         *
         * @return  self
         */ 
        public function setIdCountry($idCountry)
        {
                $this->idCountry = $idCountry;

                return $this;
        }
    }
?>