<?php

namespace DAO;

use DAO\IViews as IViews;
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
        $this->RetrieveData();

        $array = array_filter($this->petList, function ($pet) use ($userId) {
            return ($pet->getUser()->getId() == $userId && $pet->getActive() == 1) ? $pet : null;
        });

        return $array;
    }

    public function GetPetById($id)
    {
        $this->RetrieveData();

        $array = array_filter($this->petList, function ($pet) use ($id) {
            return $pet->getId() == $id;
        });

        $array = array_values($array);

        return (count($array) > 0) ? $array[0] : null;
    }

    public function GetAll()
    {
        $this->RetrieveData();
        return $this->RetrieveData();
    }

    // Insert a pet in the table
    private function Insert(Pet $pet) {
        try {

            $query = "INSERT INTO  $this->tableName (user,name,petType,breed,petSize,observation,picture,vacunationPlan,video,active) VALUES (:user,:name,:petType,:breed,:petSize,:observation,:picture,:vacunationPlan,:video,:active);";

            $value["user"] = $pet->getUser()->getId();
            $value["name"] = $pet->getName();
            $value["petType"] = $pet->getPetType()->getId();
            $value["breed"] = $pet->getBreed()->getId();
            $value["petSize"] = $pet->getPetSize()->getId();
            $value["observation"] = $pet->getObservation();
            $value["picture"] = $pet->getPicture();
            $value["vacunationPlan"] = $pet->getVacunationPlan();
            $value["video"] = $pet->getVideo();
            $value["active"] = $pet->getActive();

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $value);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    // Update a pet in the table
    private function Update(Pet $pet) {
        try {

            $query = "UPDATE this->tableName SET user = :user, name = :name, petType = :petType, breed = :breed, petSize = :petSize, observation = :observation, picture = :picture, vacunationPlan = :vacunationPlan, video = :video, active = :active WHERE id = {$pet->getId()};";
            
            $parameters["user"] = $pet->getUser()->getId();
            $parameters["name"] = $pet->getName();
            $parameters["petType"] = $pet->getPetType()->getId();
            $parameters["breed"] = $pet->getBreed()->getId();
            $parameters["petSize"] = $pet->getPetSize()->getId();
            $parameters["observation"] = $pet->getObservation();
            $parameters["picture"] = $pet->getPicture();
            $parameters["vacunationPlan"] = $pet->getVacunationPlan();
            $parameters["video"] = $pet->getVideo();
            $parameters["active"] = $pet->getActive();

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch(Exception $ex) {
            throw $ex;
        }
    }

    // Set list pet with info of table
    private function RetrieveData()
    {
        try {

            $query = "SELECT * FROM $this->tableName";

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query);

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
                $user = $userDAO->GetById($value["user"]);
                $pet->setUser($user);

                // Set Breed
                $breedDAO = new BreedDAO();
                $breed = $breedDAO->GetById($value["breed"]);
                $pet->setBreed($breed);
                // Set petType and petSize

                $petTypeDAO = new PetTypeDAO();
                $petType = $petTypeDAO->GetById($value["petType"]);
                $pet->setPetType($petType);

                $petSizeDAO = new PetSizeDAO();
                $petSize = $petSizeDAO->GetById($value["petSize"]);
                $pet->setPetSize($petSize);

                array_push($this->petList, $pet);
            }
           
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}
