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

    public function ShowPaymentView($message="", $type="") {
        require_once(VIEWS_PATH . "validate-session.php");
        include_once(VIEWS_PATH . "nav-user.php");

        $bookingList = $this->bookingDAO->GetAllByUserId($_SESSION["loggedUser"]->getId());
        require_once(VIEWS_PATH . "booking-list-keeper.php");
    }

    public function ShowConfirmedView($message="", $type="") {
        require_once(VIEWS_PATH . "validate-session.php");
        include_once(VIEWS_PATH . "nav-user.php");

        $bookingList = $this->bookingDAO->GetListByKeeperIdAndState($returnKeeper->getId(), 1);

        require_once(VIEWS_PATH . "booking-list-keeper-confirmed.php");
    }

    public function ShowInWaitView($message="", $type="") {
        require_once(VIEWS_PATH . "validate-session.php");
        include_once(VIEWS_PATH . "nav-user.php");

        $bookingList = $this->bookingDAO->GetListByKeeperIdAndState($returnKeeper->getId(), 0);
        require_once(VIEWS_PATH . "booking-list-keeper-wait.php");
    }

    public function ShowDeclinedView($message="", $type="") {
        require_once(VIEWS_PATH . "validate-session.php");
        include_once(VIEWS_PATH . "nav-user.php");

        $bookingList = $this->bookingDAO->GetListByKeeperIdAndState($returnKeeper->getId(), -1);
        require_once(VIEWS_PATH . "booking-list-keeper-declined.php");
    }

    public function ShowHistoryView($message="", $type="") {
        require_once(VIEWS_PATH . "validate-session.php");
        include_once(VIEWS_PATH . "nav-user.php");

        $bookingList = $this->bookingDAO->GetListByKeeperId($returnKeeper->getId());
        require_once(VIEWS_PATH . "booking-list-keeper-history.php");
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
        $rta = false;
        $booking = $this->bookingDAO->GetById($bookingId);

        if(!is_null($booking)) {
            $booking->setState(intval($state));
            
            $this->bookingDAO->Modify($booking);

            $rta = true;
        }

        return $rta;
    }

    public function Confirm($bookingId) {
        if($this->ChangeState($bookingId, 1)) {

            $booking = $this->bookingDAO->GetById($bookingId);
            $coupon = new Coupon();
            $coupon->setBooking($booking);
            $coupon->setTotal($booking->getTotal() * 0.5);
            $coupon->setMethod("NA");
            $coupon->setIsPayment(0);
            $coupon->setDiscount(0);

            $couponDAO = new CouponDAO();
            $couponDAO->Add($coupon);

            $this->ShowConfirmedView("The reservation has been confirmed", "success");
        } else {
            $this->ShowInWaitView("There was an error trying to perform the action");
        }        
    }

    public function Decline($bookingId) {
        if($this->ChangeState($bookingId, -1)) {
            $this->ShowConfirmedView("The reservation has been declined", "success");
        } else {
            $this->ShowInWaitView("There was an error trying to perform the action");
        }        
    }
}
