<?php

namespace DAO;

use DAO\Connection as Connection;
use \Exception as Exception;
use Models\PetSize;

class PetSizeDAO implements IPetSizeDAO
{
    private $petSizeList = array();
    private $connection;
    private $tableName = "PetSize";

    public function MaxPetType()
    {
        $query = "SELECT MAX(id) as cont FROM $this->tableName";
        try {

            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($query);
        } catch (Exception $ex) {
            throw $result;
        }
        return $result;
    }

    public function Add(PetSize $petSize)
    {
        $result = $this->MaxPetType();
        $petSize->setId(++$result); //seteo el id autoincremental
        $query = "INSERT INTO  $this->tableName (id,name) VALUES (:id,:name);";
        $this->SetQuery($petSize, $query);
    }

    private function SetQuery(PetSize $petSize, $query)
    {
        try {
            $valuesArray["id"] = $petSize->getId();
            $valuesArray["name"] = $petSize->getName();
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $valuesArray);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function GetAll()
    {
        $this->RetrieveData();
        return $this->petSizeList;
    }

    private function RetrieveData()
    {
        $query = "SELECT * FROM $this->tableName";
        $this->GetAllQuery($query);
    }

    private function GetAllQuery($query)
    {
        $this->petSizeList = array();
        try {
            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query);

            foreach ($resultSet as $valuesArray) {
                $petSize = new PetSize();
                $petSize->setId($valuesArray["id"]);
                $petSize->setName($valuesArray["name"]);
                array_push($this->petSizeList, $petSize);
            }
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    public function Modify(PetSize $petSize)
    {
        $this->Update($petSize);
    }

    private function Update(PetSize $petSize)
    {
        $query = "UPDATE $this->tableName SET id = :id, name = :name WHERE id = {$petSize->getId()};";
        $this->SetQuery($petSize, $query);
        /*$connection = $this->connection;
        $connection->Execute($query);*/
    }

    public function GetById($id)
    {
        $query = "SELECT * FROM $this->tableName where id = {$id};";
        return $this->GetResult($query);
    }
    /*return Result of Query */
    private function GetResult($query)
    {
        try {
            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($query);
            $petSize = null;
            if (!empty($result)) {

                $petSize = new PetSize();
                $petSize->setId($result[0]['id']);
                $petSize->setName($result[0]['name']);
            }
        } catch (Exception $ex) {
            throw $ex;
        }
        return $petSize;
    }
}
