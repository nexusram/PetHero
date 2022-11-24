<?php

    namespace Controllers;

use DAO\BookingDAO;
use DAO\CouponDAO;

    class CouponController {
        private $couponDAO;

        public function __construct() {
            $this->couponDAO = new CouponDAO();
        }

        public function ShowMakePaymentView($id_booking) {
            require_once(VIEWS_PATH . "validate-session.php");

            $coupon = $this->couponDAO->GetByBookingId($id_booking);

            $bookingDAO = new BookingDAO();
            $booking = $bookingDAO->GetById($id_booking);

            require_once(VIEWS_PATH . "simulator-payment.php");
        }

        public function ShowPaymentView($address="", $method="") {
            require_once(VIEWS_PATH . "validate-session.php");

            if($method != "effective") {
                $this->ShowCardPaymentView();
            } else {
                $this->ShowEffectiveView();
            }
        }

        public function ShowEffectiveView() {
            
        }

        public function ShowCardPaymentView() {
            require_once(VIEWS_PATH . "validate-session.php");
            $card = array();

            require_once(VIEWS_PATH . "card-payment.php");
        }

        public function PayWithCard() {
            require_once(VIEWS_PATH . "validate-session.php");
        }
    }
?>