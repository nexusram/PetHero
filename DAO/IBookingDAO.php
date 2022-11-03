<?php
    namespace DAO;
    
    use Models\Booking as Booking;

    interface IBookingDAO{
         function Add(Booking $booking);
         function Remove($id);
         function Modify(Booking $booking);
         function GetById($id);
    }
