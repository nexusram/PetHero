<?php

    namespace Models;

    class Day {
        private $date;
        private $hour;

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
         * Get the value of hour
         */ 
        public function getHour()
        {
                return $this->hour;
        }

        /**
         * Set the value of hour
         *
         * @return  self
         */ 
        public function setHour($hour)
        {
                $this->hour = $hour;

                return $this;
        }
    }
?>