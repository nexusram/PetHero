<?php

namespace DAO;

use \Exception as Exception;

use Models\Coupon;

class CouponDAO implements ICouponDAO
{
    private $couponList = array();
    private $connection;
    private $tableName = 'coupon';

    public function Add(Coupon $coupon)
    {
        $this->Insert($coupon);
    }

    public function Modify(Coupon $coupon)
    {
        $this->Update($coupon);
    }

    private function Insert(Coupon $coupon)
    {
        $query = "INSERT INTO $this->tableName (id_booking, method, isPayment, discount, total) VALUES (:id_booking, :method, :isPayment, :discount, :total);";
        $this->SetQuery($coupon, $query);
    }

    private function Update(Coupon $coupon)
    {
        $query = "UPDATE $this->tableName SET id_booking = :id_booking, method = :method, isPayment = :isPayment, discount = :discount, total = :total WHERE id = {$coupon->getId()}";
        $this->SetQuery($coupon, $query);
    }

    private function SetQuery($coupon, $query)
    {
        try {
            $parameters["id_booking"] = $coupon->getBooking()->GetId();
            $parameters["method"] = $coupon->getMethod();
            $parameters["isPayment"] = $coupon->getIsPayment();
            $parameters["discount"] = $coupon->getDiscount();
            $parameters["total"] = $coupon->getTotal();
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function GetAllByIdKeeper($idKeeper)
    {
        $query = "SELECT * from $this->tableName c 
            inner join booking b on c.id_booking = b.id inner join 
            b.id_keeper = {$idKeeper};";

        return $this->GetQuery($query);
    }

    private function GetQuery($query)
    {
        try {
            $this->connection = Connection::GetInstance();
            $valuesArray = $this->connection->Execute($query);

            $coupon = new Coupon();
            $coupon->setId($valuesArray[0]["id"]);

            $bookingDAO = new BookingDAO();
            $booking = $bookingDAO->GetById($valuesArray[0]["id_booking"]);

            $coupon->setBooking($booking);

            $coupon->setMethod($valuesArray[0]["method"]);
            $coupon->setIsPayment($valuesArray[0]["isPayment"]);
            $coupon->setDiscount($valuesArray[0]["discount"]);
            $coupon->setTotal($valuesArray[0]["total"]);
        } catch (Exception $ex) {
            throw $ex;
        }
        return $coupon;
    }

    public function GetAll()
    {
        $this->RetrieveDate();
        return $this->couponList;
    }
    
    private function RetrieveDate()
    {
        $query = "SELECT * FROM $this->tableName";
        $this->GetAllQuery($query);
    }

    public function GetByBookingId($bookingId)
    {
        $query = "SELECT * FROM $this->tableName WHERE id_booking = {$bookingId}";

        return $this->GetQuery($query);
    }

    private function GetAllQuery($query)
    {
        $this->couponList = array();
        try {
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query);
            foreach ($resultSet as $valuesArray) {
                $coupon = new Coupon();
                $coupon->setId($valuesArray["id"]);

                $bookingDAO = new BookingDAO();
                $booking = $bookingDAO->GetById($valuesArray["id_booking"]);

                $booking->setBooking($booking);

                $coupon->setMethod($valuesArray["method"]);
                $coupon->setIsPayment($valuesArray["isPayment"]);
                $coupon->setDiscount($valuesArray["discount"]);
                $coupon->setTotal($valuesArray["total"]);
                array_push($this->couponList, $coupon);
            }
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}
