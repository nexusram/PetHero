<?php

    namespace Controllers;


    class PetController {

        public function ShowPetListView() {
            require_once(VIEWS_PATH . "validate-session.php");
            require_once(VIEWS_PATH . "pet-list.php");
        }
    }
?>