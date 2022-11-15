<?php

namespace DAO;

use DAO\Connection as Connection;
use \Exception as Exception;
use Models\User;

class UserDAO implements IUserDAO
{
    private $userList = array();
    private $connection;
    private $tableName = "User";

    public function Add(User $user)
    {
        $this->Insert($user);
    }

    public function Modify(User $user)
    {
        $this->Update($user);
    }
    
    public function GetAll()
    {
        $this->RetrieveData();
        return $this->userList;
    }

    public function CountUser()
    {
        try {
            $query = "SELECT COUNT(*) FROM $this->tableName";

            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($query);
        } catch {
            throw $result;
        }
        return $result;
    }

    public function GetById($id)
    {
        try {
            $query = "SELECT * FROM $this->tableName WHERE id = {$id}"; 

            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($query);
        } catch(Exception $ex) {
            throw $ex;
        }
        return $result;
    }

    public function GetByUserName($userName)
    {
        try {
            $query = "SELECT * FROM $this->tableName WHERE userName like $userName";

            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($query);
        } catch(Exception $ex) {
            throw $ex;
        }
        return $result;
    }

    public function GetByEmail($email) {
        try {
            $query = "SELECT * FROM $this->tableName WHERE email like $email";

            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($query);
        } catch(Exception $ex) {
            throw $ex;
        }
        return $result;
    }

    public function GetByUsermail($userName)
    {
        $return = $this->GetByUserName($userName);
        return $return->getEmail();
    }

    public function GetByUserPassword($userName)
    {
        $return = $this->GetByUserName($userName);
        return $return->getPassword();
    }

    // Insert a user in the table
    private function Insert(User $user) {
        try {

            $query = "INSERT INTO  $this->tableName (userType, name, surname, userName, password, email, birthDay, cellphone, address) VALUES (:userType, :name, :surname, :userName, :password, :email, :birthDay, :cellphone, :address);";
            
            $parameters["userType"] = $user->getUserType();
            $parameters["name"] = $user->getName();
            $parameters["surname"] = $user->getSurname();
            $parameters["userName"] = $user->getUserName();
            $parameters["password"] = $user->getPassword();
            $parameters["email"] = $user->getEmail();
            $parameters["birthDay"] = $user->getBirthDay();
            $parameters["cellphone"] = $user->getCellphone();
            $parameters["address"] = $user->getAddress();

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $valuesArray);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    // Update a user in the table
    private function Update(User $user) {
        try {
            $query = "UPDATE $this->tableName SET userType = :userType, name = :name, surname = :surname, userName = :userName, password = :password, email = :email, birthDay = :birthDay, cellphone = :cellphone, address = :address WHERE id = {$user->getId()};";

            $paremeters["userType"] = $user->getUserType();
            $parameters["name"] = $user->getName();
            $paremeters["surname"] = $user->getSurname();
            $parameters["userName"] = $user->getUserName();
            $parameters["password"] = $user->getPassword();
            $parameters["email"] = $user->getEmail();
            $parameters["birthDay"] = $user->getBirthDay();
            $parameters["cellphone"] = $user->getCellphone();
            $parameters["address"] = $user->getAddress();

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch(Exception $ex) {
            throw $ex;
        }
    }

    // Set list pet with info of table
    private function RetrieveData()
    {
        try {

            $query = "SELECT * FROM $this->tableName";

            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($query);

            foreach ($result as $valuesArray) {
                $user = new User();
                $user->setId($valuesArray["id"]);
                $user->setUserType($valuesArray["userType"]);
                $user->setName($valuesArray["name"]);
                $user->setSurname($valuesArray["surname"]);
                $user->setUserName($valuesArray["userName"]);
                $user->setPassword($valuesArray["password"]);
                $user->setEmail($valuesArray["email"]);
                $user->setBirthDay($valuesArray["birthDay"]);
                $user->setCellphone($valuesArray["cellphone"]);
                $user->setAddress($valuesArray["address"]);
                array_push($this->userList, $user);
            }
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}
