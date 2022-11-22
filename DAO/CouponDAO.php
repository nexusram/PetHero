<?php
    namespace DAO;

    use \Exception as Exception;

use Models\Coupon;

    class CouponDAO implements ICouponDAO{
        private $couponList = array();
        private $connection;
        private $tableName = 'coupon';

        public function Add(Coupon $coupon)
        {
            $this->Insert($coupon);
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
            $booking = $bookingDAO->GetById($valuesArray[0]["id"]);

            $booking->setBooking($booking);

            $coupon->setMethod($valuesArray[0]["method"]);
            $coupon->setIsPayment($valuesArray[0]["isPayment"]);
            $coupon->setDiscount($valuesArray[0]["discount"]);
            $coupon->setTotal($valuesArray[0]["total"]);
        } catch (Exception $ex) {
            throw $ex;
        }
        return $coupon;
    }


    }

?>