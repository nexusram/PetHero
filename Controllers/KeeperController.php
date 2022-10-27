<?php

namespace Controllers;

use DAO\KeeperDAO;
use Models\Keeper;

class KeeperController
{
    private $listKeeper;
    public function __construct()
    {
        $this->listKeeper = new KeeperDAO();
    }
    public function ShowKeeperListView()
    {
        require_once(VIEWS_PATH . "validate-session.php");
    }

    public function ShowAddView()
    {
        require_once(VIEWS_PATH . "validate-session.php");
    }
    public function CheckUser($idUser)
    {
        return $this->listKeeper->Seache($idUser);
    }
    public function Check()
    {
        require_once(VIEWS_PATH . "validate-keeper.php");
    }
    public function Add($cant, $value)
    {
        require_once(VIEWS_PATH . "validate-session.php");
        $message = "";$type = "";
        if ($value == 1) {
            $keeper = new Keeper();
            $keeper->setUserId($_SESSION["loggedUser"]->getId());
            $keeper->setRemuneration($cant);
            $keeper->setPetTypeId(0);
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
