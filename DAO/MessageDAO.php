<?php

namespace DAO;

use DAO\Connection as Connection;
use \Exception as Exception;
use Models\User;
use Models\Keeper;
use Models\message;

class MessageDAO implements IMessageDAO
{
    private $tableName = "message";
    private $messageList = array();
    private $connection;

//add messages
    public function Add(Message $message)
    {
        $this->Insert($message);
    }

//return message list
    public function GetAll()
    {
        $this->RetrieveDate();
        return $this->messageList;
    }

//return message list for user and keeper
    public function GetByUser($id_user, $id_Keeper)
    {
        $query = "SELECT * FROM $this->tableName WHERE id_user = {$id_user} and id_keeper={$id_Keeper};";
        $this->GetAllQuery($query);
        return $this->messageList;
    }

///*return all Result of Query */
    private function GetAllQuery($query)
    {
        $this->messageList = array();
        try {
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query);
            foreach ($resultSet as $value) {
                $message = new message();
                $message->setId($value["id"]);

                // Set User
                $userDAO = new UserDAO();
                $user = $userDAO->GetById($value["id_user"]);
                $message->setUser($user);

                // Set Breed
                $keeperDAO = new KeeperDAO();
                $keeper = $keeperDAO->GetById($value["id_keeper"]);
                $message->setKeeper($keeper);

                $message->setMessage($value["text"]);
                 
                $message->setAuthor($value["author"]);

                array_push($this->messageList, $message);
            }
        } catch (Exception $ex) {
            throw $ex;
        }
    }

//return messages list
    private function RetrieveDate()
    {
        $query = "SELECT * FROM $this->tableName";
        $this->GetAllQuery($query);
    }

//insert message
    private function Insert(message $message)
    {
        $query = "INSERT INTO $this->tableName (id,id_user,id_keeper,text,author) VALUES (:id,:id_user, :id_keeper, :text, :author);";
        $this->SetQuery($message, $query);
    }

     //Insert a keeper in the Query//
    private function SetQuery($message, $query)
    {
        try {
            $valuesArray["id"] = $message->getId();
            $valuesArray["id_user"] = $message->getUser()->getId();
            $valuesArray["id_keeper"] = $message->getKeeper()->getId();
            $valuesArray["text"] = $message->getMessage();
            $valuesArray["author"] = $message->getAuthor();
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $valuesArray);
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}
