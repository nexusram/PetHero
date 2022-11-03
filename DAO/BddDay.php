<?php

namespace DAO;

use DAO\IViews as IViews;
use DAO\Connection as Connection;
use \Exception as Exception;
use Models\Day;
use Models\Keeper;
use DAO\KeeperDAO;

class BddDay
{
    private $dayList = array();
    private $connection;
    private $tableName = "Booking";


    public function Add(Day $day)
    {
        $day->setId($this->GetNextId()); //seteo el id autoincremental
        try {

            $query = "INSERT INTO . $this->tableName . (id,date,keeper,isAvailable) VALUES (:Id,:date,:keeper,:isAvailable);";

            $valuesArray["id"] = $day->getId();
            $valuesArray["keeper"] = $day->getKeeper()->getUser->getId();
            $valuesArray["date"] = $day->getDate();
            $valuesArray["isAvailable"] = $day->getIsAvailable();

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $valuesArray);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function RetrieveData()
    {
        try {
            $dayList = array();

            $query = "SELECT * FROM " . $this->tableName;

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

                array_push($dayList, $day);
            }

            return $dayList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function Modify(Day $day)
    {
        $this->connection = Connection::GetInstance();

        $consulta = "UPDATE . $this->tableName .
        SET id= $day->getId(),date= $day->getDate(),keeper= $day->getKeeper()->getUser->getId(),isAvailable=$day->getIsAvailable()
        . WHERE id = $day->getId()";
        $connection = $this->connection;
        $connection->Execute($consulta);
    }

    public function Remove($id)
    {
        $this->connection = Connection::GetInstance();
        $aux = "DELETE From . $this->tableName . WHERE Id = '$id'";
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
        //$this->RetrieveData();

        $array = array_filter($this->dayList, function ($day) use ($id) {
            return $day->getId() == $id;
        });

        $array = array_values($array);

        return (count($array) > 0) ? $array[0] : null;
    }
    public function GetListByKeeper($keeperId)
    {
        //$this->RetrieveData();

        $array = array_filter($this->dayList, function ($day) use ($keeperId) {
            return $day->getKeeperId() == $keeperId;
        });
        return $array;
    }

    public function GetActiveListByKeeper($keeperId)
    {
        //$this->RetrieveData();

        $array = array_filter($this->dayList, function ($day) use ($keeperId) {
            return ($day->getKeeperId() == $keeperId) && ($day->getIsAvailable());
        });
        return $array;
    }
}
