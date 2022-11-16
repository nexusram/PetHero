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
        } catch (Exception $ex) {
            throw $result;
        }
        return $result;
    }

    public function GetById($id)
    {
        $query = "SELECT * FROM $this->tableName WHERE id like '$id'";
        return $this->GetResult($query);
    }

    public function GetByUserName($userName)
    {
        $query = "SELECT * FROM $this->tableName WHERE userName like '$userName'";

        return $this->GetResult($query);
    }

    public function GetByEmail($email)
    {
        $query = "SELECT * FROM $this->tableName WHERE email like '$email'";

        return $this->GetResult($query);
    }

    // Insert a user in the table
    private function Insert(User $user)
    {
        $query = "INSERT INTO  $this->tableName (userType, name, surname, userName, password, email, birthDay, cellphone, address) VALUES (:userType, :name, :surname, :userName, :password, :email, :birthDay, :cellphone, :address);";
        $this->SetAllQuery($query,$user);
    }

    // Update a user in the table
    private function Update(User $user)
    {
        $query = "UPDATE $this->tableName SET userType = :userType, name = :name, surname = :surname, userName = :userName, password = :password, email = :email, birthDay = :birthDay, cellphone = :cellphone, address = :address WHERE id = {$user->getId()};";
        $this->SetAllQuery($query,$user);
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

    /*return Result of Query */
    private function GetResult($query)
    {
        try {
            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query);
            $user = null;
            if (!empty($result)) {

                $user = new User();
                $user->setId($result[0]['id']);
                $user->setName($result[0]['name']);
                $user->setSurname($result[0]['surname']);
                $user->setPassword($result[0]['password']);
                $user->setAddress($result[0]['address']);
                $user->setUserType($result[0]['userType']);
                $user->setBirthDay($result[0]['birthDay']);
                $user->setEmail($result[0]['email']);
                $user->setUserName($result[0]['userName']);
                $user->setCellphone($result[0]['cellphone']);
            }
        } catch (Exception $ex) {
            throw $ex;
        }
        return $user;
    }

    private function SetAllQuery($query,User $user)
    {
        try {
            $parameters["userType"] = $user->getId();
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
            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}
