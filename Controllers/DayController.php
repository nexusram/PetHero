<?php

    namespace Controllers;

    use DAO\DayDAO;
    use DAO\KeeperDAO;
    use Models\Day;

    class DayController {
        private $keeperDAO;
        private $dayDAO;

        public function __construct() {
            $this->keeperDAO = new KeeperDAO();
            $this->dayDAO = new DayDAO();
        }

        public function ShowListView($message="", $type="") {
            require_once(VIEWS_PATH . "validate-session.php");

            $keeper = $this->keeperDAO->GetByUserId($_SESSION["loggedUser"]->getId());
            $dayList = $this->dayDAO->GetActiveListByKeeper($keeper->getId());

            require_once(VIEWS_PATH . "list-day.php");
        }

        public function ShowAddView($message="", $type="") {
            require_once(VIEWS_PATH . "validate-session.php");
            require_once(VIEWS_PATH . "add-day.php");
        }

        public function ShowNotAvailableView($message="", $type="") {
            require_once(VIEWS_PATH . "validate-session.php");
            $keeper = $this->keeperDAO->GetByUserId($_SESSION["loggedUser"]->getId());
            $dayList = $this->dayDAO->GetInactiveListByKeeper($keeper->getId());
            require_once(VIEWS_PATH . "list-not-available-day.php");
        }

        public function Add($startDate, $endDate) {
            require_once(VIEWS_PATH . "validate-session.php");

            $startDate = strtotime($startDate);
            $endDate = strtotime($endDate);

            $this->AddDay($startDate, $endDate);
        }

        private function AddDay($startDate, $endDate) {
            $keeper = $this->keeperDAO->GetByUserId($_SESSION["loggedUser"]->getId());
            $array = array();
            $control = false;

            for($i = $startDate; $i <= $endDate; $i+=86400) {
                if(!$this->ExistDate($i, $keeper->getId())) {
                    array_push($array, $i);
                } else {
                    $control = true;
                }
            }

            if(!$control) {
                foreach($array as $value) {
                    $this->LoadDay($value, $keeper->getId());
                }
                $this->ShowListView("Days added successfully", "success");
            } else {
                $this->ShowAddView("Some of the dates already exist");
            }
        }

        private function LoadDay($date, $keeperId) {
            $day = new Day();
            $day->setDate(date("d-m-Y", $date));
            $day->setKeeperId($keeperId);
            // Por defecto esta disponible
            $day->setIsAvailable(true);

            $this->dayDAO->Add($day);
        }

        private function ExistDate($date, $keeperId) {
            $rta = false;
            $dayList = $this->dayDAO->GetListByKeeper($keeperId);

            foreach($dayList as $day) {
                if(strcmp($day->getDate(), date("d-m-Y", $date)) == 0) {
                    $rta = true;
                }
            }

            return $rta;
        }

        public function NotAvailable($id) {
            require_once(VIEWS_PATH . "validate-session.php");
            if($id != null) {
                $day = $this->dayDAO->GetById($id);
                $day->setIsAvailable(false);

                $this->dayDAO->Modify($day);
                $this->ShowListView("Successfully", "success");
            } else {
                $this->ShowListView("There was an error trying to not available the day");
            }
        }
    }
?>