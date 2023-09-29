<?php

namespace Controllers;

use DAO\BookingDAO;
use DAO\CouponDAO;
use DAO\DayDAO;
use DAO\PetDAO;
use DAO\KeeperDAO as KeeperDAO;
use DAO\UserDAO;
use DateTime;
use Models\Booking;
use Models\Coupon;
use Others\Utilities;

class BookingController
{
    private $bookingDAO;
    private $petDAO;
    private $keeperDAO;
    private $homeController;
    public function __construct()
    {
        $this->bookingDAO = new BookingDAO();
        $this->petDAO = new PetDAO();
        $this->keeperDAO = new KeeperDAO();
        $this->homeController = new HomeController();
    }

    ///check if the session is started, if it is started you will see the sho list view if not the login to start/ 
    public function Index($message = " ")
    {
        if (isset($_SESSION["loggedUser"])) {
            $this->ShowListView();
        } else if (!isset($_SESSION["loggedUser"])) {
            $this->homeController->ShowLoginView();
        }
    }

    //loads the booking list view, using the user id returns all the bookings
    public function ShowListView($listEmpy = " ")
    {
        $this->homeController->ShowValidateSessionView();
        $this->homeController->NavUser();
        $bookingList = $this->bookingDAO->GetAllByUserId($_SESSION["loggedUser"]->getId());
        if (empty($bookingList)) {
            $listEmpy = "<div class= 'container'>
            <div class='form-group text-center'>
           <div class='alert alert-warning mt-3'>
          <p>Sorry, currently we have no keepers available at this time.#Add booking</p>
          </div></div></div>";
        }
        $date = new Utilities;
        require_once(VIEWS_PATH . "booking-list.php");
    }

    //loads the keepers filters view, using the user id returns a list of active pets
    public function ShowAddFiltersView($message = " ")
    {
        $this->homeController->ShowValidateSessionView();
        $this->homeController->NavUser();
        $listEmpy = "";

        $petList = $this->petDAO->GetActivePetsOfUser($_SESSION["loggedUser"]->getId());
        if (empty($petList)) {
            $listEmpy = "<div class= 'container'>
           <div class='form-group text-center'>
           <div class='alert alert-danger mt-3'>
          <p>Sorry, currently we do not have pet available at the moment</p>
          </div></div></div>";
        }
        require(VIEWS_PATH . "keeper-filters.php");
    }

    //loads the booking list keeper view, using the id of the keeper it returns a booking list
    public function ShowPaymentView($message = " ")
    {
        $this->homeController->ShowValidateSessionView();
        $this->homeController->NavUser();
        $listEmpy = "";
        $bookingList = $this->bookingDAO->GetListValidade($this->ReturnKeeperId());
        if (empty($bookingList)) {
            $listEmpy = "<div class= 'container'>
           <div class='form-group text-center'>
           <div class='alert alert-warning mt-3'>
          <p>Sorry, you currently has no users to pay at this time</p>
          </div></div></div>";
        }
        $date = new Utilities;
        $list = $this->MenuList();
        require_once(VIEWS_PATH . "booking-list-keeper.php");
    }

    //loads the booking list keeper confirmed view, using the id of the keeper and active it returns a booking list
    public function ShowConfirmedView($message = " ")
    {
        $this->homeController->ShowValidateSessionView();
        $this->homeController->NavUser();
        $listEmpy = "";
        $bookingList = $this->bookingDAO->GetListByKeeperIdAndState($this->ReturnKeeperId(), 1);
        if (empty($bookingList)) {
            $listEmpy = "<div class= 'container'>
           <div class='form-group text-center'>
           <div class='alert alert-warning mt-3'>
          <p>Sorry, you currently have no confirmed users at this time</p>
          </div></div></div>";
        }
        $date = new Utilities;
        $list = $this->MenuList();
        require_once(VIEWS_PATH . "booking-list-keeper-confirmed.php");
    }

    ////loads the booking list keeper confirmed view, using the id of the keeper and disable it returns a booking list
    public function ShowInWaitView($message = " ")
    {
        $this->homeController->ShowValidateSessionView();
        $this->homeController->NavUser();
        $listEmpy = "";
        $bookingList = $this->bookingDAO->GetListByKeeperIdAndState($this->ReturnKeeperId(), 0);
        if (empty($bookingList)) {
            $listEmpy = "<div class= 'container'>
           <div class='form-group text-center'>
           <div class='alert alert-warning mt-3'>
          <p>Sorry, you currently have no users on hold at this time</p>
          </div></div></div>";
        }
        $date = new Utilities;
        $list = $this->MenuList();
        require_once(VIEWS_PATH . "booking-list-keeper-wait.php");
    }

