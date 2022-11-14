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
        try {

            //$query = "INSERT INTO  $this->tableName (id,userType,name,surname,userName,password,email,birthDay,cellphone,address) VALUES (:id,:userType,:name,:surname,:userName,:password,:email,:birthDay,:cellphone,:address);"
            $query = "INSERT INTO  $this->tableName (userType,name,surname,userName,password,email,birthDay,cellphone,address) VALUES (:userType,:name,:surname,:userName,:password,:email,:birthDay,:cellphone,:address);";
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
    public function GetAll()
    {
        $this->RetrieveData();
        return $this->userList;
    }

    private function RetrieveData()
    {
        try {

            $query = "SELECT * FROM $this->tableName";

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
                array_push($this->userList, $user);
            }
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function Modify(User $user)
    {
        $this->connection = Connection::GetInstance();
        $consulta = "UPDATE  $this->tableName 
        SET id= $user->getId(),userType= $user->getUserType(),name= $user->getName(),surname=$user->getSurname(),userName=$user->getUserName(),password=$user->getPassword(),email=$user->getEmail(),birthDay=$user->getBirthDay(),cellphone=$user->getCellphone(),address=$user->getAddress()
        WHERE id = $user->getId();";
        $connection = $this->connection;
        $connection->Execute($consulta);
    }

    public function Remove($id)
    {
        $this->connection = Connection::GetInstance();
        $aux = "DELETE From $this->tableName WHERE Id = $id";
        $connection = $this->connection;
        $connection->Execute($aux);
    }

    public function CountUser()
    {
        $this->RetrieveData();
        return count($this->userList);
    }

    public function GetById($id)
    {
        $this->RetrieveData();

        $array = array_filter($this->userList, function ($user) use ($id) {
            return $user->getId() == $id;
        });

        $array = array_values($array);

        return (count($array) > 0) ? $array[0] : null;
    }

    public function GetByUserName($userName)
    {
        $this->RetrieveData();

        $array = array_filter($this->userList, function ($user) use ($userName) {
            return $user->getUserName() == $userName;
        });

        $array = array_values($array);

        return (count($array) > 0) ? $array[0] : null;
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
}
