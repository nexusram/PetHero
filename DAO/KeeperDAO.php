<?php

    namespace DAO;

    use Models\Keeper;

    class KeeperDAO implements IKeeperDAO {
        private $fileName = ROOT . "/Data/keepers.json";
        private $keeperList = array();

        public function Add(Keeper $keeper) {
            $this->RetrieveData();

            $keeper->setId($this->GetNextId());

            array_push($this->keeperList, $keeper);

            $this->SaveData();
        }

        public function Remove($id) {
            $this->RetrieveData();

            $this->keeperList = array_filter($this->keeperList, function($keeper) use($id) {
                return $keeper->getId() != $id;
            });

            $this->SaveData();
        }
        public function Seache($id) {
            $rta= false;
            $this->RetrieveData();
            foreach($this->keeperList as $keeper) {
                if($keeper->getUserId() == $id) {
                    $rta = true;
                }
            }
            return $rta;
        }
        public function Modify(Keeper $keeper) {
            $this->RetrieveData();

            $this->Remove($keeper->getId());

            array_push($this->keeperList, $keeper);

            $this->SaveData();
        }

        public function GetAll() {
            $this->RetrieveData();

            return $this->keeperList;
        }

        public function SaveData() {
            sort($this->keeperList);
            $arrayEncode = array();

            foreach($this->keeperList as $keeper) {
                $value["id"] = $keeper->getId();
                $value["userId"] = $keeper->getUserId();
                $value["petTypeId"] = $keeper->getPetTypeId();
                $value["remuneration"] = $keeper->getRemuneration();

                array_push($arrayEncode, $value);
            }
            $jsonContent = json_encode($arrayEncode, JSON_PRETTY_PRINT);
            file_put_contents($this->fileName, $jsonContent);
        }

        public function RetrieveData() {
            $this->keeperList = array();

            if(file_exists($this->fileName)) {
                $jsonContent = file_get_contents($this->fileName);
                $arrayDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

                foreach($arrayDecode as $value) {
                    $keeper = new Keeper();
                    $keeper->setId($value["id"]);
                    $keeper->setUserId($value["userId"]);
                    $keeper->setPetTypeId($value["petTypeId"]);
                    $keeper->setRemuneration($value["remuneration"]);

                    array_push($this->keeperList, $keeper);
                }
            }
        }
        private function GetNextId() {
            $id = 0;

            foreach($this->keeperList as $keeper) {
                $id = ($keeper->getId() > $id) ? $keeper->getId() : $id;
            }

            return $id + 1;
        }
    }
?>