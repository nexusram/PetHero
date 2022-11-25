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

        public function ShowPaymentView($bookingId, $address="", $method="") {
            require_once(VIEWS_PATH . "validate-session.php");

            if($method != "effective") {
                $this->ShowCardPaymentView($bookingId);
            } else {
                $this->ShowEffectiveView($bookingId);
            }
        }

        public function ShowPaymentResult($message="", $type="") {
            require_once(VIEWS_PATH . "validate-session.php");
            include_once(VIEWS_PATH . "nav-user.php");

            require_once(VIEWS_PATH . "payment-result.php");
        }

        public function ShowEffectiveView() {
            
        }

        public function ShowCardPaymentView($bookingId, $message="", $type="") {
            require_once(VIEWS_PATH . "validate-session.php");
            include_once(VIEWS_PATH . "nav-user.php");

            require_once(VIEWS_PATH . "card-payment.php");
        }

        public function PayWithCard($bookingId, $numbers, $type_card, $expiration, $cvc, $name, $dni, $message="", $type="") {
            $expiration = date(FORMAT_DATE, strtotime($expiration));

            $card = array();
            $card["numbers"] = $numbers;
            $card["type"] = $type_card;
            $card["expiration"] = $expiration;
            $card["cvc"] = $cvc;
            $card["title"] = $name;
            $card["ide"] = $dni;

            if($card["expiration"] < date(FORMAT_DATE)) {
                $this->ShowCardPaymentView("Your card has expired");
            } else {
                $couponDAO = new CouponDAO();
                $coupon = $couponDAO->GetByBookingId($bookingId);
                $bookingDAO = new BookingDAO();
                $booking = $bookingDAO->GetById($bookingId);

                $coupon->setIsPayment(1);
                $booking->setValidate(1);

                $bookingDAO->Modify($booking);
                $couponDAO->Modify($coupon);

                $this->ShowPaymentResult("Your payment has been made successfully. The invoice has been sent to your email", "success");
            }
        }
    }
