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
    private $tableName = "breed";

    public function Add(Breed $breed)
    {
        $this->Insert($breed);
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
        //$this->RetrieveData();

        //$arrayBreed = array_filter($this->breedList, function ($breed) use ($id) {
          //  return $breed->getId() == $id;
        //});

        //$arrayBreed = array_values($arrayBreed);

        //return (count($arrayBreed) > 0) ? $arrayBreed[0] : null;
        $query = "SELECT * FROM $this->tableName 
        WHERE id = {$id};";
        return $this->GetResult($query);
    }

    public function GetListByPetType($petTypeId)
    {
        //$this->RetrieveData();

        //$array = array_filter($this->breedList, function ($breed) use ($petTypeId) {
          //  return $breed->getPetType()->getId() == $petTypeId;
        //});
        $query =  "SELECT * FROM $this->tableName 
        WHERE id_petType = {$petTypeId}";   
        $this->GetAllQuery($query);
        return $this->breedList;
        //return $array;
    }

    private function GetResult($query)
    {
    try {
        $this->connection = Connection::GetInstance();
        $result = $this->connection->Execute($query);
       
        $breed = new Breed();
        if (!empty($result)) {
           
            $breed->setId($result[0]["id"]);
          
            $breed->setName($result[0]["name"]);

            // Set petType 
            $petTypeDAO = new petTypeDAO();
            $petType = $petTypeDAO->GetById($result[0]["id_petType"]);
            $breed->setPetType($petType);
            
        }
        } catch (Exception $ex) {
        throw $ex;
        }
        return $breed;
    }

    private function GetAllQuery($query)
    {
        $this->breedList = array();
        $this->connection = Connection::GetInstance();
        $parameters = $this->connection->Execute($query);
        foreach ($parameters as $valuesArray) {
            $breed = new Breed();
            $breed->setId($valuesArray["id"]);
            $breed->setName($valuesArray["name"]);

            // Set petType 
            $petTypeDAO = new petTypeDAO();
            $petType = $petTypeDAO->GetById($valuesArray["id_petType"]);
            $breed->setPetType($petType);

            array_push($this->breedList, $breed);
        }
        
    }

    // Insert a breed in the table
    private function Insert(Breed $breed) {
            $query = "INSERT INTO $this->tableName (id, name, id_petType) VALUES (:Id, :name, :petType);";

            $this->SetAllquery($breed, $query);
        }

        private function SetAllquery(Breed $breed, $query)
        {
            try {
             
                $parameters["name"] = $breed->getName();
                $parameters["petType"] = $breed->getPetType()->getId();

                $this->connection = Connection::GetInstance();
                $this->connection->ExecuteNonQuery($query, $parameters);
            } catch (Exception $ex) {
                throw $ex;
            }
        }

    // Update a breed in the table
    private function Update(Breed $breed) {
        try {
            $query = "UPDATE $this->tableName SET name = :name, id_petType = :id_petType WHERE id = {$breed->getId()};";

            $parameters["name"] = $breed->getName();
            $parameters["id_petType"] = $breed->getPetType()->getId();

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
                $petType = $petTypeDAO->GetById($valuesArray["id_petType"]);
                $breed->setPetType($petType);

                array_push($this->breedList, $breed);
            }
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}
