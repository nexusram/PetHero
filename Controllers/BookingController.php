<?
    namespace Controllers;

    use DAO\BookingDAO as BookingDAO;
    use DAO\PetDAO as PetDAO;
    use Models\Booking as Booking;

    class BookingController{
        private $bookingDAO;

        public function __construct()
        {
            $this->bookingDAO = new BookingDAO();
        }


        //vista de Add
        public function ShowAddView(){
            require_once(VIEWS_PATH."validate-session.php");

            ///$petDAO = new PetDAO();
            ///$petList = $petDAO->GetActivePetsOfUser();
            require_once(VIEWS_PATH."add-booking");
        }
        public function ShowAddFilterView($idOwner){
            require_once(VIEWS_PATH."validate-session.php");
               //pasar Id user  
            $petDAO = new PetDAO();
            $petList = $petDAO->GetActivePetsOfUser();
            require_once(VIEWS_PATH."add-booking");
        }

        ///public function Add()
    }
?>