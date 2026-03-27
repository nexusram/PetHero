<?php

namespace DAO;

use DAO\Connection as Connection;
use \Exception as Exception;
use DAO\IPetDAO;
use Models\PetType;

class PetTypeDAO implements IPetTypeDAO
{
    private $petTypeList = array();
    private $connection;
    private $tableName = "PetType";

    //return max id petType
    public function MaxPetType()
    {
        try {
            $query = "SELECT MAX(id) as cont FROM $this->tableName";

            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($query);
        } catch (Exception $ex) {
            throw $result;
        }
        return $result;
    }

    //add petType
    public function Add(PetType $petType)
    {
        $result = $this->MaxPetType();
        $petType->setId(++$result);
        $query = "INSERT INTO . $this->tableName . (id,name) VALUES (:id,:name);";
        $this->SetQuery($query, $petType);
    }

    //return all petType
    public function GetAll()
    {
        $this->RetrieveData();
        return $this->petTypeList;
    }

    //return all petType
    private function RetrieveData()
    {
        $query = "SELECT * FROM $this->tableName";
        $this->GetAllQuery($query);
    }

//modify petType
    public function Modify(petType $petType)
    {
        $this->Update($petType);
    }

//return all petType for id
    public function GetById($id)
    {
        $query = "SELECT * FROM $this->tableName where id = {$id};";
        return $this->GetResult($query);
    }

//modify petType
    private function Update(PetType $petType)
    {
        $query = "UPDATE $this->tableName SET id = :id, name = :name WHERE id = {$petType->getId()};";
        $this->SetQuery($query,$petType);
    }

    /*return Result of Query */
    private function GetResult($query)
    {
        try {
            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($query);
            $petType = null;
            if (!empty($result)) {

                $petType = new PetType();
                $petType->setId($result[0]['id']);
                $petType->setName($result[0]['name']);
            }
        } catch (Exception $ex) {
            throw $ex;
        }
        return $petType;
    }

    /*return all Result of Query */
    private function GetAllQuery($query)
    {
        $this->petTypeList = array();
        $this->connection = Connection::GetInstance();
        $parameters = $this->connection->Execute($query);
        foreach ($parameters as $valuesArray) {
            $petType = new PetType();
            $petType->setId($valuesArray["id"]);
            $petType->setName($valuesArray["name"]);
            array_push($this->petTypeList, $petType);
        }
    }

    //Insert a petType in the Query//
    private function SetQuery($query,PetType $petType)
    {
        try {
            $parameters["id"] = $petType->getId();
            $parameters["name"] = $petType->getName();
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}
