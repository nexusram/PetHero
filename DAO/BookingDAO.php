<?php

namespace DAO;

use DAO\IViews as IViews;
use DAO\Connection as Connection;
use \Exception as Exception;
use Models\Coupon;
use Models\Booking;
class BookingDAO implements IBookingDAO
{
    private $bookingList;
    private $connection;
    private $tableName = "Booking";


    public function Add(Booking $booking)
    {
        $booking->setId($this->GetNextId()); //seteo el id autoincremental
        $booking->setState(true); //seteo que siempre cuando se añada quede activa.
        try {


            $query = "INSERT INTO $this->tableName (id,startDate,endDate,state,validate,total,owner,keeper,pet,coupon) VALUES (:'Id',:'startDate',:'endDate',:'state',:'validate',:'total',:'owner',:'keeper',:'pet',:'coupon');";

            $valuesArray["id"] = $booking->getId();
            $valuesArray["startDate"] = $booking->getStartDate();
            $valuesArray["endDate"] = $booking->getEndDate();
            $valuesArray["state"] = $booking->getState();
            $valuesArray["validate"] = $booking->getValidate();
            $valuesArray["total"] = $booking->getTotal();
            $valuesArray["owner"] = $booking->getOwner()->getId();
            $valuesArray["keeper"] = $booking->getKeeper()->getId();
            $valuesArray["pet"] = $booking->getPet()->getId();
            $valuesArray["coupon"] = $booking->getCoupon()->getId();
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $valuesArray);
        } catch (Exception $ex) {
            throw $ex;
        }
    }
public function GetAll()
{
    $this->RetrieveData();
    return $this->bookingList;
}

    private function RetrieveData()
    {
        $this->bookingList = array();
        try {

            $query = "SELECT * FROM " . $this->tableName;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query);

            foreach ($resultSet as $valuesArray) {
                $booking = new Booking();

                $booking->setId($valuesArray["id"]);
                $booking->setStartDate($valuesArray["startDate"]);
                $booking->setEndDate($valuesArray["endDate"]);
                $booking->setState($valuesArray["state"]);
                $booking->setValidate($valuesArray["validate"]);
                $booking->setTotal($valuesArray["total"]);

                $userDAO = new UserDAO();
                $user = $userDAO->GetById($valuesArray["owner"]);
                $booking->setOwner($user);
                $keeperDAO = new KeeperDAO();
                $keeper = $keeperDAO->GetById($valuesArray["keeper"]);
                $booking->setKeeper($keeper);

                $petDAO = new PetDAO();
                $pet = $petDAO->GetPetById($valuesArray["pet"]);
                $booking->setPet($pet);

                //$couponDAO = new CouponDAO();
                    //$coupon = CouponDAO->GetById($value["coupon"]);
                $coupon = new Coupon();
                $booking->setCoupon($coupon);

                array_push($this->bookingList, $booking);
            }

            return $this->bookingList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }


    public function Modify(Booking $booking)
    {
        $this->connection = Connection::GetInstance();

        $consulta = "UPDATE $this->tableName
        SET id= $booking->getId(), startDate = $booking->getStartDate(), endDate  = $booking->getEndDate(), state = $booking->getState(), validate = $booking->getValidate(), total = $booking->getTotal(), owner = $booking->getOwner()->getId(), keeper = $booking->getKeeper()->getId(), pet = $booking->getPet()->getId(), coupon = $booking->getCoupon()->getId()
        WHERE id = $booking->getId()";
        $connection = $this->connection;
        $connection->Execute($consulta);
    }

    public function Remove($id)
    {
        $this->connection = Connection::GetInstance();
        $aux = "DELETE From $this->tableName WHERE Id = $id";
        $connection = $this->connection;
        $connection->Execute($aux);
    }

    public function GetById($id)
    {
        $this->RetrieveData();

        $arrayBooking = array_filter($this->bookingList, function ($booking) use ($id) {
            return $booking->getId() == $id;
        });

        $arrayBooking = array_values($arrayBooking);

        return (count($arrayBooking) > 0) ? $arrayBooking[0] : null;
    }
    
    public function GetAllAcceptedByDate($startDate, $endDate)
    {
        $this->RetrieveData();

        $arrayBooking = array_filter($this->bookingList,function($booking) use($startDate, $endDate){
            return $booking->getValidate() == true && $booking->getStartDate() >= $startDate && $booking->getEndDate()<= $endDate;
        });

        $arrayBooking = array_values($arrayBooking);

        return (count($arrayBooking)>0) ? $arrayBooking : null;
    }

    public function GetActiveBookingOfUser($userId){
        $this->RetrieveData();

        $arrayBooking = array_filter($this->bookingList, function($booking) use($userId) {
            return ($booking->getUserId() == $userId && $booking->getState() == true) ? $booking : null;
        });

        return $arrayBooking;
    }

    public function GetAllByUserId($userId) {
        $this->RetrieveData();

        $array = array_filter($this->bookingList, function($booking) use($userId) {
            return $booking->getOwner()->getId() == $userId;
        });

        return $array;
    }
    
    private function GetNextId(){
        $id = 0;
        
        foreach($this->bookingList as $booking){
            $id = ($booking->getId() > $id) ? $booking->getId() : $id;
        }

        return $id + 1;
    }
}

