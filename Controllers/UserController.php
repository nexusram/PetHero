<?php

    namespace Controllers;

    use DAO\UserDAO;

    class UserController {
        private $userDAO;

        public function __construct() {
            $this->userDAO = new UserDAO();
        }
        public function ShowProfileView()
        {
            require_once(VIEWS_PATH . "validate-session.php");
          
            $userDAO->GetByUserName($_SESSION["loggedUser"]);
            require_once(VIEWS_PATH . "profile.php");
        }
    }
?>