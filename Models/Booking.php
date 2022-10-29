<?php

    namespace Models;

    class Booking {
        private $id;
        private $idOwner;
        private $idKeeper;
        private $idPet;
        private $idCoupon;
        private $startDate;
        private $endDate;
        private $state;
        private $validate;
        private $total;

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
         * Get the value of idKeeper
         */ 
        public function getIdKeeper()
        {
                return $this->idKeeper;
        }

        /**
         * Set the value of idKeeper
         *
         * @return  self
         */ 
        public function setIdKeeper($idKeeper)
        {
                $this->idKeeper = $idKeeper;

                return $this;
        }

        /**
         * Get the value of idMascota
         */ 
        public function getIdPet()
        {
                return $this->idPet;
        }

        /**
         * Set the value of idMascota
         *
         * @return  self
         */ 
        public function setIdPet($idPet)
        {
                $this->idPet = $idPet;

                return $this;
        }

        /**
         * Get the value of idCupon
         */ 
        public function getIdCoupon()
        {
                return $this->idCoupon;
        }

        /**
         * Set the value of idCupon
         *
         * @return  self
         */ 
        public function setIdCoupon($idCoupon)
        {
                $this->idCoupon = $idCoupon;

                return $this;
        }

        /**
         * Get the value of contratedDayList
         */ 
        public function getContratedDayList()
        {
                return $this->contratedDayList;
        }

        /**
         * Set the value of contratedDayList
         *
         * @return  self
         */ 
        public function setContratedDayList($contratedDayList)
        {
                $this->contratedDayList = $contratedDayList;

                return $this;
        }

        /**
         * Get the value of state
         */ 
        public function getState()
        {
                return $this->state;
        }

        /**
         * Set the value of state
         *
         * @return  self
         */ 
        public function setState($state)
        {
                $this->state = $state;

                return $this;
        }

        /**
         * Get the value of total
         */ 
        public function getTotal()
        {
                return $this->total;
        }

        /**
         * Set the value of total
         *
         * @return  self
         */ 
        public function setTotal($total)
        {
                $this->total = $total;

                return $this;
        }

        /**
         * Get the value of startDate
         */ 
        public function getStartDate()
        {
                return $this->startDate;
        }

        /**
         * Set the value of startDate
         *
         * @return  self
         */ 
        public function setStartDate($startDate)
        {
                $this->startDate = $startDate;

                return $this;
        }

        /**
         * Get the value of endDate
         */ 
        public function getEndDate()
        {
                return $this->endDate;
        }

        /**
         * Set the value of endDate
         *
         * @return  self
         */ 
        public function setEndDate($endDate)
        {
                $this->endDate = $endDate;

                return $this;
        }

        /**
         * Get the value of validate
         */ 
        public function getValidate()
        {
                return $this->validate;
        }

        /**
         * Set the value of validate
         *
         * @return  self
         */ 
        public function setValidate($validate)
        {
                $this->validate = $validate;

                return $this;
        }
    }
?>