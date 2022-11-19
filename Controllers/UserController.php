<?php

    namespace Controllers;

    use DAO\KeeperDAO;
    use DAO\UserDAO;

    class UserController {
        private $userDAO;

        public function __construct() {
            $this->userDAO = new UserDAO();
        }
        
        public function ShowProfileView() {
            require_once(VIEWS_PATH . "validate-session.php");
            $user = $_SESSION["loggedUser"];
            $keeperDAO = new KeeperDAO();
            $keeper = $keeperDAO->GetByUserId($user->getId());
            require_once(VIEWS_PATH . "profile-user.php");
        }

        public function ShowUpdateView() {
            require_once(VIEWS_PATH . "validate-session.php");
            require_once(VIEWS_PATH . "update-profile.php");
        }

        public function ShowContactView($id="") {
            require_once(VIEWS_PATH . "validate-session.php");
            $user = $this->userDAO->GetById($id);
            require_once(VIEWS_PATH . "contact.php");
        }

        public function Update($name, $surname, $birthday, $cellphone, $address) {
            require_once(VIEWS_PATH . "validate-session.php");

            $user = $this->userDAO->GetByUserName($_SESSION["loggedUser"]->getUserName());

            if($user) {
                $user->setName($name);
                $user->setSurname($surname);
                $user->setBirthDay($birthday);
                $user->setCellphone($cellphone);
                $user->setAddress($address);

                $this->userDAO->Modify($user);
                $_SESSION["loggedUser"] = $user;

                $this->ShowProfileView("Update exitoso", "success");
            }
        }
    }
