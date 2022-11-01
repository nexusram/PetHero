<?php

    namespace Models;
use Models\User;
    class Pet {
        private $id;
        private User $user;
        private $name;
        private $petType;
        private $breed;
        private $petSize;
        private $observation;
        private $picture;
        private $vacunationPlan;
        private $video;
        private $active;

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
        public function getUser()
        {
                return $this->userId;
        }

        /**
         * Set the value of userId
         *
         * @return  self
         */ 
        public function setUser(User $userId)
        {
                $this->userId = $userId;

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
         * Get the value of petType
         */ 
        public function getPetType()
        {
                return $this->petType;
        }

        /**
         * Set the value of petType
         *
         * @return  self
         */ 
        public function setPetType(PetType $petType)
        {
                $this->petType = $petType;

                return $this;
        }

        /**
         * Get the value of breed
         */ 
        public function getBreed()
        {
                return $this->breed;
        }

        /**
         * Set the value of breed
         *
         * @return  self
         */ 
        public function setBreed($breed)
        {
                $this->breed = $breed;

                return $this;
        }

        /**
         * Get the value of size
         */ 
        public function getPetSize()
        {
                return $this->petSize;
        }

        /**
         * Set the value of size
         *
         * @return  self
         */ 
        public function setPetSize(PetSize $petSize)
        {
                $this->petSize = $petSize;

                return $this;
        }

        /**
         * Get the value of observation
         */ 
        public function getObservation()
        {
                return $this->observation;
        }

        /**
         * Set the value of observation
         *
         * @return  self
         */ 
        public function setObservation($observation)
        {
                $this->observation = $observation;

                return $this;
        }

        /**
         * Get the value of picture
         */ 
        public function getPicture()
        {
                return $this->picture;
        }

        /**
         * Set the value of picture
         *
         * @return  self
         */ 
        public function setPicture($picture)
        {
                $this->picture = $picture;

                return $this;
        }

        /**
         * Get the value of vacunationPlan
         */ 
        public function getVacunationPlan()
        {
                return $this->vacunationPlan;
        }

        /**
         * Set the value of vacunationPlan
         *
         * @return  self
         */ 
        public function setVacunationPlan($vacunationPlan)
        {
                $this->vacunationPlan = $vacunationPlan;

                return $this;
        }

        /**
         * Get the value of video
         */ 
        public function getVideo()
        {
                return $this->video;
        }

        /**
         * Set the value of video
         *
         * @return  self
         */ 
        public function setVideo($video)
        {
                $this->video = $video;

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