    ////loads the booking list keeper confirmed view, using the id of the keeper and denied it returns a booking list
    public function ShowDeclinedView($message = " ")
    {
        $this->homeController->ShowValidateSessionView();
        $this->homeController->NavUser();
        $listEmpy = "";
        $bookingList = $this->bookingDAO->GetListByKeeperIdAndState($this->ReturnKeeperId(), -1);
        if (empty($bookingList)) {
            $listEmpy = "<div class= 'container'>
           <div class='form-group text-center'>
           <div class='alert alert-warning mt-3'>
          <p>Sorry, currently, there are no users to deny</p>
          </div></div></div>";
        }
        $date = new Utilities;
        $list = $this->MenuList();
        require_once(VIEWS_PATH . "booking-list-keeper-declined.php");
    }

    //show the booking list keeper history view using the keeper id and return me a booking list
    public function ShowHistoryView($message = " ")
    {
        $this->homeController->ShowValidateSessionView();
        $this->homeController->NavUser();
        $listEmpy = "";
        $bookingList = $this->bookingDAO->GetListByKeeperId($this->ReturnKeeperId());
        if (empty($bookingList)) {
            $listEmpy = "<div class= 'container'>
           <div class='form-group text-center'>
           <div class='alert alert-warning mt-3'>
          <p>Sorry, currently, you have no users in history</p>
          </div></div></div>";
        }
        $date = new Utilities;
        $list = $this->MenuList();
        require_once(VIEWS_PATH . "booking-list-keeper-history.php");
    }

    //show the booking details view. receives a booking id parameter and returns a booking
    public function ShowDetailsView($bookingId, $message = "")
    {
        $this->homeController->ShowValidateSessionView();
        $this->homeController->NavUser();
        $listEmpy = "";
        $booking = $this->bookingDAO->GetById($bookingId);
        if (empty($booking)) {
            $listEmpy = "<div class= 'container'>
           <div class='form-group text-center'>
           <div class='alert alert-danger mt-3'>
          <p>Sorry, currently we do not have booking available at the moment</p>
          </div></div></div>";
        }
        require_once(VIEWS_PATH . "booking-details.php");
    }

    //load the add booking view, it needs the keeper list, the animal and the start and end date
    public function ShowAddView($keeperList, $pet, $startDate, $endDate, $message = " ")
    {
        $this->homeController->ShowValidateSessionView();
        $this->homeController->NavUser();
        require_once(VIEWS_PATH . "add-booking.php");
    }

    //I load the ShowAddView method and filter using the id parameters of the animal end date and start date. It returns me a keeper list
    public function FilterKeeper($idPet, $startDate, $endDate)
    {
        $this->homeController->ShowValidateSessionView();
        $dayDAO = new DayDAO();
        $listEmpy = "";
        $pet = $this->petDAO->GetPetById($idPet);
        $keeperList = $this->keeperDAO->GetByPetSize($pet->getPetSize()->getId());
        if (empty($keeperList)) {
            $listEmpy = "<div class= 'container'>
            <div class='form-group text-center'>
            <div class='alert alert-danger mt-3'>
                      <p>Sorry, currently we do not have Keepers available at the moment for pets with those characteristics...</p>
                      </div></div></div>";
        }

        $this->ShowAddView($keeperList, $pet, $startDate, $endDate, $listEmpy);
    }

    public function VerifyBreed($newPet, $startDate, $endDate, $keeper)
    {
        $rta = false;
        $booking = $this->bookingDAO->GetBykeeper($startDate, $endDate, $keeper->getId(), $_SESSION["loggedUser"]->getId());

        if (isset($booking)) {
            $pet = $this->petDAO->GetPetById($booking->getPet()->getId());
            if ($pet->getBreed()->getId() == $newPet->getBreed()->getId()) {
                $rta = true;
            }
        } else {
            $rta = true;
        }
        return $rta;
    }

    public function CalculateDate($startDate, $endDate, $keeper)
    {
        $rta = false;
        $dayDAO = new DayDAO();
        $diff = ((new DateTime($startDate))->diff(new DateTime($endDate)))->format("%d") + 1;
        $dayActive = $dayDAO->GetCountDayForDate($startDate, $endDate, $keeper->getId(), 1);
        if ($dayActive == $diff) {
            $rta = true;
        }
        return $rta;
    }

