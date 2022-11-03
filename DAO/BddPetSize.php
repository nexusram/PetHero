<?php

namespace DAO;

use DAO\IViews as IViews;
use DAO\Connection as Connection;
use \Exception as Exception;
use Models\PetSize;

class BddPetSize
{
    private $PetSizeList = array();
    private $connection;
    private $tableName = "PetSize";
    /*
                 $value["id"] = $petType->getId();
                $value["name"] = $petType->getName();

                      $petType = new PetType();
                    $petType->setId($value["id"]);
                    $petType->setName($value["name"]);

*/

    public function Add(PetSize $petSize)
    {
        $petSize->setId($this->GetNextId()); //seteo el id autoincremental
        try {

            $query = "INSERT INTO . $this->tableName . (id,name) VALUES (:id,:name);";
            $valuesArray["id"] = $petSize->getId();
            $valuesArray["name"] = $petSize->getName();
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
                $petSize = new PetSize();
                $petSize->setId($valuesArray["id"]);
                $petSize->setName($valuesArray["name"]);
                array_push($petSizeList, $petSize);
            }

            return $UserList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function Modify(PetSize $petSize)
    {
        $this->connection = Connection::GetInstance();
        $consulta = "UPDATE . $this->tableName .
        SET id= $petSize->getId(),name= $petSize->getName()
        . WHERE id = $petSize->getId()";
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
    private function GetNextId() {
        $id = 0;

        foreach($this->petSizeList as $petSize) {
            $id = ($petSize->getId() > $id) ? $petSize->getId() : $id;
        }

        return $id + 1;
    }
    
    public function GetById($id) {
        $this->RetrieveData();

        $array = array_filter($this->petSizeList, function($petSize) use($id) {
            return $petSize->getId() == $id;
        });

        $array = array_values($array);
        
        return (count($array) > 0) ? $array[0] : null;
    }
    
}
