<?php
    namespace DAO;
    
    use Models\Booking as Booking;

    interface IBookingDAO{
     function Add(Booking $booking);
     function Modify(Booking $booking);
     function GetAll();
     function GetById($id);
     function GetAllAcceptedByDate($startDate, $endDate);
     function GetActiveBookingOfUser($userId);
     function GetAllByUserId($userId);
     function GetListValidade($keeperId);
     function GetListByKeeperId($keeperId);
     function GetListByKeeperIdAndState($keeperId, $state);
     function GetListByKeeperIdAndDates($keeperId, $startDate, $endDate);
    }
