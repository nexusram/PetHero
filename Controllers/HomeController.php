<?php

namespace Controllers;

use DAO\UserDAO;
use Models\User as User;
use Others\Utilities;
use Controllers\MailController;
use DAO\KeeperDAO;

class HomeController
{
    private $utilities;
    private $userDAO;
    private $keeperDAO;

    public function __construct()
    {
        $this->utilities = new Utilities();
        $this->userDAO = new UserDAO();
        $this->keeperDAO = new KeeperDAO();
    }
    //check if the session is started, if it is started you will see the welcome view if not the login to start
    public function Index($message = "")
    {
        if (isset($_SESSION["loggedUser"])) {
            $this->ShowWelcomeView();
        } else if (!isset($_SESSION["loggedUser"])) {
            $this->ShowLoginView($message);
        }
    }
    //view to login
    public function ShowLoginView($message = "")
    {
        require_once(VIEWS_PATH . "login.php");
    }
    //view to welcome,in this it shows us the username
    public function ShowWelcomeView($message = "")
    {
        $this->ShowValidateSessionView();
        $this->NavUser();
        require_once(VIEWS_PATH . "welcome.php");
    }
    //view to register a user
    public function ShowRegisterView($message = "")
    {
        require_once(VIEWS_PATH . "register.php");
    }

    /*the parameters are from the user,the parameters are from the user,the method checks that the user is not already registered in the system, that they are older than 18 and that the password is the same in both parameters, if it fails, it returns to the register view, otherwise, 
    call to method AddUserRegister for load the user in the bdd */
    public function Register($name, $surname, $birthday, $username, $password, $password_two, $email, $cellphone, $address)
    {
        if (is_null($this->userDAO->GetByUserName($username))) {
            if ($this->utilities->getYearForDate($birthday) > 18) {
                if (is_null($this->userDAO->GetByEmail($email))) {
                    if ($password === $password_two) {
                        $this->AddUserRegister($name, $surname, $birthday, $username, $password, $email, $cellphone, $address);
                        $this->Index("<div class= 'container'>
                        <div class='form-group text-center'>
                        <div class='alert alert-success mt-3'>
                                  <p>Registered user successfully</p>
                                  </div></div></div>");
                    } else {
                        $this->ShowRegisterView("<div class= 'container'>
                        <div class='form-group text-center'>
                        <div class='alert alert-danger mt-3'>
                                  <p>Passwords don't match</p>
                                  </div></div></div>");
                    }
                } else {
                    $this->ShowRegisterView("<div class= 'container'>
                    <div class='form-group text-center'>
                    <div class='alert alert-danger mt-3'>
                              <p>The email entered is being used by another</p>
                              </div></div></div>");
                }
            } else {
                $this->ShowRegisterView("<div class= 'container'>
                <div class='form-group text-center'>
                <div class='alert alert-danger mt-3'>
                          <p>You must be +18</p>
                          </div></div></div>");
            }
        } else {
            $this->ShowRegisterView("There was an error registering. Please try again");
        }
    }

    //the method is use for load the user in the bdd
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

    /*The method has as parameters the name and the password. Check that it is not empty, that it exists in the db and the password is correct
 if it passes it sends it to the welcome view, otherwise it sends it to the index */

    public function Login($userName, $password)
    {
        if ($userName != "" && $password != "") {
            $user = $this->userDAO->GetByUserName($userName);
            if (($user != null) && ($user->getPassword() === $password)) {
                $_SESSION["loggedUser"] = $user;
                $this->ShowWelcomeView();
            } else {
                $this->Index("<div class= 'container'>
                <div class='form-group text-center'>
                <div class='alert alert-danger mt-3'>
                          <p>Wrong username and/or password</p>
                          </div></div></div>");
            }
        } else {
            $this->Index("<div class= 'container'>
            <div class='form-group text-center'>
            <div class='alert alert-danger mt-3'>
                      <p>you try again</p>
                      </div></div></div>");
        }
    }

    //destroy the session and return to the index view
    public function logout()
    {
        /*session_start();*/
        session_destroy();
        $message = "<div class= 'container'>
        <div class='form-group text-center'>
        <div class='alert alert-success mt-3'>
                  <p>Session closed</p>
                  </div></div></div>";
        $this->ShowLoginView($message);
        exit();
        //header("location: ../index.php");
    }

    //view for remember pasword
    public function ShowRememberPassword($message = "")
    {
        require_once(VIEWS_PATH . "rememberPassword.php");
    }

    /*the method obtains the username and checks if it exists, if it exists it sends an email to recover the password,
     otherwise it directs it again to the remember password view*/
    public function RememberPassword($username)
    {
        $user = $this->userDAO->GetByUserName($username);
        if (!is_null($user)) {
            $mail = new MailController();
            $mail->sendMail($user->getEmail(), "I forgot my password", "your password is", $user->getPassword());
            $this->ShowLoginView("<div class= 'container'>
            <div class='form-group text-center'>
            <div class='alert alert-success mt-3'>
                      <p>Password was sent</p>
                      </div></div></div>");
        } else {
            $this->ShowRememberPassword("<div class= 'container'>
            <div class='form-group text-center'>
            <div class='alert alert-danger mt-3'>
                      <p>¡your username is not register!</p>
                      </div></div></div>");
        }
    }

    //load browser view
    public function NavUser()
    {
        $this->ShowValidateSessionView();
        $returnKeeper =  $this->keeperDAO->GetByUserId($_SESSION["loggedUser"]->getId());
        require_once(VIEWS_PATH . "nav-user.php");
    }

    //checks that the user is logged in does not load sends him to the login
    public function ShowValidateSessionView()
    {
        if (!isset($_SESSION["loggedUser"])) {
            $this->ShowLoginView("<div class= 'container'>
            <div class='form-group text-center'>
            <div class='alert alert-danger mt-3'>
                      <p>¡You must log in to access!</p>
                      </div></div></div>");
            exit();
        }
    }
}
