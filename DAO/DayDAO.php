<?php

    namespace DAO;

    use Models\Day;
    use Models\Keeper;
    use DAO\KeeperDAO;

    class DayDAO implements IDayDAO {
        private $fileName = ROOT . "/Data/days.json";
        private $dayList = array();

        public function Add(Day $day) {
            $this->RetrieveData();

            $day->setId($this->GetNextId());

            array_push($this->dayList, $day);

            $this->SaveData();
        }

        public function Remove($id) {
            $this->RetrieveData();

            $this->dayList = array_filter($this->dayList, function($day) use($id) {
                return $day->getId() != $id;
            });

            $this->SaveData();
        }

        public function Modify(Day $day) {
            $this->RetrieveData();

            $this->Remove($day->getId());

            array_push($this->dayList, $day);

            $this->SaveData();
        }

        public function GetListByKeeper($keeperId) {
            $this->RetrieveData();

            $array = array_filter($this->dayList, function($day) use($keeperId) {
                return $day->getKeeperId() == $keeperId;
            });
            return $array;
        }

        public function GetActiveListByKeeper($keeperId) {
            $this->RetrieveData();

            $array = array_filter($this->dayList, function($day) use($keeperId) {
                return ($day->getKeeperId() == $keeperId) && ($day->getIsAvailable());
            });
            return $array;
        }

        public function GetAll() {
            $this->RetrieveData();

            return $this->dayList;
        }

        public function GetById($id) {
            $this->RetrieveData();

            $array = array_filter($this->dayList, function($day) use($id) {
                return $day->getId() == $id;
            });

            $array = array_values($array);

            return (count($array) > 0) ? $array[0] : null;
        }

        public function SaveData() {
            sort($this->dayList);
            $arrayEncode = array();

            foreach($this->dayList as $day) {
                $value["id"] = $day->getId();
                $value["keeper"] = $day->getKeeper()->getUser->getId();
                $value["date"] = $day->getDate();
                $value["isAvailable"] = $day->getIsAvailable();

                array_push($arrayEncode, $value);
            }
            $jsonContent = json_encode($arrayEncode, JSON_PRETTY_PRINT);
            file_put_contents($this->fileName, $jsonContent);
        }

        public function RetrieveData() {
            $this->dayList = array();

            if(file_exists($this->fileName)) {
                $jsonContent = file_get_contents($this->fileName);
                $arrayDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

                foreach($arrayDecode as $value) {
                    $day = new Day();
                    $day->setId($value["id"]);
                    $day->setDate($value["date"]);
                    $day->setIsAvailable($value["isAvailable"]);

                    //construyo el objeto keeper
                    $keeperDAO = new KeeperDAO();
                    $keeper = $keeperDAO->GetById($value["keeper"]);
                    $day->setKeeper($keeper);

                    array_push($this->dayList, $day);
                }
            }
        }

        private function GetNextId() {
            $id = 0;

            foreach($this->dayList as $day) {
                $id = ($day->getId() > $id) ? $day->getId() : $id;
            }

            return $id + 1;
        }
    }
?>