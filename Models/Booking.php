<?php

    namespace Models;

    use Models\User;
    use Models\Keeper;
    use Models\Pet;
    use Models\Coupon;

    class Booking {
        private $id;
        private User $owner;
        private Keeper $keeper;
        private Pet $pet;
        private Coupon $coupon;
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
         * Get the value of owner
         */ 
        public function getOwner()
        {
                return $this->owner;
        }

        /**
         * Set the value of owner
         *
         * @return  self
         */ 
        public function setOwner(User $owner)
        {
                $this->owner = $owner;

                return $this;
        }

        /**
         * Get the value of keeper
         */ 
        public function getKeeper()
        {
                return $this->keeper;
        }

        /**
         * Set the value of keeper
         *
         * @return  self
         */ 
        public function setKeeper(Keeper $keeper)
        {
                $this->keeper = $keeper;

                return $this;
        }

        /**
         * Get the value of pet
         */ 
        public function getPet()
        {
                return $this->pet;
        }

        /**
         * Set the value of pet
         *
         * @return  self
         */ 
        public function setPet(Pet $pet)
        {
                $this->pet = $pet;

                return $this;
        }

        /**
         * Get the value of coupon
         */ 
        public function getCoupon()
        {
                return $this->coupon;
        }

        /**
         * Set the value of coupon
         *
         * @return  self
         */ 
        public function setCoupon(Coupon $coupon)
        {
                $this->coupon = $coupon;

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
    }  
?>