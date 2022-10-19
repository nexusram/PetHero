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

        public function GetAll() {
            $this->RetrieveData();

            return $this->keeperList;
        }

        public function SaveData() {
            sort($this->keeperList);
            $arrayEncode = array();

            foreach($this->keeperList as $keeper) {
                $value["id"] = $keeper->getId();
                $value["userName"] = $keeper->getName();
                $value["password"] = $keeper->getPassword();
                $value["email"] = $keeper->getEmail();
                $value["name"] = $keeper->getName();
                $value["surname"] = $keeper->getSurname();
                $value["typeUser"] = $keeper->getTypeUser();
                $value["idCellphone"] = $keeper->getIdCellphone();
                $value["idAddress"] = $keeper->getIdAddress();
                $value["description"] = $keeper->getDescription();
                $value["size"] = $keeper->getSize();

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
                    $user = new Keeper();
                    $user->setId($value["id"]);
                    $user->setUserName($value["userName"]);
                    $user->setEmail($value["email"]);
                    $user->setName($value["name"]);
                    $user->setSurname($value["surname"]);
                    $user->setTypeUser($value["typeUser"]);
                    $user->setIdCellphone($value["idCellphone"]);
                    $user->setIdAddress($value["idAddress"]);

                    array_push($this->users, $user);
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