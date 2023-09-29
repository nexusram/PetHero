<?php

namespace Controllers;

use DAO\DayDAO;
use DAO\KeeperDAO;
use Models\Day;

class DayController
{
    private $dayDAO;
    private $keeperDAO;
    private $homeController;

    public function __construct()
    {
        $this->dayDAO = new DayDAO();
        $this->keeperDAO = new KeeperDAO();
        $this->homeController = new HomeController();
    }

  //check if the session is started, if it is started you will see the Show list view if not the login to start/ 
    public function Index($message = "")
    {
        if (isset($_SESSION["loggedUser"])) {
            $this->homeController->ShowWelcomeView();
        } else if (!isset($_SESSION["loggedUser"])) {
            $this->homeController->ShowLoginView($message);
        }
    }

    //view of days according to keeper
    public function ShowListView($message = " ")
    {
        $this->homeController->ShowValidateSessionView();
        $this->homeController->NavUser();
        $listEmpty = "";
        $keeper = $this->keeperDAO->GetByUserId($_SESSION["loggedUser"]->getId());
        $dayList = $this->dayDAO->GetActiveListByKeeper($keeper->getId());
        if (empty($dayList)) {
            $listEmpty = "<div class='container alert alert-warning'>
            <div class='content text-center'>
                 <p><strong>You have no added days. to start add with the #Add button</strong></p>
            </div>
       </div>";
        }
        require_once(VIEWS_PATH . "list-day.php");
    }

    //view of unavailable days according to keeper
    public function ShowNotAvailableView($message = "")
    {
        $this->homeController->ShowValidateSessionView();
        $this->homeController->NavUser();
        $listEmpty = " ";
        $keeper = $this->keeperDAO->GetByUserId($_SESSION["loggedUser"]->getId());
        $dayList = $this->dayDAO->GetInactiveListByKeeper($keeper->getId());
        if (isset($dayList) && empty($dayList)) {
            $listEmpty = "<div class='container alert alert-warning'>
            <div class='content text-center'>
                 <p><strong>You have no added days. to start add with the #Add button</strong></p>
            </div>
       </div>";
        }
        require_once(VIEWS_PATH . "list-not-available-day.php");
    }

    //view to add days
    public function ShowAddView($message = "")
    {
        $this->homeController->ShowValidateSessionView();
        $this->homeController->NavUser();

        require_once(VIEWS_PATH . "add-day.php");
    }

    //add days according to start and end days
    public function Add($startDate, $endDate)
    {
        $this->homeController->ShowValidateSessionView();

        $startDate = strtotime($startDate);
        $endDate = strtotime($endDate);

        $this->AddDay($startDate, $endDate);
    }

    //add days according to start and end days
    private function AddDay($startDate, $endDate)
    {
        $this->homeController->ShowValidateSessionView();

        $keeper = $this->keeperDAO->GetByUserId($_SESSION["loggedUser"]->getId());
        $array = array();
        $control = false;

        for ($i = $startDate; $i <= $endDate; $i += 86400) {
            if (!$this->ExistDate($i, $keeper->getId())) {
                array_push($array, $i);
            } else {
                $control = true;
            }
        }
        if (!$control) {
            foreach ($array as $value) {
                $this->LoadDay($value, $keeper);
            }
            $this->ShowListView("<div class= 'container'>
            <div class='form-group text-center'>
            <div class='alert alert-success mt-3'>
                      <p>Days added successfully</p>
                      </div></div></div>");
        } else {
            $this->ShowAddView("<div class= 'container'>
            <div class='form-group text-center'>
            <div class='alert alert-warning mt-3'>
                      <p>Some of the dates already exist</p>
                      </div></div></div>");
        }
    }

    //add days according to start and end days
    private function LoadDay($date, $keeper)
    {
        $this->homeController->ShowValidateSessionView();

        $day = new Day();
        $day->setDate(date(FORMAT_DATE, $date));
        $day->setKeeper($keeper);
        // Por defecto esta disponible
        $day->setIsAvailable(1);
        $this->dayDAO->Add($day);
    }

    //check if the day does not exist
    private function ExistDate($date, $keeperId)
    {
        $this->homeController->ShowValidateSessionView();

        $rta = false;
        $dayList = $this->dayDAO->GetListByKeeper($keeperId);
        foreach ($dayList as $day) {
            if (strcmp($day->getDate(), date(FORMAT_DATE, $date)) == 0) {
                $rta = true;
            }
        }
        return $rta;
    }

    //validates the day according to id
    public function Available($id,$message)
    {
        $this->homeController->ShowValidateSessionView();

        $day = $this->dayDAO->GetById($id);

        $day->setIsAvailable(1);

        $this->dayDAO->Modify($day);

        $this->ShowListView($message);
    }

    //does no validate the day according to id
    public function NotAvailable($id)
    {
        $this->homeController->ShowValidateSessionView();

        if ($id != null) {
            $day = $this->dayDAO->GetById($id);
            $day->setIsAvailable(0);

            $this->dayDAO->Modify($day);
            $this->ShowListView("<div class= 'container'>
            <div class='form-group text-center'>
            <div class='alert alert-success mt-3'>
                      <p>successfully</p>
                      </div></div></div>");
        } else {
            $this->ShowListView("<div class= 'container'>
            <div class='form-group text-center'>
            <div class='alert alert-warning mt-3'>
                      <p>There was an error trying to not available the day</p>
                      </div></div></div>");
        }
    }
}
