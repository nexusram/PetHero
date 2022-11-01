<?php
    namespace DAO;

    use DAO\IBookingDAO as IBookingDAO;
    use Models\Booking as Booking;
use Models\Coupon;

    class BookingDAO implements IBookingDAO{
        private $bookingList;
        private $fileName = ROOT."Data/bookings.json";

        //constructor vacio por defecto
        public function Add(Booking $booking)
        {
            $this->RetrieveData();

            $booking->setId($this->GetNextId());//seteo el id autoincremental
            $booking->setState(true);//seteo que siempre cuando se añada quede activa.

            array_push($this->bookingList, $booking);

            $this->SaveData();
        }

        public function GetAll()
        {
            $this->RetrieveData();
            return $this->bookingList;
        }

        public function Remove($id)
        {
            $this->RetrieveData();

            $this->bookingList = array_filter($this->bookingList, function($booking) use ($id){
                return $booking->getId() != $id;
            });

            $this->SaveData();
        }

        public function Modify(Booking $booking)
        {
            $this->RetrieveData();

            $this->Remove($booking->getId());

            array_push($this->bookingList, $booking);

            $this->SaveData();
        }

        public function GetById($id)
        {
            $this->RetrieveData();

            $arrayBooking = array_filter($this->bookingList,function($booking) use ($id){
                return $booking->getId() == $id;
            });

            $arrayBooking = array_values($arrayBooking);

            return (count($arrayBooking)>0) ? $arrayBooking[0] : null;
        }

        private function RetrieveData(){
            $this->bookingList = array();

            if(file_exists($this->fileName)){
                $jsonContent = file_get_contents($this->fileName);

                $arrayDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

                foreach($arrayDecode as $value){
                    $booking = new Booking();

                    $booking->setId($value["id"]);
                    $booking->setStartDate($value["startDate"]);
                    $booking->setEndDate($value["endDate"]);
                    $booking->setState($value["state"]);
                    $booking->setValidate($value["validate"]);
                    $booking->setTotal($value["total"]);

                    //instanciar objetos
                    $userDAO = new UserDAO();
                    $user = $userDAO->GetById($value["owner"]);
                    $booking->setOwner($user);

                    $keeperDAO = new KeeperDAO();
                    $keeper = $keeperDAO->GetById($value["keeper"]);
                    $booking->setKeeper($keeper);

                    $petDAO = new PetDAO();
                    $pet = $petDAO->GetPetById($value["pet"]);
                    $booking->setPet($pet);

                    /*$couponDAO = new CouponDAO();
                    $coupon = CouponDAO->GetById($value["coupon"]);*/
                    $coupon = new Coupon();
                    $booking->setCoupon($coupon);

                    array_push($this->bookingList, $booking);
                }
            }
        }

        private function SaveData(){
            sort($this->bookingList);

            $arrayEncode = array();

            foreach($this->bookingList as $booking){
                $value["id"] = $booking->getId();
                $value["owner"] = $booking->getOwner()->getId();
                $value["keeper"] = $booking->getKeeper()->getId();
                $value["pet"] = $booking->getPet()->getId();
                $value["coupon"] = $booking->getCoupon()->getId();
                $value["startDate"] = $booking->getStartDate();
                $value["endDate"] = $booking->getEndDate();
                $value["state"] = $booking->getState();
                $value["validate"] = $booking->getValidate();
                $value["total"] = $booking->getTotal();

                array_push($arrayEncode, $value);
            }

            $jsonContent = json_encode($arrayEncode, JSON_PRETTY_PRINT);
            file_get_contents($this->fileName, $jsonContent);
        }

        public function GetActiveBookingOfUser($userId){
            $this->RetrieveData();

            $arrayBooking = array_filter($this->bookingList, function($booking) use($userId) {
                return ($booking->getUserId() == $userId && $booking->getState() == true) ? $booking : null;
            });

            return $arrayBooking;
        }

        private function GetNextId(){
            $id = 0;
            
            foreach($this->bookingList as $booking){
                $id = ($booking->getId()>$id) ? $booking->getId() : $id;
            }

            return $id + 1;
        }
    }
?>