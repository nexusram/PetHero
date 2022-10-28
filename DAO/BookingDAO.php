<?php
    namespace DAO;

    use DAO\IBookingDAO as IBookingDAO;
    use Models\Booking as Booking;

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
                    $booking->setIdOwner($value["idOwner"]);
                    $booking->setIdKeeper($value["idKeeper"]);
                    $booking->setIdMascota($value["idMascota"]);
                    $booking->setIdCoupon($value["idCoupon"]);
                    $booking->setStartDate($value["startDate"]);
                    $booking->setEndDate($value["endDate"]);
                    $booking->setState($value["state"]);
                    $booking->setTotal($value["total"]);

                    array_push($this->bookingList, $booking);
                }
            }
        }

        private function SaveData(){
            sort($this->bookingList);

            $arrayEncode = array();

            foreach($this->bookingList as $booking){
                $value["id"] = $booking->getId();
                $value["idOwner"] = $booking->getIdOwner();
                $value["idKeeper"] = $booking->getIdKeeper();
                $value["idMascota"] = $booking->getIdMascota();
                $value["idCoupon"] = $booking->getIdCoupon();
                $value["startDate"] = $booking->getStartDate();
                $value["endDate"] = $booking->getEndDate();
                $value["state"] = $booking->getState();
                $value["total"] = $booking->getTotal();

                array_push($arrayEncode, $value);
            }

            $jsonContent = json_encode($arrayEncode, JSON_PRETTY_PRINT);
            file_get_contents($this->fileName, $jsonContent);
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