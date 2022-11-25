<?php

    namespace DAO;
    use \Exception as Exception;
    use DAO\Connection as Connection;

    use Models\Chat;

    class ChatDAO{
        //private $chatList = array();
        private $connection;
        private $tableName = "chat";

        public function Add(Chat $chat)
        {
            $this->Insert($chat);
        }

        public function GetUserChats($userId){

            $query = "SELECT DISTINCT reciever_user_id FROM $this->tableName
            WHERE messenger_user_id = {$userId};";
           
            return $this->GetResult($query);
        }
    
        public function GetConversation($userId, $receptorId){
            $query = "SELECT message, created_on  FROM $this->tableName 
            WHERE messenger_user_id = {$userId} and receiver_user_id = {$receptorId}
            OR
            WHERE messenger_user_id = {$receptorId} and receiver_user_id = {$userId};";

            return $this->GetResult($query);
        }

        private function GetResult($query)
        {
        try {
            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($query);
           
            $chat = new Chat();
            if (!empty($result)) {
                $chat->setId($result[0]["id"]);
              
                $chat->setCreated_on($result[0]["created_on"]);
                $chat->setStatus($result[0]["status"]);

                // Set User messenger
                $userDAO = new UserDAO();
                $user = $userDAO->GetById($result[0]["messenger_user_id"]);
                $chat->setMessenger_user_id($user);

                // Set User Reciever
                $reciever = $userDAO->GetById($result[0]["reciever_user_id"]);
                $chat->setReciever_user_id($reciever);

                }
            } catch (Exception $ex) {
            throw $ex;
            }
            return $chat;
        }

        private function Insert(Chat $chat)
        {
        $query = "INSERT INTO  $this->tableName (messenger_user_id, reciever_user_id, message, created_on, status) 
        VALUES (:messenger_user_id,:reciever_user_id,:message,:created_on,:status);";
        $this->SetAllquery($chat, $query);
        }

        private function SetAllquery(Chat $chat, $query)
        {
            try {
                $parameters["messenger_user_id"] = $chat->getMessenger_user_id()->getId();
                $parameters["reciever_user_id"] = $chat->getReciever_user_id()->getId();
                $parameters["message"] = $chat->getMessage();
                $parameters["created_on"] = $chat->getCreated_on();
                $parameters["status"] = $chat->getStatus();
    
                $this->connection = Connection::GetInstance();
                $this->connection->ExecuteNonQuery($query, $parameters);
            } catch (Exception $ex) {
                throw $ex;
            }
        }

     
    }

?>