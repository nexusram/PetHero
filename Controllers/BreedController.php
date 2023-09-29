<?php

    namespace Controllers;

    use DAO\BreedDAO;

    class BreedController {
        private $breedDAO;
        private $homeController;

        public function __construct() {
            $this->breedDAO = new BreedDAO();
            $this->homeController = new HomeController();
        }
  //check if the session is started, if it is started you will see the welcome view if not the login to start/ 
        public function Index($message = "")
        {
            if (isset($_SESSION["loggedUser"])) {
                $this->homeController->ShowWelcomeView();
            } else if (!isset($_SESSION["loggedUser"])) {
                $this->homeController->ShowLoginView();
            }
        }
        //using the type of animal as a parameter, it returns the breed of the db
        public function GetListByPetType($petType) {
            $this->homeController->ShowValidateSessionView();
            return $this->breedDAO->GetListByPetType($petType);
        }
    }
?>