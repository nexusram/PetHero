<?php
    namespace DAO;
    
    use Models\Booking as Booking;

    interface IBookingDAO{
        public function Add(Booking $booking);
        public function GetAll();
        public function Remove($id);
        public function Modify(Booking $booking);
        public function GetById($id);
    }
?>