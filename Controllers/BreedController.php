<?php

    namespace Controllers;

    use DAO\BreedDAO;

    class BreedController {
        private $breedDAO;

        public function __construct() {
            $this->breedDAO = new BreedDAO();
        }

        public function GetListByPetType($petType) {
            return $this->breedDAO->GetListByPetType($petType);
        }
    }
?>