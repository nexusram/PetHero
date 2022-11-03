<?php

namespace DAO;

use DAO\IViews as IViews;
use DAO\Connection as Connection;
use \Exception as Exception;
use DAO\IBreedDAO;
use Models\Breed;
use DAO\PetTypeDAO;

class BddBooking
{
    private $breedList = array();
    private $connection;
    private $tableName = "Breed";

    /*
 private $id;
        private $name;
        private PetType $petType;
        */
    public function Add(Breed $breed)
    {
        $breed->setId($this->GetNextId()); //seteo el id autoincremental
        try {


            $query = "INSERT INTO . $this->tableName . ('Id','name','petType') VALUES (:Id,:name,:petType);";

            $valuesArray["Id"] = $breed->getId();
            $valuesArray["name"] = $breed->getName();
            $valuesArray["petType"] = $breed->getPetType()->getId();
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $valuesArray);
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    /*
    public function RetrieveData()
    {
        try {
            $breedList = array();

            $query = "SELECT * FROM  . $this->tableName;";

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query);

            foreach ($resultSet as $valuesArray) {
                $Breed = new Breed();

                $Breed->setId($valuesArray["id"]);
                $breed->setName($valuesArray["name"]);
                 $petTypeDAO = new PetTypeDAO();
                    $petType = $petTypeDAO->GetById($valuesArray["petType"]);
                    $breed->setPetType($petType);

                array_push($breedList, $breed);
            }

            return $breedList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    */

    public function Remove($id)
    {
        $this->connection = Connection::GetInstance();
        $aux = "DELETE From . $this->tableName . WHERE id = '$id';";
        $connection = $this->connection;
        $connection->Execute($aux);
    }

    private function GetNextId()
    {
        $id = 0;
        //$this->RetrieveData();
        foreach ($this->breedList as $breed) {
            $id = ($breed->getId() > $id) ? $breed->getId() : $id;
        }

        return $id + 1;
    }
    public function GetById($id)
    {
        //$this->RetrieveData();

        $arrayBreed = array_filter($this->breedList, function ($breed) use ($id) {
            return $breed->getId() == $id;
        });

        $arrayBreed = array_values($arrayBreed);

        return (count($arrayBreed) > 0) ? $arrayBreed[0] : null;
    }
}
