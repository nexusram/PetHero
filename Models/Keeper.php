<?php

    namespace Models;

    class Keeper extends User {
        private $description;
        private $size;
        private $freeDays;
        private $price;

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
         * Get the value of size
         */ 
        public function getSize()
        {
                return $this->size;
        }

        /**
         * Set the value of size
         *
         * @return  self
         */ 
        public function setSize($size)
        {
                $this->size = $size;

                return $this;
        }

        /**
         * Get the value of freeDays
         */ 
        public function getFreeDays()
        {
                return $this->freeDays;
        }

        /**
         * Set the value of freeDays
         *
         * @return  self
         */ 
        public function setFreeDays($freeDays)
        {
                $this->freeDays = $freeDays;

                return $this;
        }
        
        /**
         * Get the value of price
         */ 
        public function getPrice()
        {
                return $this->price;
        }

        /**
         * Set the value of price
         *
         * @return  self
         */ 
        public function setPrice($price)
        {
                $this->price = $price;

                return $this;
        }
    }
?>