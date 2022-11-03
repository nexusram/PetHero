<?php

namespace DAO;

use DAO\IViews as IViews;
use DAO\Connection as Connection;
use \Exception as Exception;
use Models\Keeper;

class BddKeeper
{
    private $keeperList = array();
    private $connection;
    private $tableName = "keeper";
    /*

                $value["id"] = $keeper->getId();
                $value["user"] = $keeper->getUser()->getId();
                $value["petSize"] = $keeper->getPetSize()->getId();
                $value["remuneration"] = $keeper->getRemuneration();
                $value["description"] = $keeper->getDescription();
                $value["score"] = $keeper->getScore();
                $value["active"] = $keeper->getActive();

*/

    public function Add(Keeper $keeper)
    {
        $keeper->setId($this->GetNextId()); //seteo el id autoincremental
        try {

            $query = "INSERT INTO . $this->tableName . (id,user,petSize,remuneration,description,score,active) VALUES (:id,:user,:petSize,:remuneration,:description,:description,:score,:active);";
            $valuesArray["id"] = $keeper->getId();
            $valuesArray["user"] = $keeper->getUser()->getId();
            $valuesArray["petSize"] = $keeper->getPetSize()->getId();
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

    public function RetrieveData()
    {
        try {
            $dayList = array();

            $query = "SELECT * FROM " . $this->tableName;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query);

            foreach ($resultSet as $valuesArray) {
                $keeper = new Keeper();
                $keeper->setId($valuesArray["id"]);
                $keeper->setUser($valuesArray["user"]);
                $keeper->setPetSize($valuesArray["petSize"]);
                $keeper->setRemuneration($valuesArray["remuneration"]);
                $keeper->setDescription($valuesArray["description"]);
                $keeper->setScore($valuesArray["score"]);
                $keeper->setActive($valuesArray["active"]);
                array_push($keeperList, $keeper);
            }

            return $keeperList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function Modify(Keeper $keeper)
    {
        $this->connection = Connection::GetInstance();
        $consulta = "UPDATE . $this->tableName .
        SET id= $keeper->getId(),user= $keeper->getUser()->getId(),petSize= $keeper->getPetSize()->getId(),remuneration=$keeper->getRemuneration(),description=$keeper->getDescription(),score=$keeper->getScore(),active=$keeper->getActive()
        . WHERE id = $keeper->getId()";
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
        foreach ($this->keeperList as $keeper) {
            $id = ($keeper->getId() > $id) ? $keeper->getId() : $id;
        }

        return $id + 1;
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
