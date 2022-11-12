<?php

namespace DAO;

use DAO\IViews as IViews;
use DAO\Connection as Connection;
use \Exception as Exception;
use DAO\IPetDAO;
use Models\PetType;
class PetTypeDAO
{
    private $petTypeList;
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

    public function RetrieveData()
    {
        $this->petTypeList = array();
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
            return $this->petTypeList;
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

    private function GetNextId() {
        $id = 0;

        foreach($this->petTypeList as $petType) {
            $id = ($petType->getId() > $id) ? $petType->getId() : $id;
        }

        return $id + 1;
    }
}
