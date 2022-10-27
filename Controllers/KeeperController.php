<?php

namespace Controllers;

use DAO\KeeperDAO;
use DAO\PetSizeDAO;
use Models\Keeper;
use Models\PetSize;

class KeeperController
{
    private $keeperDAO;

    public function __construct()
    {
        $this->keeperDAO = new KeeperDAO();
    }

    public function ShowAddView()
    {
        require_once(VIEWS_PATH . "validate-session.php");

        $petSizeDAO = new PetSizeDAO();
        $petSizeList = $petSizeDAO->GetAll();

        require_once(VIEWS_PATH . "add-keeper.php");
    }

    public function ShowListView() {
        require_once(VIEWS_PATH . "validate-session.php");

        $keeperList = $this->keeperDAO->GetAll();

        require_once(VIEWS_PATH . "keeper-list.php");
    }

    public function CheckKeeper($idUser)
    {
        return $this->keeperDAO->GetById($idUser);
    }
    
    public function Add($cant, $value)
    {
        require_once(VIEWS_PATH . "validate-session.php");
        $message = "";$type = "";
        if ($value == 1) {
            $keeper = new Keeper();
            $keeper->setUser($_SESSION["loggedUser"]->getId());
            $keeper->setRemuneration($cant);
            $keeper->setPetSize($petSize = new PetSize());
            $this->listKeeper->Add($keeper);
            $message = "session de Keeper exitosa";
            $type= "success";
        }else
        {
            $message = "No se pudo crear";
        }
        $user = new UserController();
        $user->ShowProfileView($message,$type);
    }
}
