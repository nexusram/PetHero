<?php
    namespace Controllers;
use Models\Chat;
use DAO\ChatDAO;

    class ChatController{
        private $chatDAO;

        public function __construct()
        {
            $this->chatDAO = new ChatDAO();
        }

        public function ShowChatsView(){
            require_once(VIEWS_PATH. "validate-session.php");
            echo 'Entre';
            $chatList = $this->chatDAO->GetUserChats($_SESSION["loggedUser"]->getId());

            require_once(VIEWS_PATH. "chats.php");
        }

        public function ActiveChat($reciever_user_id, $message){
            require_once(VIEWS_PATH. "validate-session.php");
            $chat = new Chat();

            $chat->setMessenger_user_id($_SESSION["loggedUser"]);
            $chat->setReciever_user_id($reciever_user_id);
            $chat->setMessage($message);

            $chat->setStatus(1);

            $this->chatDAO->Add($chat);
        }

        public function Add($reciever_user_id, $message){
            require_once(VIEWS_PATH. "validate-session.php");
            $chat = new Chat();

            $chat->setMessenger_user_id($_SESSION["loggedUser"]);
            $chat->setReciever_user_id($reciever_user_id);
            $chat->setMessage($message);

            $chat->setStatus(1);

            $this->chatDAO->Add($chat);
            require_once(VIEWS_PATH."chat-mensajes.php");
        }



    }
?>