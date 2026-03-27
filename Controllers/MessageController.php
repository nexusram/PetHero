<?php

namespace Controllers;

use DAO\KeeperDAO;
use DAO\MessageDAO;
use DAO\UserDAO;
use Models\message;

class MessageController
{
    private $messageDAO;
    private $homeController;

    public function __construct()
    {
        $this->messageDAO = new MessageDAO();
        $this->homeController = new HomeController();
    }

    //check if the session is started, if it is started you will see the Show Pet view if not the login to start
    public function Index($message = "")
    {
        if (isset($_SESSION["loggedUser"])) {
            $this->homeController->ShowWelcomeView();
        } else if (!isset($_SESSION["loggedUser"])) {
            $this->homeController->ShowLoginView();
        }
    }

    //shows the chat view using the message list, the user and the keeper as parameters
    public function showChatView($messageList, $user, $keeper, $message = "")
    {

        $this->homeController->ShowValidateSessionView();
        $this->homeController->NavUser();

        require_once(VIEWS_PATH . "chat.php");
    }

    //get the messages using the user id and the keeper id, return the messages, the user and the keeper
    public function getMessage($id_user, $id_user_keeper)
    {
        $this->homeController->ShowValidateSessionView();

        $message = "";

        $userDAO = new UserDAO();
        $user = $userDAO->GetById($id_user);
        $keeperDAO = new KeeperDAO();
        $keeper = $keeperDAO->GetByUserId($id_user_keeper);
        $messageList = $this->messageDAO->GetByUser($user->getId(), $keeper->getId());

        if (empty($messageList)) {
            $message = "<div class= 'container'>
            <div class='form-group text-center'>
           <div class='alert alert-warning mt-3'>
          <p>Sorry, Sorry, chat empty</p>
          </div></div></div>";
        }
        $this->showChatView($messageList, $user, $keeper, $message);
    }

    //save a message, use as parameters the author, the user id, the keeper id and the message
    public function setMessage($author, $id_user, $id_user_keeper, $messageSend)
    {
        $this->homeController->ShowValidateSessionView();

        $messageAux = new message();

        $userDAO = new UserDAO();
        $user = $userDAO->GetById($id_user);

        $keeperDAO = new KeeperDAO();
        $keeper = $keeperDAO->GetByUserId($id_user_keeper);

        $messageAux->setUser($user);
        $messageAux->setKeeper($keeper);
        $messageAux->setAuthor($author);
        $messageAux->setMessage($messageSend);

        $this->messageDAO->Add($messageAux);
        $this->getMessage($id_user,$id_user_keeper);
    }
}
