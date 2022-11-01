<?php

    namespace Controllers;

    use DAO\PetDAO;
    use DAO\PetSizeDAO;
    use DAO\PetTypeDAO;
    use Exception;
    use Models\Pet;
    use Models\PetSize;
    use Models\PetType;

    class PetController {
        private $petDAO;

        public function __construct() {
            $this->petDAO = new PetDAO();
        }
        public function ShowPetListView($message="", $type="") {
            require_once(VIEWS_PATH . "validate-session.php");

            $petList = $this->petDAO->GetActivePetsOfUser($_SESSION["loggedUser"]->getId());

            require_once(VIEWS_PATH . "pet-list.php");
        }

        public function ShowAddView($message="", $type="") {
            require_once(VIEWS_PATH . "validate-session.php");
            $petTypeDAO = new PetTypeDAO();
            $petTypeList = $petTypeDAO->GetAll();

            $petSizeDAO = new PetSizeDAO();
            $petSizeList = $petSizeDAO->GetAll();
            require_once(VIEWS_PATH . "add-pet.php");
        }

        public function ShowModifyView($id="", $message="", $type="") {
            require_once(VIEWS_PATH . "validate-session.php");
            $petTypeDAO = new PetTypeDAO();
            $petTypeList = $petTypeDAO->GetAll();

            $petSizeDAO = new PetSizeDAO();
            $petSizeList = $petSizeDAO->GetAll();

            $pet = $this->petDAO->GetPetById($id);
            require_once(VIEWS_PATH . "modify-pet.php");
        }

        // Añade un pet
        public function Add($name="", $petType="", $breed="", $petSize="", $observation="", $picture="", $vacunationPlan="", $video="") {
            // Comprobamos si existe una session, caso contrario te redirije al Index()
            require_once(VIEWS_PATH . "validate-session.php");

            // Guardamos el id del user para mas tarde setearlo al pet.
            $user = $_SESSION["loggedUser"];

            // Comprobamos que el pet que se desea agregar no exista(lo hacemos comparando el nombre y el id del usuario, ya que puede existir otro usuario con una mascota del mismo nombre)
            if(!($this->petDAO->Exist($user->getId(), $name))) {
                // Si no existe, instanciamos un pet y lo seteamos
                $pet = new Pet();

                $pet->setUser($user);
                $pet->setName($name);

                $petTypeObj = new PetType();
                $petTypeObj->setId(intval($petType));
                $pet->setPetType($petTypeObj);

                $pet->setBreed($breed);

                $petSizeObj = new PetSize();
                $petSizeObj->setId(intval($petSize));
                $pet->setPetSize($petSizeObj);

                $pet->setObservation($observation);
                //Por defecto es 1, significa que esta activo
                $pet->setActive(1);

                // Add images and video
                if($this->ValidateImage($picture) && $this->ValidateImage($vacunationPlan)) {
                    $pet->setPicture($this->Upload($picture));
                    $pet->setVacunationPlan($this->Upload($vacunationPlan));

                    if($video["name"] == "") {
                        $this->petDAO->Add($pet);
                        $this->ShowPetListView("The pet " . $pet->getName() . " has add successfully", "success");
                    } else {
                        if($this->ValidateVideo($video)) {
                            $pet->setVideo($this->Upload($video));
                            $this->petDAO->Add($pet);
                            $this->ShowPetListView("The pet " . $pet->getName() . " has add successfully", "success");
                        } else {
                            $this->ShowAddView("ERROR<br>The extension or the size of the video is not correct.<br>Compatible formats: .mp4, .mkv, .mov and .avi");
                        }
                    }
                } else {
                    $this->ShowAddView("ERROR<br>The extension or the size of the image(s) is not correct.<br>Compatible formats: .jpg .jpeg, .gif and .png");
                }
            } else {
                // Si la mascota ya existe se arroja este mensaje por pantalla;
                $this->ShowAddView("ERROR<br>The pet already exists, try again");
            }
        }
        
        // Hace que un pet este inactivo
        public function Unsubscribe($id) {
            // Comprobamos si existe una session, caso contrario te redirije al Index()
            require_once(VIEWS_PATH . "validate-session.php");
            // Comprobamos que la id recibida no sea nula
            if($id != null) {
                $pet = $this->petDAO->GetPetById($id); // Traemos el pet
                $pet->setActive(0); // cambiamos el valor del atributo active a 0

                $this->petDAO->Modify($pet); // usamos el Modify del Dao
                $this->ShowPetListView("Successfully unsubscribed", "success");
            } else {
                $this->ShowPetListView("There was an error trying to unsubscribe the pet");
            }
        }
/*
        public function Modify($id="", $name="", $petType="", $breed="", $petSize="", $observation="", $picture="", $vacunationPlan="", $video="") {
            require_once(VIEWS_PATH . "validate-session.php");

            $control = true;

            $pet = $this->petDAO->GetPetById(intval($id));

            if($pet != null) {

                $pet->setName($name);

                $petTypeObj = new PetType();
                $petTypeObj->setId(intval($petType));
                $pet->setPetType($petTypeObj);

                $pet->setBreed($breed);

                $petSizeObj = new PetSize();
                $petSizeObj->setId(intval($petSize));
                $pet->setPetSize($petSizeObj);

                $pet->setObservation($observation);
                //Por defecto es 1, significa que esta activo

                // Comprobamos que los archivos lleguen

                if($picture["name"] != "") {
                    if($this->ValidateImage($picture)) {
                        unlink(base64_decode($pet->getPicture()));
                        $pet->setPicture($this->Upload($picture));
                    } else{ 
                        $this->ShowModifyView($pet->getId(), "ERROR<br>The extension or the size of the image(s) is not correct.<br>Compatible formats: .jpg .jpeg, .gif and .png");
                    }
                }
                if($vacunationPlan["name"] != "") {
                    if($this->ValidateImage($vacunationPlan)) {
                        unlink(base64_decode($pet->getVacunationPlan()));
                        $pet->setVacunationPlan($this->Upload($vacunationPlan));
                    }
                    else {
                        $this->ShowModifyView($pet->getId(), "ERROR<br>The extension or the size of the image(s) is not correct.<br>Compatible formats: .jpg .jpeg, .gif and .png");
                    }
                }
                if($video["name"] != "") {
                    if($this->ValidateVideo($video)) {
                        unlink(base64_decode($pet->getVideo()));
                        $pet->setVideo($this->Upload($video));
                    } else {
                        $this->ShowModifyView($pet->getId(), "ERROR<br>The extension or the size of the video is not correct.<br>Compatible formats: .mp4, .mkv, .mov and .avi");
                    }
                }
                
                if($control) {
                    $this->petDAO->Modify($pet);
                    $this->ShowPetListView("Successfully modified", "success");
                }
            } else {
                $this->ShowPetListView("There was an error trying to modify the pet");
            }
        }
*/
        private function ValidateImage($image) {
            $type = $image["type"];
            $size = $image["size"];

            $rta = false;
            if (((strpos($type, "gif") || strpos($type, "jpeg") || strpos($type, "jpg") || strpos($type, "png")) && ($size < 200000000))) {
                $rta = true;
            }
            return $rta;
        }

        private function ValidateVideo($video) {
            $type = $video["type"];
            $size = $video["size"];

            $rta = false;
            if (((strpos($type, "mp4") || strpos($type, "mkv") || strpos($type, "mov") || strpos($type, "avi")) && ($size < 200000000))) {
                $rta = true;
            }
            return $rta;
        }

        private function DeleteFile($filePath) {
            return unlink($filePath);
        }

        private function Upload($file) {
            try {
                $time = time();
                $fileName = $time . "-" . $file["name"];
                $tempFileName = $file["tmp_name"];

                $filePath = UPLOADS_PATH . basename($fileName);

                if(move_uploaded_file($tempFileName, $filePath)) {
                    chmod($filePath,0777);
                }
            } catch(Exception $ex) {
                $this->ShowPetListView($ex->getMessage());
            }

            return base64_encode($filePath);
        }
    }
?>