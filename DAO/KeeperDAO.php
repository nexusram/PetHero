<?php

namespace DAO;

use DAO\IViews as IViews;
use DAO\Connection as Connection;
use \Exception as Exception;
use Models\Keeper;

class KeeperDAO
{
    private $keeperList;
    private $connection;
    private $tableName = "keeper";
  
    public function Add(Keeper $keeper)
    {
        $keeper->setScore = null;
        try {
            $query = "INSERT INTO $this->tableName (user,petSize,remuneration,description,score,active) VALUES (:user,:petSize,:remuneration,:description,:score,:active);";
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
        $this->keeperList = array();
        try {

            $query = "SELECT * FROM $this->tableName";

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query);

            foreach ($resultSet as $valuesArray) {
                $keeper = new Keeper();
                $keeper->setId($valuesArray["id"]);
                
                $userDAO = new UserDAO();
                $user = $userDAO->GetById($valuesArray["user"]);
                $keeper->setUser($user);

                $petSizeDAO = new PetSizeDAO();
                $petSize = $petSizeDAO->GetById($valuesArray["petSize"]);
                $keeper->setPetSize($petSize);

                $keeper->setRemuneration($valuesArray["remuneration"]);
                $keeper->setDescription($valuesArray["description"]);
                $keeper->setScore($valuesArray["score"]);
                $keeper->setActive($valuesArray["active"]);
                array_push($this->keeperList, $keeper);
            }

            return $this->keeperList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function Modify(Keeper $keeper)
    {
        try
        {
            $query = "UPDATE ".$this->tableName." SET user = :user, petSize = :petSize, remuneration = :remuneration, description = :description, score = :score, active = :active";

            $parameters["user"] = $keeper->getUser()->getId();
            $parameters["petSize"] = $keeper->getPetSize()->getId();
            $parameters["remuneration"] = $keeper->getRemuneration();
            $parameters["description"] = $keeper->getDescription();
            $parameters["score"] = $keeper->getScore();
            $parameters["active"] = $keeper->getActive();
            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters);

        }
        catch(Exception $ex)
        {
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

    public function GetListByKeeper($keeperId)
    {
        $this->RetrieveData();

        $array = array_filter($this->keeperList, function ($keeper) use ($keeperId) {
            return $keeper->getKeeperId() == $keeperId;
        });
        return $array;
    }

    public function GetActiveListByKeeper($keeperId)
    {
        $this->RetrieveData();

        $array = array_filter($this->keeperList, function ($keeper) use ($keeperId) {
            return ($keeper->getKeeperId() == $keeperId) && ($keeper->getIsAvailable());
        });
        return $array;
    }
    public function GetById($id) {
        $this->RetrieveData();

        $array = array_filter($this->keeperList, function($keeper) use($id) {
            return $keeper->getId() == $id;
        });

        $array = array_values($array);

        return (count($array) > 0) ? $array[0] : null;
    }
    public function GetByUserId($userId) {
        $this->RetrieveData();

        $array = array_filter($this->keeperList, function($keeper) use($userId) {
            return $keeper->getUser()->getId() == $userId;
        });

        $array = array_values($array);

        return (count($array) > 0) ? $array[0] : null;
    }
    public function CheckForSize($size){
        $this->RetrieveData();

        $arrayKeeperSize = array_filter($this->keeperList, function($keeper) use($size){
            return $keeper->getPetSize() == $size;
        });
       return (count($arrayKeeperSize)>0) ? true : false;
    }

    public function GetAllFiltered($pet, $startDate, $endDate){
        $arrayKeeper = array();

        if($this->CheckForSize($pet->getPetSize()))//si el primer filtro devuelve true es para filtrar
        {
            $dayDAO = new DayDAO();
            $days = $dayDAO->RetrieveData();

            $startDate = strtotime($startDate);
            $endDate = strtotime($endDate);

            $rangeArray = array();
            for($i = $startDate; $i <= $endDate; $i+=86400) {
                $date = date("d-m-Y", $i);
                array_push($rangeArray, $date);
            }

            $arrayDay = array();
            foreach($days as $day) {
                if(in_array($day->getDate(), $rangeArray) && $day->getIsAvailable()) {
                    array_push($arrayDay, $day);
                }
            }

            foreach($arrayDay as $day){
                array_push($arrayKeeper, $day->getKeeper());
            }/// Recorro la lista de dias disponibles y agrego los keepers al arrayKeeper, me falta el ultimo filtro
           
            $bookingDAO = new BookingDAO();
            $bookingsAccepted = $bookingDAO->GetAllAcceptedByDate(date("d-m-Y", $startDate), date("d-m-Y", $endDate));

            if(!is_null($bookingsAccepted)){
                 foreach($bookingsAccepted as $booking){
                     if($booking->getBreed() == $pet->getBreed() && 
                     $booking->getBreed()->getPetType() == $pet->getType()){
                         array_push($arrayKeeper, $booking->getKeeper());
                     }///tercer filtro si hay reservas y el tipo de mascota de la reserva es igual al de la mascota recibida por parametro añado el cuidador a la lista.
                 }
            }
           //ultimo filtro, filtrado por tamaño
            $arrayKeeper = array_filter($arrayKeeper, function($keeper) use($pet){
            return $keeper->getPetSize() == $pet->getPetSize();
            });
        } 
       return $arrayKeeper; 
    }

    public function Exist($dayList, $i) {
        $rta = false;
        foreach($dayList as $day) {
            if(strcmp($day->getDate(), $i) == 0 && $day->getIsActive()) {
                $rta = true;
            }
        }

        return $rta;
    }
    
}
