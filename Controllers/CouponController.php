<?php

namespace Controllers;

use DAO\BookingDAO;
use DAO\CouponDAO;

class CouponController
{
    private $couponDAO;
    private $homeController;

    public function __construct()
    {
        $this->couponDAO = new CouponDAO();
        $this->homeController = new HomeController();
    }

     //check if the session is started, if it is started you will see the welcome view if not the login to start/ 
    public function Index($message = "")
    {
        if (isset($_SESSION["loggedUser"])) {
            $this->homeController->ShowWelcomeView();
        } else if (!isset($_SESSION["loggedUser"])) {
            $this->homeController->ShowLoginView();
        }
    }
    
    //show the view to simulate a payment, using the booking id find the invoice
    public function ShowMakePaymentView($id_booking)
    {
        $this->homeController->ShowValidateSessionView();
        $this->homeController->NavUser();
        $coupon = $this->couponDAO->GetByBookingId($id_booking);
        $listEmpty = "";
        $bookingDAO = new BookingDAO();
        $booking = $bookingDAO->GetById($id_booking);
        if (empty($bookingList)) {
            $listEmpty = "<div class= 'container'>
           <div class='form-group text-center'>
           <div class='alert alert-danger mt-3'>
          <p>Sorry, currently we do not have booking available at the moment</p>
          </div></div></div>";
        }
        require_once(VIEWS_PATH . "simulator-payment.php");
    }

    //shows the payment method view, it has the booking id, method and address as parameters
    public function ShowPaymentView($bookingId, $address = "", $method = "")
    {
        $this->homeController->ShowValidateSessionView();

        if ($method != "effective") {
            $this->ShowCardPaymentView($bookingId);
        } else {
            $this->ShowEffectiveView($bookingId);
        }
    }

    //show payment results view
    public function ShowPaymentResult($message = "")
    {
        $this->homeController->ShowValidateSessionView();
        $this->homeController->NavUser();

        require_once(VIEWS_PATH . "payment-result.php");
    }

    //create the ticket to be sent by mail, using booking id as parameter
    public function ShowEffectiveView($bookingId)
    {
        $this->homeController->ShowValidateSessionView();

        $this->ShowPaymentResult("<div class= 'container'>
            <div class='form-group text-center'>
            <div class='alert alert-success mt-3'>
                      <p>The coupon has been sent to your email.
                      Means enabled to pay: Pago facil, Rapipago y Ripsa</p>
                      </div></div></div>");
        $mailcontroller = new MailController();
        $bookingDAO = new BookingDAO();
        $booking = $bookingDAO->GetById($bookingId);
        $code = rand(1, 500000000);

        $namePet = $booking->getPet()->getName();
        $nameKeeper = $booking->getKeeper()->getUser()->getName();
        $nameKeeperLast = $booking->getKeeper()->getUser()->getSurname();

        $total = $booking->getTotal();
        $mailcontroller->sendMail($_SESSION["loggedUser"]->getEMail(), "Coupon-PetHero-$namePet", "
            <div>
            <h1>BOOKING COUPON</h1>

            <p><strong>Pet: </strong> $namePet</p>
            <br>
            <p><strong>Keeper: </strong>$nameKeeper $nameKeeperLast</p>
            <br>
            </div>
            ", "
            <div>
            <p><strong>Total: </strong> $total</p>
            <br>
            <p><strong>Code: </strong> $code</p>
            <br>
            <p><strong>Present this code in the payment entity</strong></p>
            </div>");
    }

    //shows the card payment view, using the booking id
    public function ShowCardPaymentView($bookingId, $message = "")
    {
        $this->homeController->ShowValidateSessionView();
        $this->homeController->NavUser();

        require_once(VIEWS_PATH . "card-payment.php");
    }

    //Create the ticket to be sent by mail, paid with credit card, as parameters bookingId, numbers, type_card, expiration, cvc, name and ID
    public function PayWithCard($bookingId, $numbers, $type_card, $expiration, $cvc, $name, $dni, $message = "")
    {
        $this->homeController->ShowValidateSessionView();
        $expiration = date(FORMAT_DATE, strtotime($expiration));

        $card = array();
        $card["numbers"] = $numbers;
        $card["type"] = $type_card;
        $card["expiration"] = $expiration;
        $card["cvc"] = $cvc;
        $card["title"] = $name;
        $card["ide"] = $dni;

        if ($card["expiration"] < date(FORMAT_DATE)) {
            $this->ShowCardPaymentView($bookingId,"<div class= 'container'>
            <div class='form-group text-center'>
            <div class='alert alert-success mt-3'>
                      <p>Your card has expired</p>
                      </div></div></div>");
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

            $mailcontroller->sendMail($_SESSION["loggedUser"]->getEMail(), "Coupon-PetHero-$namePet", "
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
                ", "
                <div>
                <p><strong>Total: </strong> $total</p>
                </div>");

            $this->ShowPaymentResult("<div class= 'container'>
            <div class='form-group text-center'>
            <div class='alert alert-success mt-3'>
                      <p>Your payment has been made successfully. The invoice has been sent to your email</p>
                      </div></div></div>");
        }
    }
}
