<?php

    namespace DAO;

    use Models\Pet;

    class PetDAO implements IPetDAO {
        private $fileName = ROOT . "/Data/pets.json";
        private $petList = array();

        public function Add(Pet $pet) {
            $this->RetrieveData();

            $pet->setId($this->GetNextId());

            array_push($this->petList, $pet);

            $this->SaveData();
        }

        public function Remove($id) {
            $this->RetrieveData();

            $this->petList = array_filter($this->petList, function($pet) use($id) {
                return $pet->getId() != $id;
            });

            $this->SaveData();
        }

        public function Modify(Pet $pet) {
            $this->RetrieveData();

            $this->Remove($pet->getId());

            array_push($this->petList, $pet);

            $this->SaveData();
        }

        public function GetAll() {
            $this->RetrieveData();

            return $this->petList;
        }

        public function SaveData() {
            sort($this->petList);
            $arrayEncode = array();

            foreach($this->petList as $pet) {
                $value["id"] = $pet->getId();
                $value["userId"] = $pet->getuserId();
                $value["name"] = $pet->getName();
                $value["photo"] = $pet->getPhoto();
                $value["petTypeId"] = $pet->getPetTypeId();
                $value["breed"] = $pet->getBreed();
                $value["video"] = $pet->getVideo();
                $value["vacunationPlanPhoto"] = $pet->getVacunationPlanPhoto();
                $value["vacunationObservation"] = $pet->getVacunationObservation();
                $value["datails"] = $pet->getDetails();

                array_push($arrayEncode, $value);
            }
            $jsonContent = json_encode($arrayEncode, JSON_PRETTY_PRINT);
            file_put_contents($this->fileName, $jsonContent);
        }

        public function RetrieveData() {
            $this->users = array();

            if(file_exists($this->fileName)) {
                $jsonContent = file_get_contents($this->fileName);
                $arrayDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

                foreach($arrayDecode as $value) {
                    $pet = new Pet();
                    $pet->setId($value["id"]);
                    $pet->setUserId($value["userId"]);
                    $pet->setName($value["name"]);
                    $pet->setPhoto($value["photo"]);
                    $pet->setPetTypeId($value["petTypeId"]);
                    $pet->setBreed($value["breed"]);
                    $pet->setVideo($value["video"]);
                    $pet->setVacunationPlanPhoto($value["vacunationPlanPhoto"]);
                    $pet->setVacunationObservation($value["vacunationObservation"]);
                    $pet->setDetails($value["datails"]);
                    
                    array_push($this->petList, $pet);
                }
            }
        }

        private function GetNextId() {
            $id = 0;

            foreach($this->petList as $pet) {
                $id = ($pet->getId() > $id) ? $pet->getId() : $id;
            }

            return $id + 1;
        }
    }
?>