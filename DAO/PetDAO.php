<?php

    namespace DAO;

    use Models\Pet;
    use DAO\PetTypeDAO;

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

        public function Exist($userId, $name) {
            $rta = false;
            $this->RetrieveData();

            foreach($this->petList as $pet) {
                if($pet->getUserId() == $userId && $pet->getName() == $name) {
                    $rta = true;
                }
            }
            return $rta;
        }

        public function GetActivePetsOfUser($userId) {
            $this->RetrieveData();

            $array = array_filter($this->petList, function($pet) use($userId) {
                return ($pet->getUserId() == $userId && $pet->getActive() == 1) ? $pet : null;
            });

            return $array;
        }

        public function GetPetById($id) {
            $this->RetrieveData();

            $array = array_filter($this->petList, function($pet) use($id) {
                return $pet->getId() == $id;
            });

            $array = array_values($array);

            return (count($array) > 0) ? $array[0] : null;
        }

        public function SaveData() {
            sort($this->petList);
            $arrayEncode = array();

            foreach($this->petList as $pet) {
                $value["id"] = $pet->getId();
                $value["userId"] = $pet->getuserId();
                $value["name"] = $pet->getName();
                $value["petType"] = $pet->getPetType()->getId();
                $value["breed"] = $pet->getBreed();
                $value["petSize"] = $pet->getPetSize()->getId();
                $value["observation"] = $pet->getObservation();
                $value["picture"] = $pet->getPicture();
                $value["vacunationPlan"] = $pet->getVacunationPlan();
                $value["video"] = $pet->getVideo();
                $value["active"] = $pet->getActive();


                array_push($arrayEncode, $value);
            }
            $jsonContent = json_encode($arrayEncode, JSON_PRETTY_PRINT);
            file_put_contents($this->fileName, $jsonContent);
        }

        public function RetrieveData() {
            $this->petList = array();

            if(file_exists($this->fileName)) {
                $jsonContent = file_get_contents($this->fileName);
                $arrayDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

                foreach($arrayDecode as $value) {
                    $pet = new Pet();
                    $pet->setId($value["id"]);
                    $pet->setUserId($value["userId"]);
                    $pet->setName($value["name"]);
                    $pet->setBreed($value["breed"]);
                    $pet->setObservation($value["observation"]);
                    $pet->setPicture($value["picture"]);
                    $pet->setVacunationPlan($value["vacunationPlan"]);
                    $pet->setVideo($value["video"]);
                    $pet->setActive($value["active"]);

                    // Set petType and petSize

                    $petTypeDAO = new PetTypeDAO();
                    $petType = $petTypeDAO->GetById($value["petType"]);
                    $pet->setPetType($petType);

                    $petSizeDAO = new PetSizeDAO();
                    $petSize = $petSizeDAO->GetById($value["petSize"]);
                    $pet->setPetSize($petSize);
                    
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