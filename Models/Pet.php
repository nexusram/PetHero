<?php

    namespace Models;

    class Pet {
        private $id;
        private $idOwner;
        private $name;
        private $photo;
        private $size;
        private $petType;
        private $breed;
        private $video;
        private $vacunationPlanPhoto;
        private $vacunationObservation;

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
         * Get the value of idOwner
         */ 
        public function getIdOwner()
        {
                return $this->idOwner;
        }

        /**
         * Set the value of idOwner
         *
         * @return  self
         */ 
        public function setIdOwner($idOwner)
        {
                $this->idOwner = $idOwner;

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
        public function setPetType($petType)
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
    }
?>