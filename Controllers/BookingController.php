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

    public function __construct()
    {
        $this->bookingDAO = new BookingDAO();

    }


    // Muestra un listado de Reservas
    public function ShowListView() {
        require_once(VIEWS_PATH . "validate-session.php");
        $petDAO = new PetDAO();
        $keeperDAO = new KeeperDAO();
        $bookingList = $this->bookingDAO->GetAll();

        require_once(VIEWS_PATH . "booking-list.php");
    }
    
}
