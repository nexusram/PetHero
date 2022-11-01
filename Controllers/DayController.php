<?php

    namespace Controllers;

    use DAO\DayDAO;
    use DAO\KeeperDAO;
    use Models\Day;

    class DayController {
        private $dayDAO;

        public function __construct() {
            $this->dayDAO = new DayDAO();
        }

        public function ShowListView($message="", $type="") {
            require_once(VIEWS_PATH . "validate-session.php");

            $keeperDAO = new KeeperDAO();
            $keeper = $keeperDAO->GetByUserId($_SESSION["loggedUser"]->getId());
            $dayList = $this->dayDAO->GetActiveListByKeeper($keeper->getId());

            require_once(VIEWS_PATH . "list-day.php");
        }

        public function ShowAddView($message="", $type="") {
            require_once(VIEWS_PATH . "validate-session.php");
            require_once(VIEWS_PATH . "add-day.php");
        }

        public function Add($startDate, $endDate) {
            $keeperDAO = new KeeperDAO();
            $keeper = $keeperDAO->GetByUserId($_SESSION["loggedUser"]->getId());
            
            $startDate = strtotime($startDate);
            $endDate = strtotime($endDate);

            for($i = $startDate; $i <= $endDate; $i+=86400) {
                $day = new Day();
                $day->setDate(date("d-m-Y", $i));
                $day->setKeeper($keeper);
                // Por defecto esta disponible
                $day->setIsAvailable(true);

                $this->dayDAO->Add($day);
            }

            $this->ShowListView();
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