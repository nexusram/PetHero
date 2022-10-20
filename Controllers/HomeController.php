<?php

    namespace Controllers;

    class HomeController {
        
        public function Index($message = "") {
            $userController = new UserController();
            require_once(VIEWS_PATH . "login.php");
        }  
    }
?>