<?php

namespace Controllers;

use DAO\KeeperDAO;
use DAO\PetSizeDAO;
use DAO\UserDAO;
use Models\Keeper;
use Others\Utilities;

class KeeperController
{
    private $keeperDAO;
    private $homeController;

    public function __construct()
    {
        $this->keeperDAO = new KeeperDAO();
        $this->homeController = new HomeController();
    }

    //check if the session is started, if it is started you will see the Show List view if not the login to start
    public function Index($message = "")
    {
        if (isset($_SESSION["loggedUser"])) {
            $this->homeController->ShowWelcomeView();
        } else if (!isset($_SESSION["loggedUser"])) {
            $this->homeController->ShowLoginView();
        }
    }

    //show the view to add a keeper
    public function ShowAddView($message = "")
    {
        $this->homeController->ShowValidateSessionView();
        //$this->homeController->NavUser();
        $listEmpty = "";
        $petSizeDAO = new PetSizeDAO();
        $petSizeList = $petSizeDAO->GetAll();
        $keeper = $this->keeperDAO->GetByUserId($_SESSION["loggedUser"]->getId());
        if ($keeper) {
            $this->SetActive($keeper, true);
        } else {
            $listEmpty = "<div class= 'container'>
               <div class='form-group text-center'>
               <div class='alert alert-danger mt-3'>
              <p>Sorry, currently we do not have user available at the moment</p>
              </div></div></div>";

            require_once(VIEWS_PATH . "add-keeper.php");
        }
    }

    //show keepers list view
    public function ShowListView($message = "")
    {
        $this->homeController->ShowValidateSessionView();
        $this->homeController->NavUser();
        $listEmpy = "";
        $utilities = new Utilities();
        $keeperList = $this->keeperDAO->GetAll();
            $listEmpy = "<div class= 'container'>
    <div class='form-group text-center'>
    <div class='alert alert-warning mt-3'>
   <p>Sorry, currently no keeper available at this time</p>
   </div></div></div>";
        require_once(VIEWS_PATH . "keeper-list.php");
    }

    //add a keeper and it takes you to the profile view, as parameters would be the renumbering, the size of the animal and description
    public function Add($remuneration, $petSize, $description)
    {
        $this->homeController->ShowValidateSessionView();

        $keeper = new Keeper();

        $userDAO = new UserDAO();
        $user = $userDAO->GetById($_SESSION["loggedUser"]->getId());

        $keeper->setUser($user);
        $keeper->setRemuneration($remuneration);

        $petSizeDAO = new PetSizeDAO();
        $petSizeObj = $petSizeDAO->GetById($petSize);

        $keeper->setPetSize($petSizeObj);
        $keeper->setDescription($description);

        $keeper->setActive(1);

        $this->keeperDAO->Add($keeper);

        $userController = new UserController();
        $message="<div class= 'container'>
        <div class='form-group text-center'>
        <div class='alert alert-success mt-3'>
       <p>Success, keeper created</p>
       </div></div></div>";
        $userController->ShowProfileView($message);
    }

    //modify a keeper and save the changes in the database, how the keeper has parameters and if it is active
    private function SetActive(Keeper $keeper, $active)
    {
        $this->homeController->ShowValidateSessionView();

        $keeper->setActive($active);

        $this->keeperDAO->Modify($keeper);

        $bookingController = new BookingController();
        $bookingController->ShowPaymentView();
    }

    //return to owner view
    public function ReturnOwner()
    {
        $this->homeController->ShowValidateSessionView();
        //$this->homeController->NavUser();
        $keeper = $this->keeperDAO->GetByUserId($_SESSION["loggedUser"]->getId());

        $keeper->setActive(0);

        $this->keeperDAO->Modify($keeper);

        $petController = new PetController();
        $petController->ShowPetListView();
    }
}
