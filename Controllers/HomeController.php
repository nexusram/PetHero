<?php

namespace Controllers;

use DAO\UserDAO;
use Models\User as User;
use Others\Utilities;
use Controllers\MailController;

class HomeController
{
    private $utilities;
    private $userDAO;

    public function __construct()
    {
        $this->utilities = new Utilities();
        $this->userDAO = new UserDAO();
    }

    public function Index($message = "", $type = "")
    {
        require_once(VIEWS_PATH . "login.php");
    }

    public function ShowWelcomeView() {
        require_once(VIEWS_PATH . "validate-session.php");
        require_once(VIEWS_PATH . "welcome.php");
    }

    public function ShowRegisterView($message = "", $type = "")
    {
        require_once(VIEWS_PATH . "register.php");
    }

    public function ShowWelcomeView() {
        require_once(VIEWS_PATH . "validate-session.php");
        require_once(VIEWS_PATH . "welcome.php");
    }

    public function Register($name, $surname, $birthday, $username, $password, $password_two, $email, $cellphone, $address)
    {
        if (is_null($this->userDAO->GetByUserName($username))) {
            if ($this->utilities->getYearForDate($birthday) > 18) {
                if (is_null($this->userDAO->GetByEmail($email))) {
                    if ($password === $password_two) {
                        $this->AddUserRegister($name, $surname, $birthday, $username, $password, $email, $cellphone, $address);
                        $this->Index("Registered user successfully", "success");
                    } else {
                        $this->ShowRegisterView("Passwords don't match");
                    }
                } else {
                    $this->ShowRegisterView("The email entered is being used by another");
                }
            } else {
                $this->ShowRegisterView("You must be +18");
            }
        } else {
            $this->ShowRegisterView("There was an error registering. Please try again");
        }
    }

    public function AddUserRegister($name, $surname, $birthday, $username, $password, $email, $cellphone, $address)
    {
        $type = 1;
        if ($this->userDAO->CountUser() == 0) {
            $type = 3;
        }
        $user = new User();
        $user->setUserType($type);
        $user->setName($name);
        $user->setSurname($surname);
        $user->setBirthDay($birthday);
        $user->setUserName($username);
        $user->setPassword($password);
        $user->setEmail($email);
        $user->setCellphone($cellphone);
        $user->setAddress($address);

        $this->userDAO->Add($user);
    }

    public function Login($userName = "", $password = "")
    {

        if ($userName != "" || $password != "") {
            $user = $this->userDAO->GetByUserName($userName);
            if (($user != null) && ($user->getPassword() === $password)) {
                $_SESSION["loggedUser"] = $user;
                $this->ShowWelcomeView();
            } else {
                $this->Index("Wrong username and/or password");
            }
        } else {
            $this->Index();
        }
    }

    public function Logout()
    {
        require_once(VIEWS_PATH . "validate-session.php");
        session_destroy();
        $this->Index("session closed successfully", "success");
    }

    public function ShowRememberPassword($message = "", $type = "")
    {
        require_once(VIEWS_PATH . "rememberPassword.php");
    }

    public function RememberPassword($username)
    {
        $user = $this->userDAO->GetByUserName($username);
        if (!is_null($user)) {
            $mail = new MailController();
            $mail->sendMail($user->getEmail(), "I forgot my password", "your password is", $user->getPassword());
            $this->Index("Password was sent", "success");
        } else {
            $this->ShowRememberPassword("The name is not registered");
        }
    }
    public function Message($message = "", $type = "")
    {
        require_once(VIEWS_PATH . "message.php");
    }
}
