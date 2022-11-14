<?php

namespace DAO;

use DAO\IViews as IViews;
use DAO\Connection as Connection;
use \Exception as Exception;
use Models\Day;
use Models\Keeper;
use DAO\KeeperDAO;

class DayDAO implements IDayDAO
{
    private $dayList = array();
    private $connection;
    private $tableName = "day";
    /*
    public function __construct() {
        $this->DesactiveOldDays();
    }
  */
    public function Add(Day $day)
    {

        try {
            $query = "INSERT INTO $this->tableName (date,keeper,isAvailable) VALUES (:date,:keeper,:isAvailable);";
            $valuesArray["keeper"] = $day->getKeeper()->getId();
            $valuesArray["date"] = date("Y-m-d", strtotime($day->getDate()));
            $valuesArray["isAvailable"] = $day->getIsAvailable();
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $valuesArray);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function GetAll()
    {
        $this->RetrieveData();
        return $this->dayList;
    }

    private function RetrieveData()
    {

        try {

            $query = "SELECT * FROM $this->tableName";

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query);

            foreach ($resultSet as $valuesArray) {
                $day = new Day();

                $day->setId($valuesArray["id"]);
                $day->setDate($valuesArray["date"]);
                $day->setIsAvailable($valuesArray["isAvailable"]);

                $keeperDAO = new KeeperDAO();
                $keeper = $keeperDAO->GetById($valuesArray["keeper"]);
                $day->setKeeper($keeper);

                array_push($this->dayList, $day);
            }
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function Modify(Day $day)
    {
        try {
            $query = "UPDATE $this->tableName SET date = :date, keeper = :keeper, isAvailable = :isAvailable  WHERE id={$day->getId()}";

            $parameters["date"] = date("Y-m-d", strtotime($day->getDate()));
            $parameters["keeper"] =  $day->getKeeper()->getId();
            $parameters["isAvailable"] = $day->getIsAvailable();
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
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

    private function GetNextId()
    {
        $id = 0;

        foreach ($this->dayList as $day) {
            $id = ($day->getId() > $id) ? $day->getId() : $id;
        }

        return $id + 1;
    }
    public function GetById($id)
    {
        $this->RetrieveData();

        $array = array_filter($this->dayList, function ($day) use ($id) {
            return $day->getId() == $id;
        });

        $array = array_values($array);

        return (count($array) > 0) ? $array[0] : null;
    }
    public function GetListByKeeper($keeperId)
    {
        $this->RetrieveData();

        $array = array_filter($this->dayList, function ($day) use ($keeperId) {
            return $day->getKeeper()->getId() == $keeperId;
        });
        return $array;
    }

    public function GetActiveListByKeeper($keeperId)
    {
        $this->RetrieveData();
        $array = array_filter($this->dayList, function ($day) use ($keeperId) {
            return ($day->getKeeper()->getId() == $keeperId) && ($day->getIsAvailable());
        });
        return $array;
    }

    public function GetInactiveListByKeeper($keeperId)
    {
        $this->RetrieveData();

        $array = array_filter($this->dayList, function ($day) use ($keeperId) {
            return ($day->getKeeper()->getId() == $keeperId) && (!$day->getIsAvailable());
        });
        return $array;
    }
    /*
    private function DesactiveOldDays() {
        $this->RetrieveData();

        $today = strtotime(date("d-m-Y", time()));

        foreach($this->dayList as $day) {
            $date = strtotime($day->getDate());
            if($today > $date) {
                $day->setIsAvailable(false);
                $this->Modify($day);
            }
        }

        $this->SaveData();
    }
*/
}
