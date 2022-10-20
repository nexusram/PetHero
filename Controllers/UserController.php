<?php

    namespace Controllers;

    use DAO\UserDAO;
    use Others\Utilities;

    class UserController {
        private $utilities;
        private $userDAO;

        public function __construct() {
            $this->utilities = new Utilities();
            $this->userDAO = new UserDAO();
        }

        public function ShowLoginView($message = "") {
            require_once(VIEWS_PATH . "login.php");
        }

        public function ShowRegisterView($message = "") {
            require_once(VIEWS_PATH . "register.php");
        }

        public function Login() {

        }

        public function Register($name, $surname, $birthdate, $username, $password, $password_two, $email, $cellphone, $address) {
            
            if(!$this->userDAO->GetByUserName($username)) {
                if($this->utilities->getYearForDates($birthdate) > 18) {
                    $this->ShowLoginView();
                } else {
                    $this->ShowRegisterView("Para poder registrarte debes ser +18");
                }

            } else {
                $this->ShowRegisterView("El usuario que se intenta registrar ya existe");
            }
        }
    }
?>