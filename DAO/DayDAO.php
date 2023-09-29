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

    //add day
    public function Add(Day $day)
    {
        $this->Insert($day);
    }

    //modify day
    public function Modify(Day $day)
    {
        $this->Update($day);
    }

    //return all day list
    public function GetAll()
    {
        $this->RetrieveData();
        return $this->dayList;
    }

    //return day for id
    public function GetById($id)
    {
        $query = "SELECT * FROM day where id={$id}";
        return $this->GetQuery($query);
    }

    //return day list for keeper id
    public function GetListByKeeper($keeperId)
    {
        $query = "SELECT * FROM day where id_keeper={$keeperId}";
        $this->GetAllQuery($query);
        return $this->dayList;
    }

    //return day list for keeper day and active
    public function GetActiveListByKeeper($keeperId)
    {
        $query = "SELECT * FROM day where id_keeper={$keeperId} and isAvailable=1";
        $this->GetAllQuery($query);
        return $this->dayList;
    }

    //return day list for keeper day and inactive
    public function GetInactiveListByKeeper($keeperId)
    {
        $query = "SELECT * FROM day where id_keeper={$keeperId} and isAvailable=0";
        $this->GetAllQuery($query);
        return $this->dayList;
    }

    public function GetCountDayForDate($startDate,$endDate,$keeperId,$isAvailable)
    {
        $result = 0;
        try{
        $query = "SELECT COUNT(*) FROM $this->tableName WHERE date BETWEEN '{$startDate}' AND '{$endDate}' AND id_keeper = {$keeperId} AND isAvailable = {$isAvailable};";
        $this->connection = Connection::GetInstance();
        $result = $this->connection->Execute($query);
    } catch (Exception $ex) {
        throw $ex;
    }
        return $result;
    }

    //update the days to invalid
    public function getKeeperDay($startDate, $endDate, $keeperId, $isAvailable)
    {
        $query = "SELECT * FROM $this->tableName 
        WHERE date BETWEEN '{$startDate}' AND '{$endDate}' AND id_keeper = {$keeperId} AND isAvailable = {$isAvailable}";
        $this->GetAllQuery($query);
        return $this->dayList;
    }

    public function SetNoAvailable($startDate, $endDate, $keeperId)
    {
        $query = "SELECT * FROM $this->tableName 
        WHERE date BETWEEN '{$startDate}' AND '{$endDate}' AND id_keeper = {$keeperId}";
        $this->GetAllQuery($query);

        foreach ($this->dayList as $day) {
            $day->setIsAvailable(0);
            $this->Update($day);
        }
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

    // Insert a day 
    private function Insert(Day $day)
    {
        $query = "INSERT INTO $this->tableName (date, id_keeper, isAvailable) VALUES (:date, :id_keeper, :isAvailable);";
        $this->SetQuery($day, $query);
    }

    // Update a day 
    private function Update(Day $day)
    {
        $query = "UPDATE $this->tableName SET date = :date, id_keeper = :id_keeper, isAvailable = :isAvailable  WHERE id={$day->getId()};";
        $this->SetQuery($day, $query);
    }

    // Set list day with info of table
    private function RetrieveData()
    {
        $query = "SELECT * FROM $this->tableName";
        $this->GetAllQuery($query);
    }

    /*return all Result of Query */
    private function GetAllQuery($query)
    {
        $this->dayList = array();
        try {
            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query);

            foreach ($resultSet as $valuesArray) {
                $day = new Day();

                $day->setId($valuesArray["id"]);
                $day->setDate($valuesArray["date"]);
                $day->setIsAvailable($valuesArray["isAvailable"]);

                $keeperDAO = new KeeperDAO();
                $keeper = $keeperDAO->GetById($valuesArray["id_keeper"]);
                $day->setKeeper($keeper);

                array_push($this->dayList, $day);
            }
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    //Insert a day in the Query//
    private function SetQuery($day, $query)
    {
        try {

            $parameters["date"] = date(FORMAT_DATE, strtotime($day->getDate()));
            $parameters["id_keeper"] =  $day->getKeeper()->getId();
            $parameters["isAvailable"] = $day->getIsAvailable();

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /*return Result of Query */
    private function GetQuery($query)
    {
        try {
            $this->connection = Connection::GetInstance();
            $valuesArray = $this->connection->Execute($query);
            $day = null;
            if (!empty($valuesArray)) {
                $day = new Day();
                $day->setId($valuesArray[0]["id"]);
                $day->setDate($valuesArray[0]["date"]);
                $day->setIsAvailable($valuesArray[0]["isAvailable"]);

                $keeperDAO = new KeeperDAO();
                $keeper = $keeperDAO->GetById($valuesArray[0]["id_keeper"]);
                $day->setKeeper($keeper);
            }
        } catch (Exception $ex) {
            throw $ex;
        }
        return $day;
    }
}
