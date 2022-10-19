<?php

    namespace DAO;

    use Models\User as User;

    class UserDAO implements IUserDAO {
        private $fileName = ROOT . "/Data/users.json";
        private $users = array();

        public function Add(User $user) {
            $this->RetrieveData();

            $user->setId($this->GetNextId());

            array_push($this->users, $user);

            $this->SaveData();
        }

        public function Remove($id) {
            $this->RetrieveData();

            $this->users = array_filter($this->users, function($user) use($id) {
                return $user->getId != $id;
            });

            $this->SaveData();
        }

        public function Modify(User $user) {
            $this->RetrieveData();

            $this->Remove($user->getId());

            array_push($this->users, $user);

            $this->SaveData();
        }

        public function GetAll() {
            $this->RetrieveData();

            return $this->users;
        }

        private function SaveData() {
            sort($this->users);
            $arrayEncode = array();

            foreach($this->users as $user) {
                $value["id"] = $user->getId();
                $value["userName"] = $user->getName();
                $value["password"] = $user->getPassword();
                $value["email"] = $user->getEmail();
                $value["name"] = $user->getName();
                $value["surname"] = $user->getSurname();
                $value["typeUser"] = $user->getTypeUser();
                $value["idCellphone"] = $user->getIdCellphone();
                $value["idAddress"] = $user->getIdAddress();

                array_push($arrayEncode, $value);
            }
            $jsonContent = json_encode($arrayEncode, JSON_PRETTY_PRINT);
            file_put_contents($this->fileName, $jsonContent);
        }

        private function RetrieveData() {
            $this->users = array();

            if(file_exists($this->fileName)) {
                $jsonContent = file_get_contents($this->fileName);
                $arrayDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

                foreach($arrayDecode as $value) {
                    $user = new User();
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

            foreach($this->users as $user) {
                $id = ($user->getId() > $id) ? $user->getId() : $id;
            }

            return $id + 1;
        }
    }
?>