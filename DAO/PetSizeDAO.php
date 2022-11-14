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

    public function Add(PetSize $petSize)
    {
        $petSize->setId($this->GetNextId()); //seteo el id autoincremental
        try {

            $query = "INSERT INTO  $this->tableName (id,name) VALUES (:id,:name);";
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
        //$this->petSizeList = array();
        try {

            $query = "SELECT * FROM $this->tableName";

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
        $this->connection = Connection::GetInstance();
        $consulta = "UPDATE $this->tableName 
        SET id= $petSize->getId(),name= $petSize->getName()
         WHERE id = $petSize->getId()";
        $connection = $this->connection;
        $connection->Execute($consulta);
    }

    public function Remove($id)
    {
        $this->connection = Connection::GetInstance();
        $aux = "DELETE From  $this->tableName WHERE Id = $id";
        $connection = $this->connection;
        $connection->Execute($aux);
    }

    public function GetById($id)
    {
        $this->RetrieveData();
        $array = array_filter($this->petSizeList, function ($petSize) use ($id) {
            return $petSize->getId() == $id;
        });

        $array = array_values($array);

        return (count($array) > 0) ? $array[0] : null;
    }
}
