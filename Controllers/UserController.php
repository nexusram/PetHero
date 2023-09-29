<?php

namespace Controllers;

use DAO\KeeperDAO;
use DAO\UserDAO;

class UserController
{
    private $userDAO;
    private $homeController;

    public function __construct()
    {
        $this->userDAO = new UserDAO();
        $this->homeController = new HomeController();
    }

    //check if the session is started, if it is started you will see Show Profile if not the login to start
    public function Index($message = "")
    {
        if (isset($_SESSION["loggedUser"])) {
            $this->ShowProfileView($message);
        } else if (!isset($_SESSION["loggedUser"])) {
            $this->homeController->ShowLoginView();
        }
    }

    //displays the user's profile view, looking for the keeper and the user
    public function ShowProfileView($message = "")
    {

        $this->homeController->ShowValidateSessionView();
        $this->homeController->NavUser();

        $keeperDAO = new KeeperDAO();
        $keeper = $keeperDAO->GetByUserId($_SESSION["loggedUser"]->getId());

        $userDAO = new UserDAO();
        $user =  $userDAO->GetById($_SESSION["loggedUser"]->getId());

        require_once(VIEWS_PATH . "profile-user.php");
    }

    //view to update user profile
    public function ShowUpdateView()
    {

        $this->homeController->ShowValidateSessionView();
        $this->homeController->NavUser();

        require_once(VIEWS_PATH . "update-profile.php");
    }

    //returns a user looking for it by id
    public function ShowContactView($id = "")
    {

        $this->homeController->ShowValidateSessionView();
        $this->homeController->NavUser();

        $user = $this->userDAO->GetById($id);
        require_once(VIEWS_PATH . "contact.php");
    }

    //update the user information using the name, username, birthday, phone and address parameters
    public function Update($name, $surname, $birthday, $cellphone, $address)
    {
        $this->homeController->ShowValidateSessionView();

        $user = $this->userDAO->GetByUserName($_SESSION["loggedUser"]->getUserName());

        if ($user) {
            $user->setName($name);
            $user->setSurname($surname);
            $user->setBirthDay($birthday);
            $user->setCellphone($cellphone);
            $user->setAddress($address);

            $this->userDAO->Modify($user);
            $_SESSION["loggedUser"] = $user;

            $this->ShowProfileView("<div class= 'container'>
            <div class='form-group text-center'>
            <div class='alert alert-success mt-3'> <p> Update exitoso</p> </div></div></div>");
        }
    }
}
