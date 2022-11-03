<?php

namespace DAO;

use DAO\IViews as IViews;
use DAO\Connection as Connection;
use \Exception as Exception;
use Models\User;

class BddKeeper
{
    private $UserList = array();
    private $connection;
    private $tableName = "User";
    /*

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

            $value["id"] = $user->getId();
            $value["userType"] = $user->getUserType();
            $value["name"] = $user->getName();
            $value["surname"] = $user->getSurname();
            $value["userName"] = $user->getUserName();
            $value["password"] = $user->getPassword();
            $value["email"] = $user->getEmail();
            $value["birthDay"] = $user->getBirthDay();
            $value["cellphone"] = $user->getCellphone();
            $value["address"] = $user->getAddress();

             $user = new User();
                $user->setId($value["id"]);
                $user->setUserType($value["userType"]);
                $user->setName($value["name"]);
                $user->setSurname($value["surname"]);
                $user->setUserName($value["userName"]);
                $user->setPassword($value["password"]);
                $user->setEmail($value["email"]);
                $user->setBirthDay($value["birthDay"]);
                $user->setCellphone($value["cellphone"]);
                $user->setAddress($value["address"]);

*/

    public function Add(User $user)
    {
        $user->setId($this->GetNextId()); //seteo el id autoincremental
        try {

            $query = "INSERT INTO . $this->tableName . (id,userType,name,surname,userName,password,email,birthDay,cellphone,address) VALUES (:id,:userType,:name,:surname,:userName,:password,:email,:birthDay,:cellphone,:address);";
            $valuesArray["id"] = $user->getId();
            $valuesArray["userType"] = $user->getUserType();
            $valuesArray["name"] = $user->getName();
            $valuesArray["surname"] = $user->getSurname();
            $valuesArray["userName"] = $user->getUserName();
            $valuesArray["password"] = $user->getPassword();
            $valuesArray["email"] = $user->getEmail();
            $valuesArray["birthDay"] = $user->getBirthDay();
            $valuesArray["cellphone"] = $user->getCellphone();
            $valuesArray["address"] = $user->getAddress();
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $valuesArray);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function RetrieveData()
    {
        try {
            $UserList = array();

            $query = "SELECT * FROM " . $this->tableName;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query);

            foreach ($resultSet as $valuesArray) {
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
                array_push($UserList, $user);
            }

            return $UserList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function Modify(User $user)
    {
        $this->connection = Connection::GetInstance();
        $consulta = "UPDATE . $this->tableName .
        SET id= $user->getId(),userType= $user->getUserType(),name= $user->getName(),surname=$user->getSurname(),userName=$user->getUserName(),password=$user->getPassword(),email=$user->getEmail(),birthDay=$user->getBirthDay(),cellphone=$user->getCellphone(),address=$user->getAddress()
        . WHERE id = $user->getId()";
        $connection = $this->connection;
        $connection->Execute($consulta);
    }

    public function Remove($id)
    {
        $this->connection = Connection::GetInstance();
        $aux = "DELETE From . $this->tableName . WHERE Id = '$id'";
        $connection = $this->connection;
        $connection->Execute($aux);
    }

    private function GetNextId()
    {
        $id = 0;

        foreach ($this->users as $user) {
            $id = ($user->getId() > $id) ? $user->getId() : $id;
        }

        return $id + 1;
    }
    public function CountUser()
    {
        $this->RetrieveData();
        return count($this->users);
    }

    public function GetById($id)
    {
        $this->RetrieveData();

        $array = array_filter($this->users, function ($user) use ($id) {
            return $user->getId() == $id;
        });

        $array = array_values($array);

        return (count($array) > 0) ? $array[0] : null;
    }

    public function GetByUserName($userName)
    {
        $this->RetrieveData();

        $array = array_filter($this->users, function ($user) use ($userName) {
            return $user->getUserName() == $userName;
        });

        $array = array_values($array);

        return (count($array) > 0) ? $array[0] : null;
    }

    public function CheckHotmail($userName)
    {
        $this->RetrieveData();

        $array = array_filter($this->users, function ($user) use ($userName) {
            return $user->getEmail() == $userName;
        });

        $array = array_values($array);

        return (count($array) > 0) ? $array[0] : null;
    }

}
