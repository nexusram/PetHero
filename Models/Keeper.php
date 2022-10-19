<?php

    namespace Models;

    class Keeper {
        private $description;
        private $size;
        private $reviews;
        private $freeDays;
        private $bookings;
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
         * Get the value of reviews
         */ 
        public function getReviews()
        {
                return $this->reviews;
        }

        /**
         * Set the value of reviews
         *
         * @return  self
         */ 
        public function setReviews($reviews)
        {
                $this->reviews = $reviews;

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