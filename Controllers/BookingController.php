<?php

namespace Controllers;


use DAO\BookingDAO;
use DAO\PetDAO;
use DAO\KeeperDAO as KeeperDAO;
use DAO\PetSizeDAO;
use DAO\UserDAO;
use Models\Booking;
use Models\Coupon;
use Models\Keeper;
use Models\PetSize;

class BookingController
{
    private $bookingDAO;
    private $petDAO;
    private $keeperDAO;
    


    public function __construct()
    {
        $this->bookingDAO = new BookingDAO();
        $this->petDAO = new PetDAO();
        $this->keeperDAO = new KeeperDAO();

    }

    // Muestra un listado de Reservas
    public function ShowListView() {
        require_once(VIEWS_PATH . "validate-session.php");
        $userList = new UserController();
        $bookingList = $this->bookingDAO->GetAll();////devuleve todos los booking

        require_once(VIEWS_PATH . "booking-list.php");
    }

    public function ShowAddView($keeperList, $pet, $startDate, $endDate, $message="", $type="") {
        require_once(VIEWS_PATH . "validate-session.php");
        require_once(VIEWS_PATH . "add-booking.php");
    }

    public function ShowAddFiltersView(){
        require_once(VIEWS_PATH . "validate-session.php");

        $petList = $this->petDAO->GetActivePetsOfUser($_SESSION["loggedUser"]->getId());

        require(VIEWS_PATH . "keeper-filters.php");
    }
    
    public function FilterKeeper($petId, $startDate, $endDate){
        require_once(VIEWS_PATH . "validate-session.php");
        $pet = $this->petDAO->GetPetById($petId);

        $keeperList = $this->keeperDAO->GetAllFiltered($pet, $startDate, $endDate);

        $this->ShowAddView($keeperList, $pet, $startDate, $endDate, "Sorry, currently we do not have Keepers available at the moment for pets with those characteristics...");
    }

    public function Add($keeper, $pet, $startDate, $endDate, $validate = true, $total=0){
        require_once(VIEWS_PATH . "validate-session.php");

        $booking = new Booking();

        $userDAO = new UserDAO();

        $coupon = new Coupon();
        $coupon->setId(1);
        $booking = new Booking();
        $coupon->setBooking($booking);
        $coupon->setMethod(2);
        $coupon->setIsPayment(false);
        $coupon->setDiscount(50);
        $coupon->setTotal(500);

        $booking->setOwner($userDAO->GetById($_SESSION["loggedUser"]->getId()));
        $booking->setKeeper($this->keeperDAO->GetById($keeper));
        $booking->setPet($this->petDAO->GetPetById($pet));
        $booking->setCoupon($coupon);
        $booking->setStartDate($startDate);
        $booking->setEndDate($endDate);
        $booking->setValidate($validate);
        $booking->setTotal($total);

        $this->bookingDAO->Add($booking);


    }
    
}
