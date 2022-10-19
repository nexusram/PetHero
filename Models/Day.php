<?php

    namespace Models;

    class Day {
        private $id;
        private $userId;
        private $date;
        private $hour;
        private $status;

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
         * Get the value of userId
         */ 
        public function getUserId()
        {
                return $this->userId;
        }

        /**
         * Set the value of userId
         *
         * @return  self
         */ 
        public function setUserId($userId)
        {
                $this->userId = $userId;

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

        /**
         * Get the value of available
         */ 
        public function getStatus()
        {
                return $this->available;
        }

        /**
         * Set the value of available
         *
         * @return  self
         */ 
        public function setStatus($available)
        {
                $this->available = $available;

                return $this;
        }
    }
?>