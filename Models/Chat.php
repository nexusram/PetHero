<?php
    namespace Models;

    class Chat{
        private $id;
        private User $messenger_user_id;
        private User $reciever_user_id;
        private $message;
        private $created_on;
        private $status;


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
         * Get the value of messenger_user_id
         */ 
        public function getMessenger_user_id()
        {
                return $this->messenger_user_id;
        }

        /**
         * Set the value of messenger_user_id
         *
         * @return  self
         */ 
        public function setMessenger_user_id($messenger_user_id)
        {
                $this->messenger_user_id = $messenger_user_id;

                return $this;
        }

        /**
         * Get the value of reciever_user_id
         */ 
        public function getReciever_user_id()
        {
                return $this->reciever_user_id;
        }

        /**
         * Set the value of reciever_user_id
         *
         * @return  self
         */ 
        public function setReciever_user_id($reciever_user_id)
        {
                $this->reciever_user_id = $reciever_user_id;

                return $this;
        }

        /**
         * Get the value of message
         */ 
        public function getMessage()
        {
                return $this->message;
        }

        /**
         * Set the value of message
         *
         * @return  self
         */ 
        public function setMessage($message)
        {
                $this->message = $message;

                return $this;
        }

        /**
         * Get the value of created_on
         */ 
        public function getCreated_on()
        {
                return $this->created_on;
        }

        /**
         * Set the value of created_on
         *
         * @return  self
         */ 
        public function setCreated_on($created_on)
        {
                $this->created_on = $created_on;

                return $this;
        }

        /**
         * Get the value of status
         */ 
        public function getStatus()
        {
                return $this->status;
        }

        /**
         * Set the value of status
         *
         * @return  self
         */ 
        public function setStatus($status)
        {
                $this->status = $status;

                return $this;
        }
    } 
?>