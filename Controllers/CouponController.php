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

        public function ShowEffectiveView($bookingId) {
            $this->ShowPaymentResult("The coupon has been sent to your email.
            Means enabled to pay: Pago facil, Rapipago y Ripsa");
            $mailcontroller = new MailController();
            $bookingDAO = new BookingDAO();
            $booking = $bookingDAO->GetById($bookingId);
            $code = rand(1, 500000000);

            $namePet = $booking->getPet()->getName();
            $nameKeeper = $booking->getKeeper()->getUser()->getName();
            $nameKeeperLast = $booking->getKeeper()->getUser()->getSurname();

            $total = $booking->getTotal();
            $mailcontroller->sendMail($_SESSION["loggedUser"]->getEMail(),"Coupon-PetHero-$namePet", "
            <div>
            <h1>BOOKING COUPON</h1>

            <p><strong>Pet: </strong> $namePet</p>
            <br>
            <p><strong>Keeper: </strong>$nameKeeper $nameKeeperLast</p>
            <br>
            </div>
            ","
            <div>
            <p><strong>Total: </strong> $total</p>
            <br>
            <p><strong>Code: </strong> $code</p>
            <br>
            <p><strong>Present this code in the payment entity</strong></p>
            </div>");

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
                $this->ShowCardPaymentView($bookingId, "Your card has expired");
            } else {
                $couponDAO = new CouponDAO();
                $coupon = $couponDAO->GetByBookingId($bookingId);
                $bookingDAO = new BookingDAO();
                $booking = $bookingDAO->GetById($bookingId);

                $coupon->setIsPayment(1);
                $booking->setValidate(1);

                $bookingDAO->Modify($booking);
                $couponDAO->Modify($coupon);

                $mailcontroller = new MailController();
                $bookingDAO = new BookingDAO();
                $booking = $bookingDAO->GetById($bookingId);

    
                $namePet = $booking->getPet()->getName();
                $nameKeeper = $booking->getKeeper()->getUser()->getName();
                $nameKeeperLast = $booking->getKeeper()->getUser()->getSurname();
    
                $total = $booking->getTotal();

                $now = date(FORMAT_DATE);
                $cardUlt = substr($card["numbers"], 12, strlen($card["numbers"]));
                
                $addressOwner = $booking->getOwner()->getAddress();

                $mailcontroller->sendMail($_SESSION["loggedUser"]->getEMail(),"Coupon-PetHero-$namePet", "
                <div>
                <h1>Bill Booking</h1>
                <p><strong>Date: </strong>$now </p>
                <p><strong>Type Bill: </strong>B</p>
                <p><strong>Address: </strong>$addressOwner</p>
                <p><strong>Card: </strong> XXXX-XXXX-XXXX-$cardUlt</p>

                <p><strong>Pet: </strong> $namePet</p>
                <br>
                <p><strong>Keeper: </strong>$nameKeeper $nameKeeperLast</p>
                <br>
                </div>
                ","
                <div>
                <p><strong>Total: </strong> $total</p>
                </div>");
    
                $this->ShowPaymentResult("Your payment has been made successfully. The invoice has been sent to your email", "success");
            }
        }
    }
