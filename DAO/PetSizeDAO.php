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

    //return max id petSize
    public function MaxSize()
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

//add petSize
    public function Add(PetSize $petSize)
    {
        $result = $this->MaxSize();
        $petSize->setId(++$result);
        $query = "INSERT INTO  $this->tableName (id,name) VALUES (:id,:name);";
        $this->SetQuery($petSize, $query);
    }

//Insert a petSizee in the Query//
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

//return all results query
    public function GetAll()
    {
        $this->RetrieveData();
        return $this->petSizeList;
    }

//return all results query
    private function RetrieveData()
    {
        $query = "SELECT * FROM $this->tableName";
        $this->GetAllQuery($query);
    }

 /*return all Result of Query */
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

    //modify petSize
    public function Modify(PetSize $petSize)
    {
        $this->Update($petSize);
    }

//modify petSize
    private function Update(PetSize $petSize)
    {
        $query = "UPDATE $this->tableName SET id = :id, name = :name WHERE id = {$petSize->getId()};";
        $this->SetQuery($petSize, $query);
    }

//return petSize for id
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
