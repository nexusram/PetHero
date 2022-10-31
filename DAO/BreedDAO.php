<?php
    namespace Models;

    use DAO\IBreedDAO;
    use Models\Breed;

    class BreedDAO implements IBreedDAO{
        private $breedList = array();
        private $fileName = ROOT. "Data/breeds.json";

        public function Add(Breed $breed)
        {
            $this->RetrieveData();

            $breed->setId($this->GetNextId());

            array_push($this->breedList, $breed);

            $this->SaveData();
        }

        public function GetAll()
        {
            $this->RetrieveData();
            return $this->breedList;
        }

        public function Remove($id)
        {
            $this->RetrieveData();

            $this->breedList = array_filter($this->breedList, function($breed) use($id){
                return $breed->getId() != $id;
            });

            $this->SaveData();
        }

        public function GetById($id)
        {
            $this->RetrieveData();

            $arrayBreed = array_filter($this->breedList, function($breed) use($id){
                return $breed->getId() == $id;
            });

            $arrayBreed = array_values($arrayBreed);

            return (count($arrayBreed)>0) ? $arrayBreed[0] : null;
        }

        private function RetrieveData(){
            $this->breedList = array();

            if(file_exists($this->fileName)){
                $jsonContent = file_get_contents($this->fileName);

                $arrayDeCode = ($jsonContent) ? json_decode($jsonContent, true) : array();

                foreach($arrayDeCode as $value){
                    $breed = new Breed();

                    $breed->setId($value["id"]);
                    $breed->setName($value["name"]);
                    $breed->setPetType($value["petType"]);

                    array_push($this->breedList, $breed);
                }
            }
        }

        private function SaveData(){
            sort($this->breedList);
            $arrayEnCode = array();

            foreach($this->breedList as $breed){
                $value["id"] = $breed->getId();
                $value["name"] = $breed->getName();
                $value["petType"] = $breed->getPetType()->getId();

                array_push($arrayEnCode, $value);
            }

            $jsonContent = json_encode($arrayEnCode, JSON_PRETTY_PRINT);
            file_put_contents($this->fileName, $jsonContent);
        }

        private function GetNextId(){
           $id = 0;

           foreach($this->breedList as $breed){
            $id = ($breed->getId() > $id) ? $breed->getId() : $id;
           }

           return $id + 1; 
        }
    }
?>