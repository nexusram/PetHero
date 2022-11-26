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
        $this->RetrieveData();
        return $this->keeperList;
    }

    public function GetListByKeeper($keeperId)
    {
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
        //$this->keeperList = $this->GetAllQuery("SELECT  * FROM $this->tableName");

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
        $this->keeperList = $this->FilterKeeper($pet, $startDate, $endDate);

        return $this->keeperList;
    }

    private function FilterKeeper($pet, $startDate, $endDate)
    {

        $keeperList = $this->FilterForDates($pet, $startDate, $endDate, 1);
        if(empty($keeperList)){
            $keeperList = $this->FilterForDates($pet, $startDate, $endDate, 0);
        }

        $bookingDAO = new BookingDAO();
        $keeperFilterList = array();

        if (!empty($keeperList)) {
            foreach ($keeperList as $keeper) {
                $bookingList = array();
                $bookingList = $bookingDAO->GetListByKeeperIdAndDates($keeper->getId(), $startDate, $endDate);

                if (!empty($bookingList)) {
                    foreach ($bookingList as $booking) {
                        if ($booking->getPet()->getBreed()->getId() == $pet->getBreed()->getId() && $booking->getPet()->getId() != $pet->getId()) {
                            array_push($keeperFilterList, $keeper);
                        }
                    }
                } else {
                    array_push($keeperFilterList, $keeper);
                }
            }
        }
        return $keeperFilterList;
    }

    private function FilterForDates($pet, $startDate, $endDate, $isAvailable)
    {
        $keeperList = array();
        $diff = (new DateTime($startDate))->diff(new DateTime($endDate));
        $daysOfQuantity = $diff->format("%d") + 1;

        try {
            $query = "CALL `sp_filter_keeper`(?, ? , ?, ?, ?)";

            $parameters["petSize"] = $pet->getPetSize()->getId();
            $parameters["startDate"] = $startDate;
            $parameters["endDate"] = $endDate;
            $parameters["id_user"] = $_SESSION["loggedUser"]->getId();
            $parameters["isAvailable"] = $isAvailable;

            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);

            foreach ($resultSet as $value) {
                if ($value['quantity'] == $daysOfQuantity) {
                    $keeper = $this->SetKeeper($value["id"], $value["id_user"], $value["id_petSize"], $value["remuneration"], $value["description"], $value["score"], $value["active"]);
                    array_push($keeperList, $keeper);
                }
            }
        } catch (Exception $ex) {
            throw $ex;
        }
        return $keeperList;
    }

   

    private function SetKeeper($id, $id_user, $id_petSize, $remuneration, $description, $score, $active)
    {
        $keeper = new Keeper();
        $keeper->setId($id);

        $userDAO = new UserDAO();
        $user = $userDAO->GetById($id_user);

        $keeper->setUser($user);

        $petSizeDAO = new PetSizeDAO();
        $petSize = $petSizeDAO->GetById($id_petSize);
        $keeper->setPetSize($petSize);

        $keeper->setRemuneration($remuneration);
        $keeper->setDescription($description);
        $keeper->setScore($score);
        $keeper->setActive($active);

        return $keeper;
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
        $this->SetQuery($keeper, $query);
    }

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

    // Update a keeper in the table
    private function Update(Keeper $keeper)
    {
        $query = "UPDATE $this->tableName SET id_user = :id_user, id_petSize = :id_petSize, remuneration = :remuneration, description = :description, score = :score, active = :active WHERE id = {$keeper->getId()}";
        $this->SetQuery($keeper, $query);
    }

    // Set list keeper with info of table
    private function RetrieveData()
    {
        $query = "SELECT * FROM $this->tableName";
        $this->keeperList = $this->GetAllQuery($query);
    }

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
