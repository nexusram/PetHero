<?php

namespace DAO;

use DAO\Connection as Connection;
use \Exception as Exception;
use Models\Coupon;
use Models\Booking;
use DateTime;

class BookingDAO implements IBookingDAO
{
    private $bookingList = array();
    private $connection;
    private $tableName = "booking";
    //add booking
    public function Add(Booking $booking)
    {
        $this->Insert($booking);
    }
    //modify booking
    public function Modify(Booking $booking)
    {
        $this->Update($booking);
    }
    //return all booking
    public function GetAll()
    {
        $this->RetrieveData();

        return $this->bookingList;
    }
    // Return Booking for the Id user
    public function GetById($id)
    {
        $query = "SELECT * FROM $this->tableName WHERE id = {$id}";

        return $this->GetResult($query);
    }

    public function GetBykeeper($startDate, $endDate, $id_keeper, $id_user)
    {
        $query = "SELECT * from $this->tableName where {$startDate}<=startDate and {$endDate}<= endDate and {$id_keeper}= id_keeper and {$id_user} = id_owner;";
        $booking = $this->GetResult($query);
        return $booking;
    }

    // Return list of Booking for the startDate and endDate
    // It filters by the start date and end date and returns the list of bookin, if it doesn't find it returns null
    public function GetAllAcceptedByDate($startDate, $endDate)
    {
        $query = "SELECT * from $this->tableName where state= true and {$startDate}>=startDate and {$endDate}<= endDate";
        $this->GetAllQuery($query);
        return $this->bookingList;
    }

    // Return Booking for the Id user
    public function GetActiveBookingOfUser($userId)
    {
        $query = "SELECT * FROM $this->tableName WHERE id_owner = {$userId} and state = true";

        return $this->GetResult($query);
    }
    // Return list of Booking for the Id user
    public function GetAllByUserId($userId)
    {
        $query = "SELECT * FROM $this->tableName WHERE id_owner = {$userId}";

        $this->GetAllQuery($query);

        return $this->bookingList;
    }
    // Return list of Booking for the Id Keeper that are valid
    public function GetListValidade($keeperId)
    {
        $query = "SELECT * FROM $this->tableName WHERE id_keeper = {$keeperId} AND validate = 1";

        $this->GetAllQuery($query);

        return $this->bookingList;
    }

    // Return list of Booking for the Id Keeper
    public function GetListByKeeperId($keeperId)
    {
        $query = "SELECT * FROM $this->tableName WHERE id_keeper = {$keeperId}";

        $this->GetAllQuery($query);

        return $this->bookingList;
    }

    //return if exist booking
    public function Exist($startDate, $endDate, $id_user, $id_keeper, $id_pet)
    {
        $rta = false;
        $query = "SELECT * FROM $this->tableName WHERE startDate >='{$startDate}' AND endDate <= '{$endDate}' AND id_owner ={$id_user} AND id_keeper = {$id_keeper} AND id_pet = {$id_pet}  AND (state = 1 OR state = 0);";
        $result =  $this->GetResult($query);

        if (!empty($result)) {
            $rta = true;
            
        }
       
        return $rta;
    }

    // Return list of Booking for the Id Keeper and State
    public function GetListByKeeperIdAndState($keeperId, $state)
    {
        $query = "SELECT * FROM $this->tableName WHERE id_keeper = {$keeperId} AND state = {$state}";

        $this->GetAllQuery($query);

        return $this->bookingList;
    }

    // Insert a boooking of type Booking in the table
    private function Insert(Booking $booking)
    {
        $query = "INSERT INTO $this->tableName (startDate,endDate,state,validate,id_owner,id_keeper,id_pet, total) VALUES (:startDate,:endDate,:state,:validate,:id_owner,:id_keeper,:id_pet,:total);";

        $this->SetQuery($query, $booking);
    }

