<?php
    namespace DAO;

    use Models\Message;

    interface IMessageDAO{
         function Add(Message $message);
        function GetByUser($userId, $keeperId);
    }
?>