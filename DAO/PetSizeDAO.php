<?php

    namespace DAO;

use Models\PetSize;

    class PetSizeDAO implements IPetSizeDAO{ 
        private $fileName = ROOT . "/Data/petsizes.json";
        private $petSizeList = array();

        public function Add(PetSize $petSize) {
            $this->RetrieveData();

            $petSize->setId($this->GetNextId());

            array_push($this->petSizeList, $petSize);

            $this->SaveData();
        }

        public function Remove($id) {
            $this->RetrieveData();

            $this->petSizeList = array_filter($this->petSizeList, function($petSize) use($id) {
                return $petSize->getId() != $id;
            });

            $this->SaveData();
        }

        public function GetAll() {
            $this->RetrieveData();

            return $this->petSizeList;
        }

        public function GetById($id) {
            $this->RetrieveData();

            $array = array_filter($this->petSizeList, function($petSize) use($id) {
                return $petSize->getId() == $id;
            });

            $array = array_values($array);

            return (count($array) > 0) ? $array[0] : null;
        }

        private function SaveData() {
            sort($this->petSizeList);
            $arrayEncode = array();

            foreach($this->petSizeList as $petSize) {
                $value["id"] = $petSize->getId();
                $value["name"] = $petSize->getName();

                array_push($arrayEncode, $value);
            }
            $jsonContent = json_encode($arrayEncode, JSON_PRETTY_PRINT);
            file_put_contents($this->fileName, $jsonContent);
        }

        private function RetrieveData() {
            $this->petSizeList= array();

            if(file_exists($this->fileName)) {
                $jsonContent = file_get_contents($this->fileName);
                $arrayDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

                foreach($arrayDecode as $value) {
                    $petSize = new PetSize();
                    $petSize->setId($value["id"]);
                    $petSize->setName($value["name"]);

                    array_push($this->petSizeList, $petSize);
                }
            }
        }

        private function GetNextId() {
            $id = 0;

            foreach($this->petSizeList as $petSize) {
                $id = ($petSize->getId() > $id) ? $petSize->getId() : $id;
            }

            return $id + 1;
        }
    }
?>