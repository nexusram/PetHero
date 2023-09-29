<?php

    namespace Models;

    class Keeper {
        private $id;
        private User $user;
        private PetSize $petSize;
        private $remuneration;
        private $description;
        private $score;
        private $active;


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
        public function getUser()
        {
                return $this->user;
        }

        /**
         * Set the value of userId
         *
         * @return  self
         */ 
        public function setUser(User $user)
        {
                $this->user = $user;

                return $this;
        }

        /**
         * Get the value of petTypeId
         */ 
        public function getPetSize()
        {
                return $this->petSize;
        }

        /**
         * Set the value of petTypeId
         *
         * @return  self
         */ 
        public function setPetSize(PetSize $petSize)
        {
                $this->petSize = $petSize;

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
         * Get the value of score
         */ 
        public function getScore()
        {
                return $this->score;
        }

        /**
         * Set the value of score
         *
         * @return  self
         */ 
        public function setScore($score)
        {
                $this->score = $score;

                return $this;
        }

        /**
         * Get the value of active
         */ 
        public function getActive()
        {
                return $this->active;
        }

        /**
         * Set the value of active
         *
         * @return  self
         */ 
        public function setActive($active)
        {
                $this->active = $active;

                return $this;
        }
    }
?>