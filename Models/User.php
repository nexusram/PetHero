<?php

    namespace Models;

    class User {
        private $id;
        private $userType;
        private $name;
        private $surname;
        private $userName;
        private $password;
        private $email;
        private $birthDay;
        private $cellphone;
        private $address;

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
         * Get the value of userType
         */ 
        public function getUserType()
        {
                return $this->userType;
        }

        /**
         * Set the value of userType
         *
         * @return  self
         */ 
        public function setUserType($userType)
        {
                $this->userType = $userType;

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
         * Get the value of birthDay
         */ 
        public function getBirthDay()
        {
                return $this->birthDay;
        }

        /**
         * Set the value of birthDay
         *
         * @return  self
         */ 
        public function setBirthDay($birthDay)
        {
                $this->birthDay = $birthDay;

                return $this;
        }

        /**
         * Get the value of cellphone
         */ 
        public function getCellphone()
        {
                return $this->cellphone;
        }

        /**
         * Set the value of cellphone
         *
         * @return  self
         */ 
        public function setCellphone($cellphone)
        {
                $this->cellphone = $cellphone;

                return $this;
        }

        /**
         * Get the value of address
         */ 
        public function getAddress()
        {
                return $this->address;
        }

        /**
         * Set the value of address
         *
         * @return  self
         */ 
        public function setAddress($address)
        {
                $this->address = $address;

                return $this;
        }
    }
?>