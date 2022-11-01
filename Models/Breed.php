<?php
    namespace Models;

    use Models\PetType;

    class Breed{
        private $id;
        private $name;
        private PetType $petType;//para este atributo necesito si o si el tipo de mascota, para relacionar 

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
    }
?>