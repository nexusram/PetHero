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

    public function ShowRegisterView($message = "", $type = "")
    {
        require_once(VIEWS_PATH . "register.php");
    }

    public function Register($name, $surname, $birthday, $username, $password, $password_two, $email, $cellphone, $address)
    {
        if (!$this->userDAO->GetByUserName($username) && !$this->userDAO->GetByUsermail($username)) {
            if ($this->utilities->getYearForDate($birthday) > 18) {
                if ($password === $password_two) {
                    $this->AddUserRegister($name, $surname, $birthday, $username, $password, $email, $cellphone, $address);
                    $this->Index("Usuario registrado con exito", "success");
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
                $this->ShowPetListView();
            } else {
                $this->Index("Usuario y/o contraseña incorrecta");
            }
        } else {
            $this->Index();
        }
    }
    public function Logout()
    {
        require_once(VIEWS_PATH . "validate-session.php");
        session_destroy();
        $this->Index("session cerrada con exito", "success");
    }

    public function ShowPetListView($message = "", $type = "")
    {
        $petController = new PetController();
        $petController->ShowPetListView();
    }
    public function ShowRememberPassword($message = "", $type = "")
    {
        require_once(VIEWS_PATH . "rememberPassword.php");
    }
    public function RememberPassword($username)
    {
        if ($this->userDAO->GetByUserName($username)) {
            $mail = new MailController();
            $mail->sendMail($this->userDAO->GetByUsermail($username), "i forgot my password", "your password is", $this->userDAO->GetByUserPassword($username));
            $this->Index("Se envio la contrasenia", "success");
        } else {
            $this->ShowRememberPassword("El nombre no se encuentra registrado");
        }
    }
    public function Message($message = "", $type = "")
    {
        require_once(VIEWS_PATH . "message.php");
    }
}