    //add a booking, as parameters it has an animal, the start date, end date and a keeper
    public function Add($id_pet, $startDate, $endDate, $id_keeper)
    {
        $this->homeController->ShowValidateSessionView();

        $keeper = $this->keeperDAO->GetListByKeeper($id_keeper);
        $pet = $this->petDAO->GetPetById($id_pet);

        $exis = $this->bookingDAO->Exist($startDate, $endDate, $_SESSION["loggedUser"]->getId(), $id_keeper, $id_pet);

        if ($exis == false) {
            $exisBreed = $this->VerifyBreed($pet, $startDate, $endDate, $keeper);
            if ($exisBreed == true) {
                $existDay = $this->CalculateDate($startDate, $endDate, $keeper);
                if ($existDay == true) {

                    $booking = new Booking();

                    $userDAO = new UserDAO();

                    $booking->setOwner($userDAO->GetById($_SESSION["loggedUser"]->getId()));
                    $booking->setKeeper($this->keeperDAO->GetById($id_keeper));
                    $booking->setPet($this->petDAO->GetPetById($id_pet));
                    $booking->setStartDate($startDate);
                    $booking->setEndDate($endDate);
                    $booking->setValidate(0);
                    $booking->setState(0);

                    $diff = ((new DateTime($startDate))->diff(new DateTime($endDate)))->format("%d") + 1;

                    $total = ($diff) * $this->keeperDAO->GetById($id_keeper)->getRemuneration();
                    $booking->setTotal($total);

                    $this->bookingDAO->Add($booking);

                    $this->ShowListView("<div class= 'container'>
    <div class='form-group text-center'>
    <div class='alert alert-success mt-3'>
              <p>The booking was confirmed </p>
              </div></div></div>");
                } else {
                    $this->ShowListView("<div class= 'container'>
        <div class='form-group text-center'>
        <div class='alert alert-danger mt-3'>
                  <p>The days have to be followed</p>
                  </div></div></div>");
                }
            } else {
                $this->ShowListView("<div class= 'container'>
    <div class='form-group text-center'>
    <div class='alert alert-danger mt-3'>
              <p>The animal have not the breed equals</p>
              </div></div></div>");
            }
        } else {
            $this->ShowListView("<div class= 'container'>
        <div class='form-group text-center'>
        <div class='alert alert-danger mt-3'>
                  <p>This booking was already registered in the system</p>
                  </div></div></div>");
        }
    }


    //changes the status of a booking from valid to invalid, as parameters it has the id and the status
    public function ChangeState($bookingId, $state)
    {
        $this->homeController->ShowValidateSessionView();
        $rta = false;
        $booking = $this->bookingDAO->GetById($bookingId);

        if (!is_null($booking)) {
            $booking->setState(intval($state));

            $this->bookingDAO->Modify($booking);

            $rta = true;
        }

        return $rta;
    }

    //confirm a booking and create a coupon with the information and the amount to pay, validate if it is enabled
    public function Confirm($bookingId)
    {
        $this->homeController->ShowValidateSessionView();

        if ($this->ChangeState($bookingId, 1)) {

            $booking = $this->bookingDAO->GetById($bookingId);
            $coupon = new Coupon();
            $coupon->setBooking($booking);
            $coupon->setTotal($booking->getTotal() * 0.5);
            $coupon->setMethod("NA");
            $coupon->setIsPayment(0);
            $coupon->setDiscount(0);

            $couponDAO = new CouponDAO();
            $couponDAO->Add($coupon);

            $dayDAO = new DayDAO();
            $dayDAO->SetNoAvailable($booking->getStartDate(), $booking->getEndDate(), $booking->getKeeper()->getId());

            $this->ShowInWaitView("<div class= 'container'>
            <div class='form-group text-center'>
            <div class='alert alert-success mt-3'>
                      <p>The reservation has been confirmed</p>
                      </div></div></div>");
        } else {
            $this->ShowInWaitView("<div class= 'container'>
            <div class='form-group text-center'>
            <div class='alert alert-danger mt-3'>
                      <p>There was an error trying to perform the action</p>
                      </div></div></div>");
        }
    }

    //delete a booking, passing the id of the booking
    public function Decline($bookingId)
    {
        $this->homeController->ShowValidateSessionView();

        if ($this->ChangeState($bookingId, -1)) {
            $this->ShowInWaitView("<div class= 'container'>
            <div class='form-group text-center'>
            <div class='alert alert-success mt-3'>
                      <p>The reservation has been declined</p>
                      </div></div></div>");
        } else {
            $this->ShowInWaitView("<div class= 'container'>
            <div class='form-group text-center'>
            <div class='alert alert-danger mt-3'>
                      <p>There was an error trying to perform the action</p>
                      </div></div></div>");
        }
    }

    //the List menu view
    public function MenuList()
    {
        $list = "<div>
<a class='btn btn-primary' href='" . FRONT_ROOT . "Booking/ShowPaymentView'>
    <svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentColor' class='bi bi-coin' viewBox='0 0 16 16'>
        <path d='M5.5 9.511c.076.954.83 1.697 2.182 1.785V12h.6v-.709c1.4-.098 2.218-.846 2.218-1.932 0-.987-.626-1.496-1.745-1.76l-.473-.112V5.57c.6.068.982.396 1.074.85h1.052c-.076-.919-.864-1.638-2.126-1.716V4h-.6v.719c-1.195.117-2.01.836-2.01 1.853 0 .9.606 1.472 1.613 1.707l.397.098v2.034c-.615-.093-1.022-.43-1.114-.9H5.5zm2.177-2.166c-.59-.137-.91-.416-.91-.836 0-.47.345-.822.915-.925v1.76h-.005zm.692 1.193c.717.166 1.048.435 1.048.91 0 .542-.412.914-1.135.982V8.518l.087.02z'/>
        <path d='M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z'/>
        <path d='M8 13.5a5.5 5.5 0 1 1 0-11 5.5 5.5 0 0 1 0 11zm0 .5A6 6 0 1 0 8 2a6 6 0 0 0 0 12z'/>
    </svg>
    Payment
</a>
<a class='btn btn-success' href='" . FRONT_ROOT . "Booking/ShowConfirmedView'>
        <svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentColor' class='bi bi-check2-square' viewBox='0 0 16 16'>
            <path d='M3 14.5A1.5 1.5 0 0 1 1.5 13V3A1.5 1.5 0 0 1 3 1.5h8a.5.5 0 0 1 0 1H3a.5.5 0 0 0-.5.5v10a.5.5 0 0 0 .5.5h10a.5.5 0 0 0 .5-.5V8a.5.5 0 0 1 1 0v5a1.5 1.5 0 0 1-1.5 1.5H3z'/>
            <path d='m8.354 10.354 7-7a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0z'/>
        </svg>
        Accepted
</a>
<a class='btn btn-warning' href='" . FRONT_ROOT . "Booking/ShowInWaitView'>
    <svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentColor' class='bi bi-hourglass-split' viewBox='0 0 16 16'>
        <path d='M2.5 15a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1h-11zm2-13v1c0 .537.12 1.045.337 1.5h6.326c.216-.455.337-.963.337-1.5V2h-7zm3 6.35c0 .701-.478 1.236-1.011 1.492A3.5 3.5 0 0 0 4.5 13s.866-1.299 3-1.48V8.35zm1 0v3.17c2.134.181 3 1.48 3 1.48a3.5 3.5 0 0 0-1.989-3.158C8.978 9.586 8.5 9.052 8.5 8.351z'/>
    </svg>
    In wait
</a>
<a class='btn btn-danger' href='" .  FRONT_ROOT . "Booking/ShowDeclinedView'>
    <svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentColor' class='bi bi-trash' viewBox='0 0 16 16'>
        <path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z'/>
        <path fill-rule='evenodd' d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z'/>
    </svg>
    Declined
</a>
<a class='btn btn-secondary' href='" . FRONT_ROOT . "Booking/ShowHistoryView'>
    <svg xmlns='http://www.w3.org/2000/svg'width='16' height='16' fill='currentColor' class='bi bi-folder2-open' viewBox='0 0 16 16'>
        <path d='M1 3.5A1.5 1.5 0 0 1 2.5 2h2.764c.958 0 1.76.56 2.311 1.184C7.985 3.648 8.48 4 9 4h4.5A1.5 1.5 0 0 1 15 5.5v.64c.57.265.94.876.856 1.546l-.64 5.124A2.5 2.5 0 0 1 12.733 15H3.266a2.5 2.5 0 0 1-2.481-2.19l-.64-5.124A1.5 1.5 0 0 1 1 6.14V3.5zM2 6h12v-.5a.5.5 0 0 0-.5-.5H9c-.964 0-1.71-.629-2.174-1.154C6.374 3.334 5.82 3 5.264 3H2.5a.5.5 0 0 0-.5.5V6zm-.367 1a.5.5 0 0 0-.496.562l.64 5.124A1.5 1.5 0 0 0 3.266 14h9.468a1.5 1.5 0 0 0 1.489-1.314l.64-5.124A.5.5 0 0 0 14.367 7H1.633z'/>
    </svg>
    History
</a>
</div>";
        return $list;
    }

    //using the id of the user, returns the keeper of the bdd
    public function ReturnKeeperId()
    {
        $keeperDAO = new KeeperDAO();
        $keeper = $keeperDAO->GetByUserId($_SESSION["loggedUser"]->getId());
        return $keeper->getId();
    }
}