    // update a boooking of type Booking in the table
    private function Update(Booking $booking)
    {
        $query = "UPDATE $this->tableName SET startDate = :startDate, endDate = :endDate, state = :state, validate = :validate, id_owner = :id_owner, id_keeper = :id_keeper, id_pet = :id_pet, total = :total WHERE id = {$booking->getId()};";

        $this->SetQuery($query, $booking);
    }

    // Set list boookig with info of table
    private function RetrieveData()
    {
        $query = "SELECT * FROM $this->tableName";
        $this->GetAllQuery($query);
    }

    //return Result of Query //
    private function GetResult($query)
    {
        try {

            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($query);

            $booking = null;

            if (!empty($result)) {
                $booking = new Booking();

                $booking->setId($result[0]["id"]);
                $booking->setStartDate($result[0]["startDate"]);
                $booking->setEndDate($result[0]["endDate"]);
                $booking->setState($result[0]["state"]);
                $booking->setValidate($result[0]["validate"]);
                $booking->setTotal($result[0]["total"]);


                $userDAO = new UserDAO();
                $user = $userDAO->GetById($result[0]["id_owner"]);
                $booking->setOwner($user);

                $keeperDAO = new KeeperDAO();
                $keeper = $keeperDAO->GetById($result[0]["id_keeper"]);
                $booking->setKeeper($keeper);

                $petDAO = new PetDAO();
                $pet = $petDAO->GetPetById($result[0]["id_pet"]);
                $booking->setPet($pet);
            }
        } catch (Exception $ex) {
            throw $ex;
        }
        return $booking;
    }
    //Insert a booking of type Booking in the Query//
    private function SetQuery($query, Booking $booking)
    {
        try {

            $valuesArray["startDate"] = $booking->getStartDate();
            $valuesArray["endDate"] = $booking->getEndDate();
            $valuesArray["state"] = $booking->getState();
            $valuesArray["validate"] = $booking->getValidate();
            $valuesArray["id_owner"] = $booking->getOwner()->getId();
            $valuesArray["id_keeper"] = $booking->getKeeper()->getId();
            $valuesArray["id_pet"] = $booking->getPet()->getId();
            $valuesArray["total"] = $booking->getTotal();

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $valuesArray);
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    //return list keeper for keeper Id, start date and end date
    public function GetListByKeeperIdAndDates($keeperId, $startDate, $endDate)
    {

        $query = "SELECT b.id, b.startDate, b.endDate, b.state, b.validate, b.id_owner, b.id_keeper, b.id_pet, b.total
        FROM $this->tableName b
        JOIN pet p on p.id = b.id_pet
        WHERE b.startDate = '{$startDate}'
        AND b.endDate = '{$endDate}'
        AND b.id_keeper = {$keeperId}";
        $this->GetAllQuery($query);
        return $this->bookingList;
    }
    //return all Result of Query //
    private function GetAllQuery($query)
    {

        $this->bookingList = array();
        try {

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query);

            if (!empty($resultSet)) {
                foreach ($resultSet as $valuesArray) {
                    $booking = new Booking();

                    $booking->setId($valuesArray["id"]);
                    $booking->setStartDate($valuesArray["startDate"]);
                    $booking->setEndDate($valuesArray["endDate"]);
                    $booking->setState($valuesArray["state"]);
                    $booking->setValidate($valuesArray["validate"]);
                    $booking->setTotal($valuesArray["total"]);

                    $userDAO = new UserDAO();
                    $user = $userDAO->GetById($valuesArray["id_owner"]);
                    $booking->setOwner($user);
                    $keeperDAO = new KeeperDAO();
                    $keeper = $keeperDAO->GetById($valuesArray["id_keeper"]);
                    $booking->setKeeper($keeper);

                    $petDAO = new PetDAO();
                    $pet = $petDAO->GetPetById($valuesArray["id_pet"]);
                    $booking->setPet($pet);

                    array_push($this->bookingList, $booking);
                }
            }
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}
