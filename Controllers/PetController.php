<?php

    namespace Controllers;


    class PetController {

        public function ShowPetListView($message="") {
            require_once(VIEWS_PATH . "validate-session.php");
            require_once(VIEWS_PATH . "pet-list.php");
        }

        public function ShowAddView($message="") {
            require_once(VIEWS_PATH . "validate-session.php");
            require_once(VIEWS_PATH . "add-pet.php");
        }

        public function Add($name, $petTypeId, $breed, $photo, $vacunationPlanPhoto, $vacunationObservation, $details, $video) {
            var_dump($photo);
            die;
        }

        public function UploadPhoto($photo) {

        }
    }
?>