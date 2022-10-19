<?php

    namespace Models;

    class Owner extends User {
        private $bookings;
        private $pets;

        /**
         * Get the value of bookings
         */ 
        public function getBookings()
        {
                return $this->bookings;
        }

        /**
         * Set the value of bookings
         *
         * @return  self
         */ 
        public function setBookings($bookings)
        {
                $this->bookings = $bookings;

                return $this;
        }

        /**
         * Get the value of pets
         */ 
        public function getPets()
        {
                return $this->pets;
        }

        /**
         * Set the value of pets
         *
         * @return  self
         */ 
        public function setPets($pets)
        {
                $this->pets = $pets;

                return $this;
        }
    }
?>