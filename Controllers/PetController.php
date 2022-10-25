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

        public function ShowModifyView($id, $message="", $type="") {
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

            // Si todas las variables necesarias no estan vacias
            if($name != "" && $petType != "" && $breed != "" && $petSize != "" && $observation != "" && $picture != "" && $vacunationPlan != "") {
                // Guardamos el id del user para mas tarde setearlo al pet.
                $userId = $_SESSION["loggedUser"]->getId();

                // Comprobamos que el pet que se desea agregar no exista(lo hacemos comparando el nombre y el id del usuario, ya que puede existir otro usuario con una mascota del mismo nombre)
                if(!($this->petDAO->Exist($userId, $name))) {
                    // Si no existe, instanciamos un pet y lo seteamos
                    $pet = new Pet();

                    $pet->setUserId($userId);
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

                    // Add images
                    $pet->setPicture($this->UploadImage($picture));
                    $pet->setVacunationPlan($this->UploadImage($vacunationPlan));

                    // Add video
                    $pet->setVideo(null);
                    // TODO

                    // Llama la funcion Add del dao
                    $this->petDAO->Add($pet);

                    // Se envia un mensaje por pantalla.
                    $this->ShowPetListView("The pet ". $pet->getName() . " was added successfully", "success");
                } else {
                    // Si la mascota ya existe se arroja este mensaje por pantalla;
                    $this->ShowAddView("The pet already exists, try again");
                }
            } else {
                // Si alguna de las variables requeridas estan vacias, se lo envia al listado de mascotas
                $this->ShowPetListView();
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

        public function Modify($id, $name, $petType, $breed, $petSize, $observation, $picture="", $vacunationPlan="", $video="") {
            require_once(VIEWS_PATH . "validate-session.php");
            $userId = $_SESSION["loggedUser"]->getId();

            if($this->petDAO->GetPetById($id) != null) {
                $pet = new Pet();

                $pet->setId($id);
                $pet->setUserId($userId);
                $pet->setName($name);

                $petTypeObj = new PetType();
                $petTypeObj->setId(intval($petType));
                $pet->setPetType($petTypeObj);

                $pet->setBreed($breed);

                $petSizeObj = new PetSize();
                $petSizeObj->setId(intval($petSize));
                var_dump($petSizeObj);
                die;
                $pet->setPetSize($petSizeObj);

                $pet->setObservation($observation);
                //Por defecto es 1, significa que esta activo
                $pet->setActive(1);

                // Add images
                $pet->setPicture(null);
                $pet->setVacunationPlan(null);
                //Por defecto es 1, significa que esta activo

                // Add images
                /*
                if($picture != "") {
                    unlink(base64_decode($pet->getPicture()));
                    $pet->setPicture($this->UploadImage($picture));
                }
                if($vacunationPlan != "") {
                    unlink(base64_decode($pet->getVacunationPlan()));
                    $pet->setVacunationPlan($this->UploadImage($vacunationPlan));
                }
                if($video != "") {
                    unlink(base64_decode($pet->getVideo()));
                    $pet->setVideo(null);
                }*/
                var_dump($pet);
                $this->petDAO->Modify($pet);

                $this->ShowPetListView("Successfully modified", "success");
            } else {
                $this->ShowPetListView("There was an error trying to modify the pet");
            }
        }

        public function UploadImage($file) {
            $message = "";
            try {
                $time = time();
                $fileName = $time . "-" . $file["name"];
                $tempFileName = $file["tmp_name"];
                $type = $file["type"];

                $filePath = UPLOADS_PATH . basename($fileName);
                $fileType = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                $imageSize = getimagesize($tempFileName);

                if($imageSize !== false) {
                    if (move_uploaded_file($tempFileName, $filePath))
                    {
                        chmod($filePath,0777);
                    } else {
                        $message = "Ocurrió un error al intentar subir la imagen";
                    }
                } else {
                    $message = "El archivo no corresponde a una imágen";
                }
            } catch(Exception $ex) {
                $message = $ex->getMessage();
            }

            if($message != "") {
                $this->ShowAddView($message);
            }
            
            return base64_encode($filePath);
        } 
    }
?>