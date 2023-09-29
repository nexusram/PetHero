<?php

namespace DAO;

use DAO\IViews as IViews;
use DAO\Connection as Connection;
use DateTime;
use \Exception as Exception;
use Models\Keeper;

class KeeperDAO
{
    private $keeperList = array();
    private $connection;
    private $tableName = "keeper";


    public function Add(Keeper $keeper)
    {
        $keeper->setScore(0);
        $this->Insert($keeper);
    }


    public function Modify(Keeper $keeper)
    {
        $this->Update($keeper);
    }


    public function GetById($id)
    {
        $query = "SELECT * FROM $this->tableName where id = {$id};";
        return $this->GetQuery($query);
    }


    private function GetQuery($query)
    {
        try {
            $this->connection = Connection::GetInstance();
            $keeper = null;
            $valuesArray = $this->connection->Execute($query);
            if (!empty($valuesArray)) {
                $keeper = new Keeper();
                $keeper->setId($valuesArray[0]["id"]);

                $userDAO = new UserDAO();
                $user = $userDAO->GetById($valuesArray[0]["id_user"]);

                $keeper->setUser($user);

                $petSizeDAO = new PetSizeDAO();
                $petSize = $petSizeDAO->GetById($valuesArray[0]["id_petSize"]);
                $keeper->setPetSize($petSize);

                $keeper->setRemuneration($valuesArray[0]["remuneration"]);
                $keeper->setDescription($valuesArray[0]["description"]);
                $keeper->setScore($valuesArray[0]["score"]);
                $keeper->setActive($valuesArray[0]["active"]);
            }
        } catch (Exception $ex) {
            throw $ex;
        }

        return $keeper;
    }


    public function GetAll()
    {
        $this->RetrieveData();
        return $this->keeperList;
    }


    public function GetListByKeeper($keeperId)
    {
        $query = "SELECT * FROM $this->tableName where id = {$keeperId};";
        return $this->GetQuery($query);
    }
   public function GetByPetSize($petSizeId)
   {
    $query = "SELECT * FROM $this->tableName where id_petSize = {$petSizeId};";
    return $this->GetAllQuery($query);
   }

    public function GetByUserId($userId)
    {
        $query = "SELECT * FROM $this->tableName where id_user = {$userId};";
        return $this->GetQuery($query);
    }

    // Insert a keeper
    private function Insert(Keeper $keeper)
    {
        $query = "INSERT INTO $this->tableName (id_user, id_petSize, remuneration, description, score, active) VALUES (:id_user, :id_petSize, :remuneration, :description, :score, :active);";
        $this->SetQuery($keeper, $query);
    }

    //Insert a keeper in the Query//
    private function SetQuery(Keeper $keeper, $query)
    {
        try {
            $valuesArray["id_user"] = $keeper->getUser()->getId();
            $valuesArray["id_petSize"] = $keeper->getPetSize()->getId();
            $valuesArray["remuneration"] = $keeper->getRemuneration();
            $valuesArray["description"] = $keeper->getDescription();
            $valuesArray["score"] = $keeper->getScore();
            $valuesArray["active"] = $keeper->getActive();

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $valuesArray);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    // Update a keeper 
    private function Update(Keeper $keeper)
    {
        $query = "UPDATE $this->tableName SET id_user = :id_user, id_petSize = :id_petSize, remuneration = :remuneration, description = :description, score = :score, active = :active WHERE id = {$keeper->getId()}";
        $this->SetQuery($keeper, $query);
    }

    //retrun all keeper
    private function RetrieveData()
    {
        $query = "SELECT * FROM $this->tableName";
        $this->keeperList = $this->GetAllQuery($query);
    }

    /*return all Result of Query */
    private function GetAllQuery($query)
    {
        $this->keeperList = array();
        try {
            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query);

            $keeperList = array();

            foreach ($resultSet as $valuesArray) {
                $keeper = new Keeper();
                $keeper->setId($valuesArray["id"]);

                $userDAO = new UserDAO();
                $user = $userDAO->GetById($valuesArray["id_user"]);

                $keeper->setUser($user);

                $petSizeDAO = new PetSizeDAO();
                $petSize = $petSizeDAO->GetById($valuesArray["id_petSize"]);
                $keeper->setPetSize($petSize);

                $keeper->setRemuneration($valuesArray["remuneration"]);
                $keeper->setDescription($valuesArray["description"]);
                $keeper->setScore($valuesArray["score"]);
                $keeper->setActive($valuesArray["active"]);

                array_push($keeperList, $keeper);
            }
        } catch (Exception $ex) {
            throw $ex;
        }
        return $keeperList;
    }
}
