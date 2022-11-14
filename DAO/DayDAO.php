<?php

namespace DAO;

use DAO\Connection as Connection;
use \Exception as Exception;
use Models\Day;
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
        $this->Insert($day);
    }
    
    public function Modify(Day $day)
    {
        $this->Update($day);
    }

    public function GetAll()
    {
        $this->RetrieveData();
        return $this->dayList;
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

    // Insert a day in the table
    private function Insert(Day $day) {
        try {
            $query = "INSERT INTO $this->tableName (date, keeper, isAvailable) VALUES (:date, :keeper, :isAvailable);";

            $parameters["date"] = date(FORMAT_DATE, strtotime($day->getDate()));
            $parameters["keeper"] = $day->getKeeper()->getId();
            $parameters["isAvailable"] = $day->getIsAvailable();

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    // Update a day in the table
    private function Update(Day $day) {
        try {
            $query = "UPDATE $this->tableName SET date = :date, keeper = :keeper, isAvailable = :isAvailable  WHERE id={$day->getId()};";

            $parameters["date"] = date("Y-m-d", strtotime($day->getDate()));
            $parameters["keeper"] =  $day->getKeeper()->getId();
            $parameters["isAvailable"] = $day->getIsAvailable();
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    // Set list day with info of table
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
}
