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

    public function Add(PetType $petType)
    {
        $result = $this->MaxPetType();
        $petType->setId(++$result); //seteo el id autoincremental
        $query = "INSERT INTO . $this->tableName . (id,name) VALUES (:id,:name);";
        $this->SetQuery($query, $petType);
    }

    public function GetAll()
    {
        $this->RetrieveData();
        return $this->petTypeList;
    }

    private function RetrieveData()
    {
        $query = "SELECT * FROM $this->tableName";
        $this->GetAllQuery($query);
    }

    public function Modify(petType $petType)
    {
        $this->Update($petType);
    }

    public function GetById($id)
    {
        $query = "SELECT * FROM $this->tableName where id = {$id};";
        return $this->GetResult($query);
    }

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

    private function SetQuery($query,PetType $petType)
    {
        try {
            $parameters["id"] = $petType->getId();
            $parameters["name"] = $petType->getName();
            var_dump($petType->getId());
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}
