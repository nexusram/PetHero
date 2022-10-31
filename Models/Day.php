<?php

    namespace Models;

    class Day {
        private $id;
        private $keeperId;
        private $date;
        private $isAvailable;

        

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
         * Get the value of keeperId
         */ 
        public function getKeeperId()
        {
                return $this->keeperId;
        }

        /**
         * Set the value of keeperId
         *
         * @return  self
         */ 
        public function setKeeperId($keeperId)
        {
                $this->keeperId = $keeperId;

                return $this;
        }

        /**
         * Get the value of date
         */ 
        public function getDate()
        {
                return $this->date;
        }

        /**
         * Set the value of date
         *
         * @return  self
         */ 
        public function setDate($date)
        {
                $this->date = $date;

                return $this;
        }

        /**
         * Get the value of isAvailable
         */ 
        public function getIsAvailable()
        {
                return $this->isAvailable;
        }

        /**
         * Set the value of isAvailable
         *
         * @return  self
         */ 
        public function setIsAvailable($isAvailable)
        {
                $this->isAvailable = $isAvailable;

                return $this;
        }
    }
?>