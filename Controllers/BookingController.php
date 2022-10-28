<?
    namespace Controllers;

    use DAO\BookingDAO as BookingDAO;
    use Models\Booking as Booking;

    class BookingController{
        private $bookingDAO;

        public function __construct()
        {
            $bookingDAO = new BookingDAO();
        }


        //vista de Add
        public function ShowAddView(){
            require_once(VIEWS_PATH."validate-session.php");

            require_once(VIEWS_PATH."add-booking");
        }

        ///public function Add()
    }
?>