<?php

namespace Controllers;

use DAO\BreedDAO;
use DAO\PetDAO;
use DAO\PetSizeDAO;
use DAO\PetTypeDAO;
use Exception;
use Models\Pet;
use Models\PetSize;
use Models\PetType;

class PetController
{
    private $petDAO;
    private $homeController;

    public function __construct()
    {
        $this->petDAO = new PetDAO();
        $this->homeController = new HomeController();
    }

    //check if the session is started, if it is started you will see the Show Pet view if not the login to start
    public function Index($message = "")
    {
        if (isset($_SESSION["loggedUser"])) {
            $this->homeController->ShowWelcomeView();
        } else if (!isset($_SESSION["loggedUser"])) {
            $this->homeController->ShowLoginView();
        }
    }

    /* show the pet list view and using the user id returns a list of active animals*/
    public function ShowPetListView($message = "")
    {

        $this->homeController->ShowValidateSessionView();
        $this->homeController->NavUser();
        $listEmpty = "";
        $petList = $this->petDAO->GetActivePetsOfUser($_SESSION["loggedUser"]->getId());
        if (empty($petList)) {
            $listEmpty = "<div class= 'container'>
    <div class='form-group text-center'>
    <div class='alert alert-warning mt-3'>
   <p>Sorry, you currently have no animals entered, #add Pet</p>
   </div></div></div>";
        }
        require_once(VIEWS_PATH . "pet-list.php");
    }

    //show the add pet view and it returns the types of animals
    public function ShowAddView($message = "")
    {
        $this->homeController->ShowValidateSessionView();
        $this->homeController->NavUser();

        $petTypeDAO = new PetTypeDAO();
        $petTypeList = $petTypeDAO->GetAll();
        require_once(VIEWS_PATH . "add-pet.php");
    }

    //show the select breed view and return breeds depending on the type and size
    public function ShowSelectBreedView($name, $petType, $message = "")
    {

        $this->homeController->ShowValidateSessionView();
        $this->homeController->NavUser();

        $breedDAO = new BreedDAO();
        $breedList = $breedDAO->GetListByPetType($petType);

        $petSizeDAO = new PetSizeDAO();
        $petSizeList = $petSizeDAO->GetAll();
        require_once(VIEWS_PATH . "select-breed.php");
    }

    /* added an animal, the parameters are attributes of this.
Check that the images and videos are loaded and that the format is correct*/
    public function Add($name = "", $petType = "", $breed = "", $petSize = "", $observation = "", $picture = "", $vacunationPlan = "", $video = "")
    {

        $this->homeController->ShowValidateSessionView();
        $user = $_SESSION["loggedUser"];

        if (!($this->petDAO->Exist($user->getId(), $name))) {
            $pet = new Pet();

            $pet->setUser($user);
            $pet->setName($name);

            $petTypeObj = new PetType();
            $petTypeObj->setId(intval($petType));
            $pet->setPetType($petTypeObj);
            $breedDAO = new BreedDAO();
            
            $breed_aux = $breedDAO->GetById($breed);

            $pet->setBreed($breed_aux);
            $petSizeObj = new PetSize();
            $petSizeObj->setId(intval($petSize));
            $pet->setPetSize($petSizeObj);

            $pet->setObservation($observation);
            $pet->setActive(1);

            if ($this->ValidateImage($picture) && $this->ValidateImage($vacunationPlan)) {
                $pet->setPicture($this->Upload($picture));
                $pet->setVacunationPlan($this->Upload($vacunationPlan));

                if ($video["name"] == "") {
                    $this->petDAO->Add($pet);
                    $this->ShowPetListView("<div class= 'container'>
                        <div class='form-group text-center'>
                        <div class='alert alert-success mt-3'>
                                  <p>The pet " . $pet->getName() . " has add successfully</p>
                                  </div></div></div>");
                } else {
                    if ($this->ValidateVideo($video)) {
                        $pet->setVideo($this->Upload($video));
                        $this->petDAO->Add($pet);
                        $this->ShowPetListView("<div class= 'container'>
                            <div class='form-group text-center'>
                            <div class='alert alert-success mt-3'>
                                      <p>The pet " . $pet->getName() . " has add successfully</p>
                                      </div></div></div>");
                    } else {
                        $this->ShowAddView("<div class= 'container'>
                            <div class='form-group text-center'>
                            <div class='alert alert-danger mt-3'>
                                      <p>The extension or the size of the video is not correct.<br>Compatible formats: .mp4, .mkv, .mov and .avi</p>
                                      </div></div></div>");
                    }
                }
            } else {
                $this->ShowAddView("<div class= 'container'>
                    <div class='form-group text-center'>
                    <div class='alert alert-danger mt-3'>
              <p> ERROR<br>The extension or the size of the image(s) is not correct.<br>Compatible formats: .jpg .jpeg, .gif and .png</p> </div></div></div>");
            }
        } else {
            $this->ShowAddView("<div class= 'container'>
                <div class='form-group text-center'>
                <div class='alert alert-danger mt-3'> <p> ERROR<br>The pet already exists, try again</p> </div></div></div>");
        }
    }

    //deactivates an animal and shows me the Show Pet ListView
    public function Unsubscribe($id)
    {
        $this->homeController->ShowValidateSessionView();

        if ($id != null) {
            $pet = $this->petDAO->GetPetById($id);
            $pet->setActive(0);

            $this->petDAO->Modify($pet);
            $this->ShowPetListView("<div class= 'container'>
                <div class='form-group text-center'>
                <div class='alert alert-success mt-3'> <p> Successfully unsubscribed</p> </div></div></div>");
        } else {
            $this->ShowPetListView("<div class= 'container'>
                <div class='form-group text-center'>
                <div class='alert alert-danger mt-3'> <p> There was an error trying to unsubscribe the pet</p></div></div></div>");
        }
    }

    //Check that the format is correct
    private function ValidateImage($image)
    {
        $type = $image["type"];
        $size = $image["size"];

        $rta = false;
        if (((strpos($type, "gif") || strpos($type, "jpeg") || strpos($type, "jpg") || strpos($type, "png")) && ($size < 200000000))) {
            $rta = true;
        }
        return $rta;
    }

    //Check that the format is correct
    private function ValidateVideo($video)
    {
        $type = $video["type"];
        $size = $video["size"];

        $rta = false;
        if (((strpos($type, "mp4") || strpos($type, "mkv") || strpos($type, "mov") || strpos($type, "avi")) && ($size < 200000000))) {
            $rta = true;
        }
        return $rta;
    }

    //delete a file
    private function DeleteFile($filePath)
    {
        return unlink($filePath);
    }

    //upload a file
    private function Upload($file)
    {
        try {
            $time = time();
            $fileName = $time . "-" . $file["name"];
            $tempFileName = $file["tmp_name"];

            $filePath = UPLOADS_PATH . basename($fileName);

            if (move_uploaded_file($tempFileName, $filePath)) {
                chmod($filePath, 0777);
            }
        } catch (Exception $ex) {
            $this->ShowPetListView($ex->getMessage());
        }

        return base64_encode($filePath);
    }
}
