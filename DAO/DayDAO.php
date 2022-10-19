<?php

    namespace DAO;

    use Models\Day;

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

        public function GetAll() {
            $this->RetrieveData();

            return $this->dayList;
        }

        public function SaveData() {
            sort($this->dayList);
            $arrayEncode = array();

            foreach($this->dayList as $day) {
                $value["id"] = $day->getId();
                $value["userId"] = $day->getUserId();
                $value["date"] = $day->getDate();
                $value["hour"] = $day->getHour();
                $value["status"] = $day->getStatus();

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
                    $day->setUserId($value["userId"]);
                    $day->setDate($value["date"]);
                    $day->setHour($value["hour"]);
                    $day->setStatus($value["status"]);

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