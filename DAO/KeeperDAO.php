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

        public function Modify(Keeper $keeper) {
            $this->RetrieveData();

            $this->Remove($keeper->getId());

            array_push($this->keeperList, $keeper);

            $this->SaveData();
        }

        public function GetById($id) {
            $this->RetrieveData();

            $array = array_filter($this->keeperList, function($keeper) use($id) {
                return $keeper->getId() == $id;
            });

            $array = array_values($array);

            return (count($array) > 0) ? $array[0] : null;
        }

        public function GetByUserId($userId) {
            $this->RetrieveData();

            $array = array_filter($this->keeperList, function($keeper) use($userId) {
                return $keeper->getUser()->getId() == $userId;
            });

            $array = array_values($array);

            return (count($array) > 0) ? $array[0] : null;
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
                $value["user"] = $keeper->getUser()->getId();
                $value["petSize"] = $keeper->getPetSize()->getId();
                $value["remuneration"] = $keeper->getRemuneration();
                $value["description"] = $keeper->getDescription();
                $value["startDate"] = $keeper->getStartDate();
                $value["endDate"] = $keeper->getEndDate();

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
                    $keeper->setRemuneration($value["remuneration"]);
                    $keeper->setDescription($value["description"]);
                    $keeper->setStartDate($value["startDate"]);
                    $keeper->setEndDate($value["endDate"]);

                    //
                    $userDAO = new UserDAO();
                    $user = $userDAO->GetById($value["user"]);
                    $keeper->setUser($user);

                    //
                    $petSizeDAO = new PetSizeDAO();
                    $petSize = $petSizeDAO->GetById($value["petSize"]);
                    $keeper->setPetSize($petSize);

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