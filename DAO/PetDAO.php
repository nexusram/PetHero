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
    private $petList;
    private $connection;
    private $tableName = "Pet";

    public function Add(Pet $pet)
    {
        $pet->setId($this->GetNextId());
        try {

            $query = "INSERT INTO  $this->tableName (id,user,name,petType,breed,petSize,observation,picture,vacunationPlan,video,active) VALUES (:id,:user,:name,:petType,:breed,:petSize,:observation,:picture,:vacunationPlan,:video,:active);";

            $value["id"] = $pet->getId();
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

    public function Remove($id)
    {
        $this->connection = Connection::GetInstance();
        $aux = "DELETE From $this->tableName WHERE Id = '$id'";
        $connection = $this->connection;
        $connection->Execute($aux);
    }

    public function Modify(Pet $pet)
    {
        $this->connection = Connection::GetInstance();

        $consulta = "UPDATE $this->tableName 
        SET id= $pet->getId(),user= $pet->getUser()->getId(),name= $pet->getName(),petType =$pet->getPetType()->getId(),breed=$pet->getBreed()->getId(),petSize=$pet->getPetSize()->getId(),observation=$pet->getObservation(),picture=$pet->getPicture(),vacunationPlan=$pet->getVacunationPlan(),video=$pet->getVideo(), active=$pet->getActive()
        WHERE id = $pet->getId()";
        $connection = $this->connection;
        $connection->Execute($consulta);
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


    private function RetrieveData()
    {
        $this->petList = array();
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
            return $this->petList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    private function GetNextId()
    {
        $id = 0;

        foreach ($this->petList as $pet) {
            $id = ($pet->getId() > $id) ? $pet->getId() : $id;
        }

        return $id + 1;
    }
}
