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

    public function Add(PetType $petType)
    {
        $petType->setId($this->GetNextId()); //seteo el id autoincremental
        try {

            $query = "INSERT INTO . $this->tableName . (id,name) VALUES (:id,:name);";
            $valuesArray["id"] = $petType->getId();
            $valuesArray["name"] = $petType->getName();
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $valuesArray);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function GetAll()
    {
        $this->RetrieveData();
        return $this->petTypeList;
    }

    private function RetrieveData()
    {
        try {
            $query = "SELECT * FROM $this->tableName";

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query);

            foreach ($resultSet as $valuesArray) {
                $petType = new PetType();
                $petType->setId($valuesArray["id"]);
                $petType->setName($valuesArray["name"]);
                array_push($this->petTypeList, $petType);
            }
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function Modify(petType $petType)
    {
        $this->connection = Connection::GetInstance();
        $consulta = "UPDATE  $this->tableName 
        SET id= $petType->getId(),name= $petType->getName()
         WHERE id = $petType->getId()";
        $connection = $this->connection;
        $connection->Execute($consulta);
    }

    public function Remove($id)
    {
        $this->connection = Connection::GetInstance();
        $aux = "DELETE From  $this->tableName  WHERE Id = $id";
        $connection = $this->connection;
        $connection->Execute($aux);
    }

    public function GetById($id) {
        $this->RetrieveData();
        $array = array_filter($this->petTypeList, function($petType) use($id) {
            return $petType->getId() == $id;
        });

        $array = array_values($array);

        return (count($array) > 0) ? $array[0] : null;
    }
}
