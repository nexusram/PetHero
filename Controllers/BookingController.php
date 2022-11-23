<?php

namespace Controllers;


use DAO\BookingDAO;
use DAO\CouponDAO;
use DAO\PetDAO;
use DAO\KeeperDAO as KeeperDAO;
use DAO\PetSizeDAO;
use DAO\UserDAO;
use DateTime;
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
    public function ShowListView()
    {
        require_once(VIEWS_PATH . "validate-session.php");
        $bookingList = $this->bookingDAO->GetAllByUserId($_SESSION["loggedUser"]->getId()); ////devuleve todos los booking
        require_once(VIEWS_PATH . "booking-list.php");
    }

    public function ShowAddView($keeperList, $pet, $startDate, $endDate, $message="", $type="")
    {
        require_once(VIEWS_PATH . "validate-session.php");
        require_once(VIEWS_PATH . "add-booking.php");
    }

    public function ShowAddFiltersView()
    {
        require_once(VIEWS_PATH . "validate-session.php");

        $petList = $this->petDAO->GetActivePetsOfUser($_SESSION["loggedUser"]->getId());
        require(VIEWS_PATH . "keeper-filters.php");
    }

    public function ShowValidateView() {
        require_once(VIEWS_PATH . "validate-session.php");
        include_once(VIEWS_PATH . "nav-user.php");

        $bookingList = $this->bookingDAO->GetAllByUserId($_SESSION["loggedUser"]->getId());
        require_once(VIEWS_PATH . "booking-list-keeper.php");
    }

    
    public function ShowConfirmed(){
        require_once(VIEWS_PATH . "validate-session.php");
        include_once(VIEWS_PATH . "nav-user.php");

        $bookingList = $this->bookingDAO->GetAllByUserId($returnKeeper->getId());
        require_once(VIEWS_PATH . "booking-list-keeper-confirmed.php");
    }

    public function ShowInWait($message="", $type=""){
        require_once(VIEWS_PATH . "validate-session.php");
        include_once(VIEWS_PATH . "nav-user.php");

        $bookingList = $this->bookingDAO->GetInWaitByKeeperId($returnKeeper->getId());
        require_once(VIEWS_PATH . "booking-list-keeper-wait.php");
    }

    public function FilterKeeper($idPet, $startDate, $endDate)
    {
        require_once(VIEWS_PATH . "validate-session.php");
        $message = "";
        $pet = $this->petDAO->GetPetById($idPet);
        $keeperList = $this->keeperDAO->GetAllFiltered($pet, $startDate, $endDate);

        if (empty($keeperList)) {
            $message = "Sorry, currently we do not have Keepers available at the moment for pets with those characteristics...";
        }

        $this->ShowAddView($keeperList, $pet, $startDate, $endDate, $message, $type="");
    }

    public function Add($pet, $startDate, $endDate, $keeper)
    {
        require_once(VIEWS_PATH . "validate-session.php");

        $booking = new Booking();

        $userDAO = new UserDAO();

        $booking->setOwner($userDAO->GetById($_SESSION["loggedUser"]->getId()));
        $booking->setKeeper($this->keeperDAO->GetById($keeper));
        $booking->setPet($this->petDAO->GetPetById($pet));
        $booking->setStartDate($startDate);
        $booking->setEndDate($endDate);
        $booking->setValidate(0);
        // For default it is wait
        $booking->setState(0);

        $diff = ((new DateTime($startDate))->diff(new DateTime($endDate)))->format("%d")+1;

        $total = ($diff) * $this->keeperDAO->GetById($keeper)->getRemuneration();
           //total es el calculo de la diferencia de fechas * la remuneracion por dia del keeper 
        $booking->setTotal($total);

        $this->bookingDAO->Add($booking);

        $this->ShowListView();
    }

    public function ChangeState($bookingId , $state) {
        $booking = $this->bookingDAO->GetById($bookingId);

        if(!is_null($booking)) {
            $booking->setState(intval($state));
            
            $this->bookingDAO->Modify($booking);

            $this->ShowConfirmed("The reservation has been confirmed", "success");
        } else {
            $this->ShowInWait("There was an error trying to perform the action");
        }
    }
}
