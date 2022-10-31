<?php

namespace Controllers;

use DAO\KeeperDAO;
use DAO\PetSizeDAO;
use DAO\UserDAO;
use Models\Keeper;
use Models\PetSize;

class KeeperController
{
    private $keeperDAO;

    public function __construct()
    {
        $this->keeperDAO = new KeeperDAO();
    }

    // Muestra vista de add keeper
    public function ShowAddView()
    {
        require_once(VIEWS_PATH . "validate-session.php");

        $petSizeDAO = new PetSizeDAO();
        $petSizeList = $petSizeDAO->GetAll();

        $keeper = $this->CheckKeeper($_SESSION["loggedUser"]->getId());
        if($keeper) {
            if($keeper->getActive()) {
                $this->ShowListView();
            } else {
                $this->SetActive($keeper, true);
            }
        } else {
            require_once(VIEWS_PATH . "add-keeper.php");
        }
    }

    // Muestra un listado de keepers
    public function ShowListView()
    {
        require_once(VIEWS_PATH . "validate-session.php");

        $keeperList = $this->keeperDAO->GetAll();

        require_once(VIEWS_PATH . "keeper-list.php");
    }

    // Chequea que un usuario sea keeper
    public function CheckKeeper($userId)
    {
        return $this->keeperDAO->GetByUserId($userId);
    }

    // Agrega un keeper
    public function Add($remuneration, $petSize, $description)
    {
        require_once(VIEWS_PATH . "validate-session.php");

        $keeper = new Keeper();

        $userDAO = new UserDAO();
        $user = $userDAO->GetById($_SESSION["loggedUser"]->getId());

        $keeper->setUser($user);
        $keeper->setRemuneration($remuneration);

        $petSizeDAO = new PetSizeDAO();
        $petSizeObj = $petSizeDAO->GetById($petSize);

        $keeper->setPetSize($petSizeObj);
        $keeper->setDescription($description);

        $keeper->setActive(true);

        $this->keeperDAO->Add($keeper);

        $this->ShowListView();
    }

    private function SetActive(Keeper $keeper, $active) {
        require_once(VIEWS_PATH . "validate-session.php");

        $keeper->setActive($active);
        
        $this->keeperDAO->Modify($keeper);

        $this->ShowListView();
    }

    public function ReturnOwner() {
        require_once(VIEWS_PATH . "validate-session.php");
        $keeper = $this->keeperDAO->GetByUserId($_SESSION["loggedUser"]->getId());

        $keeper->setActive(false);

        $this->keeperDAO->Modify($keeper);

        $petController = new PetController();
        $petController->ShowPetListView();
    }
}
