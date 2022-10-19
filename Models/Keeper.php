<?php

    namespace Models;

    class Keeper {
        private $id;
        private $userId;
        private $petTypeId;
        private $remuneration;

        /**
         * Get the value of keeperId
         */ 
        public function getId()
        {
                return $this->id;
        }

        /**
         * Set the value of keeperId
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
         * Get the value of petTypeId
         */ 
        public function getPetTypeId()
        {
                return $this->petTypeId;
        }

        /**
         * Set the value of petTypeId
         *
         * @return  self
         */ 
        public function setPetTypeId($petTypeId)
        {
                $this->petTypeId = $petTypeId;

                return $this;
        }

        /**
         * Get the value of remuneration
         */ 
        public function getRemuneration()
        {
                return $this->remuneration;
        }

        /**
         * Set the value of remuneration
         *
         * @return  self
         */ 
        public function setRemuneration($remuneration)
        {
                $this->remuneration = $remuneration;

                return $this;
        }
    }
?>