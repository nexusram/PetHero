<?php

namespace DAO;

use DAO\Connection as Connection;
use \Exception as Exception;
use Models\Pet;
use DAO\PetTypeDAO;
use DAO\BreedDAO;
use DAO\PetSizeDAO;

class PetDAO implements IPetDAO
{
    private $petList = array();
    private $connection;
    private $tableName = "Pet";

    public function Add(Pet $pet)
    {
        $this->Insert($pet);
    }

    public function Modify(Pet $pet)
    {
        $this->Update($pet);
    }

    public function Exist($userId, $name)
    {
        $rta = false;
        $this->RetrieveData();

        foreach ($this->petList as $pet) {
            if ($pet->getUser()->getId() == $userId && $pet->getName() == $name) {
                $rta = true;
            }
        }
        return $rta;
    }

    public function GetActivePetsOfUser($userId)
    {
        $query = "SELECT * FROM $this->tableName where id_user = {$userId} AND active = 1;";
        return $this->GetAllQuery($query);
    }

    public function GetPetById($id)
    {
        $query = "SELECT * FROM $this->tableName where id = {$id};";
        return $this->GetResult($query);
    }

    private function GetResult($query)
    {
        try {
            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($query);
            
            $pet = new Pet();
            if (!empty($result)) {
                $pet->setId($result[0]["id"]);
                $pet->setName($result[0]["name"]);
                $pet->setObservation($result[0]["observation"]);
                $pet->setPicture($result[0]["picture"]);
                $pet->setVacunationPlan($result[0]["vacunationPlan"]);
                $pet->setVideo($result[0]["video"]);
                $pet->setActive($result[0]["active"]);

                // Set User
                $userDAO = new UserDAO();
                $user = $userDAO->GetById($result[0]["id_user"]);
                $pet->setUser($user);

                // Set Breed
                $breedDAO = new BreedDAO();
                $breed = $breedDAO->GetById($result[0]["id_breed"]);
                $pet->setBreed($breed);
                // Set petType and petSize

                $petTypeDAO = new PetTypeDAO();
                $petType = $petTypeDAO->GetById($result[0]["id_petType"]);
                $pet->setPetType($petType);

                $petSizeDAO = new PetSizeDAO();
                $petSize = $petSizeDAO->GetById($result[0]["id_petSize"]);
                $pet->setPetSize($petSize);
            }
        } catch (Exception $ex) {
            throw $ex;
        }
        return $pet;
    }

    public function GetAll()
    {
        $this->RetrieveData();
        return $this->petList;
    }

    // Insert a pet in the table
    private function Insert(Pet $pet)
    {
        $query = "INSERT INTO  $this->tableName (id_user,name,id_petType,id_breed,id_petSize,observation,picture,vacunationPlan,video,active) VALUES (:id_user,:name,:id_petType,:id_breed,:id_petSize,:observation,:picture,:vacunationPlan,:video,:active);";
        $this->Setquery($pet, $query);
    }

    private function Setquery(Pet $pet, $query)
    {
        try {
            $parameters["id_user"] = $pet->getUser()->getId();
            $parameters["name"] = $pet->getName();
            $parameters["id_petType"] = $pet->getPetType()->getId();
            $parameters["id_breed"] = $pet->getBreed()->getId();
            $parameters["id_petSize"] = $pet->getPetSize()->getId();
            $parameters["observation"] = $pet->getObservation();
            $parameters["picture"] = $pet->getPicture();
            $parameters["vacunationPlan"] = $pet->getVacunationPlan();
            $parameters["video"] = $pet->getVideo();
            $parameters["active"] = $pet->getActive();

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    // Update a pet in the table
    private function Update(Pet $pet)
    {
        $query = "UPDATE this->tableName SET id_user = :id_user, name = :name, id_petType = :id_petType, id_breed = :id_breed, id_petSize = :id_petSize, observation = :observation, picture = :picture, vacunationPlan = :vacunationPlan, video = :video, active = :active WHERE id = {$pet->getId()};";
        $this->Setquery($pet, $query);
    }

    // Set list pet with info of table
    private function RetrieveData()
    {
        $query = "SELECT * FROM $this->tableName";
        $this->GetAllQuery($query);
    }

    private function GetAllQuery($query)
    {
        $this->petList = array();
        try {
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query);

            $petList = array();
            
            foreach ($resultSet as $value) {
                $pet = new Pet();
                $pet->setId($value["id"]);
                $pet->setName($value["name"]);
                $pet->setObservation($value["observation"]);
                $pet->setPicture($value["picture"]);
                $pet->setVacunationPlan($value["vacunationPlan"]);
                $pet->setVideo($value["video"]);
                $pet->setActive($value["active"]);

                // Set User
                $userDAO = new UserDAO();
                $user = $userDAO->GetById($value["id_user"]);
                $pet->setUser($user);

                // Set Breed
                $breedDAO = new BreedDAO();
                $breed = $breedDAO->GetById($value["id_breed"]);
                $pet->setBreed($breed);
                // Set petType and petSize

                $petTypeDAO = new PetTypeDAO();
                $petType = $petTypeDAO->GetById($value["id_petType"]);
                $pet->setPetType($petType);

                $petSizeDAO = new PetSizeDAO();
                $petSize = $petSizeDAO->GetById($value["id_petSize"]);
                $pet->setPetSize($petSize);

                array_push($petList, $pet);
            }
        } catch (Exception $ex) {
            throw $ex;
        }
        return $petList;
    }
}
