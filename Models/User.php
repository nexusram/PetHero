<?php

    namespace Models;

    use Models\Address as Address;

    class User {
        private $id;
        private $userName;
        private $password;
        private $email;
        private $name;
        private $surname;
        private $typeUser;
        private $idCellphone;
        private $idAddress;

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
         * Get the value of userName
         */ 
        public function getUserName()
        {
                return $this->userName;
        }

        /**
         * Set the value of userName
         *
         * @return  self
         */ 
        public function setUserName($userName)
        {
                $this->userName = $userName;

                return $this;
        }

        /**
         * Get the value of password
         */ 
        public function getPassword()
        {
                return $this->password;
        }

        /**
         * Set the value of password
         *
         * @return  self
         */ 
        public function setPassword($password)
        {
                $this->password = $password;

                return $this;
        }

        /**
         * Get the value of email
         */ 
        public function getEmail()
        {
                return $this->email;
        }

        /**
         * Set the value of email
         *
         * @return  self
         */ 
        public function setEmail($email)
        {
                $this->email = $email;

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
         * Get the value of surname
         */ 
        public function getSurname()
        {
                return $this->surname;
        }

        /**
         * Set the value of surname
         *
         * @return  self
         */ 
        public function setSurname($surname)
        {
                $this->surname = $surname;

                return $this;
        }

        /**
         * Get the value of typeUser
         */ 
        public function getTypeUser()
        {
                return $this->typeUser;
        }

        /**
         * Set the value of typeUser
         *
         * @return  self
         */ 
        public function setTypeUser($typeUser)
        {
                $this->typeUser = $typeUser;

                return $this;
        }

        /**
         * Get the value of idCellphone
         */ 
        public function getIdCellphone()
        {
                return $this->idCellphone;
        }

        /**
         * Set the value of idCellphone
         *
         * @return  self
         */ 
        public function setIdCellphone($idCellphone)
        {
                $this->idCellphone = $idCellphone;

                return $this;
        }

        /**
         * Get the value of address
         */ 
        public function getIdAddress()
        {
                return $this->idAddress;
        }

        /**
         * Set the value of address
         *
         * @return  self
         */ 
        public function setIdAddress($idAddress)
        {
                $this->idAddress = $idAddress;

                return $this;
        }
    }
?>