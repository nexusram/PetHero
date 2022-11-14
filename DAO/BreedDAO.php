<?php

namespace DAO;

use DAO\Connection as Connection;
use \Exception as Exception;
use DAO\IBreedDAO;
use Models\Breed;
use DAO\PetTypeDAO;

class BreedDAO implements IBreedDAO
{
    private $breedList = array();
    private $connection;
    private $tableName = "Breed";

    public function Add(Breed $breed)
    {
        $this->Add($breed);
    }

    public function Modify(Breed $breed)
    {
        $this->Update($breed);
    }

    public function GetAll()
    {
        $this->RetrieveData();
        return $this->breedList;
    }

    public function GetById($id)
    {
        $this->RetrieveData();

        $arrayBreed = array_filter($this->breedList, function ($breed) use ($id) {
            return $breed->getId() == $id;
        });

        $arrayBreed = array_values($arrayBreed);

        return (count($arrayBreed) > 0) ? $arrayBreed[0] : null;
    }

    public function GetListByPetType($petTypeId)
    {
        $this->RetrieveData();

        $array = array_filter($this->breedList, function ($breed) use ($petTypeId) {
            return $breed->getPetType()->getId() == $petTypeId;
        });

        return $array;
    }

    // Insert a breed in the table
    private function Insert(Breed $breed) {
        try {

            $query = "INSERT INTO $this->tableName (id,name,petType) VALUES (:Id,:name,:petType);";

            $valuesArray["name"] = $breed->getName();
            $valuesArray["petType"] = $breed->getPetType()->getId();

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $valuesArray);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    // Update a breed in the table
    private function Update(Breed $breed) {
        try {
            $query = "UPDATE $this->tableName SET name = :name, petType = :petType WHERE id = {$breed->getId()};";

            $parameters["name"] = $breed->getName();
            $parameters["petType"] = $breed->getPetType()->getId();

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch(Exception $ex) {
            throw $ex;
        }
    }

    // Set list breed with info of table
    private function RetrieveData()
    {    
        try {
            $query = "SELECT * FROM  $this->tableName;";

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query);

            foreach ($resultSet as $valuesArray) {
                $breed = new Breed();
                
                $breed->setId($valuesArray["id"]);
                $breed->setName($valuesArray["name"]);
                $petTypeDAO = new PetTypeDAO();
                $petType = $petTypeDAO->GetById($valuesArray["petType"]);
                $breed->setPetType($petType);

                array_push($this->breedList, $breed);
            }
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}
