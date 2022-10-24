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

            $petList = $this->petDAO->GetPetsOfUser($_SESSION["loggedUser"]->getId());
            require_once(VIEWS_PATH . "pet-list.php");
        }

        public function ShowAddView($message="", $type="") {
            require_once(VIEWS_PATH . "validate-session.php");
            require_once(VIEWS_PATH . "add-pet.php");
        }

        public function ShowModifyView($id, $message="", $type="") {
            require_once(VIEWS_PATH . "validate-session.php");
            $pet = $this->petDAO->GetPetById($id);
            require_once(VIEWS_PATH . "modify-pet.php");
        }

        public function Add($name, $petTypeId, $breed, $specie, $observation) {
            require_once(VIEWS_PATH . "validate-session.php");

            $userId = $_SESSION["loggedUser"]->getId();

            if(!($this->petDAO->Exist($userId, $name))) {
                $pet = new Pet();

                $pet->setUserId($userId);
                $pet->setName($name);
                $pet->setPetTypeId($petTypeId);
                $pet->setBreed($breed);
                $pet->setSpecie($specie);
                $pet->setObservation($observation);

                $this->petDAO->Add($pet);

                $this->ShowPetListView("Se añadio a " . $name . " de forma correcta!", "success");
            } else {
                $this->ShowAddView("La mascota que intenta ingresar, ya existe");
            }
        }

        public function Remove($id) {
            require_once(VIEWS_PATH . "validate-session.php");
            if($id != null) {
                $this->petDAO->Remove($id);

                $this->ShowPetListView("Eliminado con exito", "success");
            } else {
                $this->ShowPetListView("Hubo un error al intentar eliminar la mascota");
            }
        }

        public function Modify($id, $name, $petTypeId, $breed, $specie, $observation) {
            require_once(VIEWS_PATH . "validate-session.php");
            $userId = $_SESSION["loggedUser"]->getId();

            if($this->petDAO->GetPetById($id) != null) {
                $pet  = new Pet();
                $pet->setId($id);
                $pet->setUserId($userId);
                $pet->setName($name);
                $pet->setPetTypeId($petTypeId);
                $pet->setBreed($breed);
                $pet->setSpecie($specie);
                $pet->setObservation($observation);

                $this->petDAO->Modify($pet);

                $this->ShowPetListView("Se modifico de forma exitosa", "success");
            }
        }

        public function UploadPhoto($id, $photo) {
            require_once(VIEWS_PATH . "validate-session.php");
            $pet = $this->petDAO->GetPetById($id);

            if($pet) {
                $file = $this->utilities->UploadImage($photo, "pet", "photo");
                $pet->setPhoto(base64_encode($file));

                $this->petDAO->Modify($pet);
            }
        }
    }
?>