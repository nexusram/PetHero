<?php

namespace DAO;

use DAO\IViews as IViews;
use DAO\Connection as Connection;
use DateTime;
use \Exception as Exception;
use Models\Keeper;

class KeeperDAO implements IKeeperDAO
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

            $valuesArray = $this->connection->Execute($query);

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
        } catch (Exception $ex) {
            throw $ex;
        }
        return $keeper;
    }
    public function GetAll()
    {
        $this->keeperList=array();
        $this->RetrieveData();
        return $this->keeperList;
    }

    public function GetListByKeeper($keeperId)
    {
        $this->keeperList=array();
        $query = "SELECT * FROM $this->tableName where id = {$keeperId};";
        $this->GetAllQuery($query);
        return $this->keeperList;
    }

    public function GetActiveListByKeeper($keeperId)
    {
        $this->RetrieveData();

        $array = array_filter($this->keeperList, function ($keeper) use ($keeperId) {
            return ($keeper->getKeeperId() == $keeperId) && ($keeper->getIsAvailable());
        });
        return $array;
    }

    public function GetByUserId($userId)
    {
        $this->RetrieveData();

        $array = array_filter($this->keeperList, function ($keeper) use ($userId) {
            return $keeper->getUser()->getId() == $userId;
        });

        $array = array_values($array);

        return (count($array) > 0) ? $array[0] : null;
    }

    public function CheckForSize($size)
    {
        $this->RetrieveData();

        $arrayKeeperSize = array_filter($this->keeperList, function ($keeper) use ($size) {
            return $keeper->getPetSize() == $size;
        });
        return (count($arrayKeeperSize) > 0) ? true : false;
    }

    public function GetAllFiltered($pet, $startDate, $endDate)
    {

        $query = "SELECT k.id, k.id_user, k.id_petSize, k.remuneration, k.description, k.score, k.active
        FROM $this->tableName k
        JOIN day d ON d.id_keeper = k.id
        WHERE k.id_petSize = {$pet->getPetSize()->getId()}
        AND d.date BETWEEN '{$startDate}' AND '{$endDate}'
        AND d.isAvailable = 1
        AND k.id_user <> {$_SESSION["loggedUser"]->getId()}";

        $keeperList = $this->GetAllQuery($query);

        $diff = (new DateTime($startDate))->diff(new DateTime($endDate));

        var_dump($keeperList);
        die;

        return $keeperList;
    }

    public function Exist($dayList, $i)
    {
        $rta = false;
        foreach ($dayList as $day) {
            if (strcmp($day->getDate(), $i) == 0 && $day->getIsActive()) {
                $rta = true;
            }
        }

        return $rta;
    }

    // Insert a keeper in the table
    private function Insert(Keeper $keeper)
    {
        $query = "INSERT INTO $this->tableName (id_user, id_petSize, remuneration, description, score, active) VALUES (:id_user, :id_petSize, :remuneration, :description, :score, :active);";
        $this->SetAllQuery($keeper, $query);
    }

    private function SetAllQuery(Keeper $keeper, $query)
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

    // Update a keeper in the table
    private function Update(Keeper $keeper)
    {
        $query = "UPDATE $this->tableName SET id_user = :id_user, id_petSize = :id_petSize, remuneration = :remuneration, description = :description, score = :score, active = :active";
        $this->SetAllQuery($keeper, $query);
    }

    // Set list keeper with info of table
    private function RetrieveData()
    {
        $this->keeperList = array();
        $query = "SELECT * FROM $this->tableName";
        $this->GetAllQuery($query);
    }

    private function GetAllQuery($query)
    {
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
