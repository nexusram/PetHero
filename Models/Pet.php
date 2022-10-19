<?php

    namespace Models;

    class Pet {
        private $id;
        private $userId;
        private $name;
        private $photo;
        private $petTypeId;
        private $breed;
        private $video;
        private $vacunationPlanPhoto;
        private $vacunationObservation;
        private $details;

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
         * Get the value of photo
         */ 
        public function getPhoto()
        {
                return $this->photo;
        }

        /**
         * Set the value of photo
         *
         * @return  self
         */ 
        public function setPhoto($photo)
        {
                $this->photo = $photo;

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
         * Get the value of vacunationPlanPhoto
         */ 
        public function getVacunationPlanPhoto()
        {
                return $this->vacunationPlanPhoto;
        }

        /**
         * Set the value of vacunationPlanPhoto
         *
         * @return  self
         */ 
        public function setVacunationPlanPhoto($vacunationPlanPhoto)
        {
                $this->vacunationPlanPhoto = $vacunationPlanPhoto;

                return $this;
        }

        /**
         * Get the value of vacunationObservation
         */ 
        public function getVacunationObservation()
        {
                return $this->vacunationObservation;
        }

        /**
         * Set the value of vacunationObservation
         *
         * @return  self
         */ 
        public function setVacunationObservation($vacunationObservation)
        {
                $this->vacunationObservation = $vacunationObservation;

                return $this;
        }

        /**
         * Get the value of details
         */ 
        public function getDetails()
        {
                return $this->details;
        }

        /**
         * Set the value of details
         *
         * @return  self
         */ 
        public function setDetails($details)
        {
                $this->details = $details;

                return $this;
        }
    }
?>