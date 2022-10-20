<?php

    namespace Controllers;

    use DAO\UserDAO;
    use Models\User as User;
    use Others\Utilities;

    class HomeController {
        private $utilities;
        private $userDAO;

        public function __construct() {
            $this->utilities = new Utilities();
            $this->userDAO = new UserDAO();    
        }

        public function Index($message = "", $type = "") {
            require_once(VIEWS_PATH . "login.php");
        }

        public function ShowRegisterView($message = "", $type = "") {
            require_once(VIEWS_PATH . "register.php");
        }

        public function Register($name, $surname, $birthday, $username, $password, $password_two, $email, $cellphone, $address) {            
            
            if(!$this->userDAO->GetByUserName($username)) {
                if($this->utilities->getYearForDate($birthday) > 18) {
                    if($password === $password_two) {
                        $user = new User();
                        $user->setUserType(1);
                        $user->setName($name);
                        $user->setSurname($surname);
                        $user->setBirthDay($birthday);
                        $user->setUserName($username);
                        $user->setPassword($password);
                        $user->setEmail($email);
                        $user->setCellphone($cellphone);
                        $user->setAddress($address);
                        
                        $this->userDAO->Add($user);

                        $this->Index("Usuario registrado con exito" , "success");
                    } else {
                        $this->ShowRegisterView("La contraseñas no coinciden");
                    }
                } else {
                    $this->ShowRegisterView("Para poder registrarte debes ser +18");
                }
            } else {
                $this->ShowRegisterView("El usuario que se intenta registrar ya existe");
            }
        }
    }
?>