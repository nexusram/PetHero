<?php

namespace Controllers;

use DAO\KeeperDAO;
use DAO\BookingDAO;
use DAO\PetDAO;
use DAO\PetSizeDAO;
use DAO\UserDAO;
use Models\Keeper;
use Models\PetSize;

class BookingController
{
    private $bookingDAO;
    private $petDAO;
    private $keeperDAO;


    public function __construct()
    {
        $this->bookingDAO = new BookingDAO();
        $this->petDAO = new PetDAO();
        $this->keeperDAO = new KeeperDAO();

    }


    // Muestra un listado de Reservas
    public function ShowListView() {
        require_once(VIEWS_PATH . "validate-session.php");
        
        $bookingList = $this->bookingDAO->GetAll();

        require_once(VIEWS_PATH . "booking-list.php");
    }

    public function ShowAddFiltersView(){
        require_once(VIEWS_PATH . "validate-session.php");
        $petList = $this->petDAO->GetActivePetsOfUser($_SESSION["loggedUser"]->getId());

        require(VIEWS_PATH . "keeper-filters.php");
    }
    
}
