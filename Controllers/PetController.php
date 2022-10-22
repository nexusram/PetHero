<?php

    namespace Controllers;

    use DAO\PetDAO;
    use Others\Utilities;
    use Models\Pet;

    class PetController {
        private $utilities;
        private $petDAO;

        public function __construct() {
            $this->utilities = new Utilities();
            $this->petDAO = new PetDAO();
        }

        public function ShowPetListView($message="", $type="") {
            require_once(VIEWS_PATH . "validate-session.php");
            require_once(VIEWS_PATH . "pet-list.php");
        }

        public function ShowAddView($message="", $type="") {
            require_once(VIEWS_PATH . "validate-session.php");
            require_once(VIEWS_PATH . "add-pet.php");
        }

        public function Add($name, $petTypeId, $breed, $observation) {
            $userId = $_SESSION["loggedUser"]->getId();

            if(!($this->petDAO->Exist($userId, $name))) {
                $pet = new Pet();

                $pet->setUserId($userId);
                $pet->setName($name);
                $pet->setPetTypeId($petTypeId);
                $pet->setBreed($breed);
                $pet->setObservation($observation);

                $this->petDAO->Add($pet);

                $this->ShowPetListView("Se añadio a " . $name . " de forma correcta!", "success");
            } else {
                $this->ShowAddView("La mascota que intenta ingresar, ya existe");
            }
        }
    }
?>