<?php

    namespace Models;
    use Models\Booking;

    class Coupon {
        private $id;
        private Booking $booking;
        private $method;
        private $isPayment;
        private $discount;
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
         * Get the value of idBooking
         */ 
        public function getIdBooking()
        {
                return $this->idBooking;
        }

        /**
         * Set the value of idBooking
         *
         * @return  self
         */ 
        public function setIdBooking(Booking $booking)
        {
                $this->Booking = $booking;

                return $this;
        }

        /**
         * Get the value of method
         */ 
        public function getMethod()
        {
                return $this->method;
        }

        /**
         * Set the value of method
         *
         * @return  self
         */ 
        public function setMethod($method)
        {
                $this->method = $method;

                return $this;
        }

        /**
         * Get the value of isPayment
         */ 
        public function getIsPayment()
        {
                return $this->isPayment;
        }

        /**
         * Set the value of isPayment
         *
         * @return  self
         */ 
        public function setIsPayment($isPayment)
        {
                $this->isPayment = $isPayment;

                return $this;
        }

        /**
         * Get the value of discount
         */ 
        public function getDiscount()
        {
                return $this->discount;
        }

        /**
         * Set the value of discount
         *
         * @return  self
         */ 
        public function setDiscount($discount)
        {
                $this->discount = $discount;

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