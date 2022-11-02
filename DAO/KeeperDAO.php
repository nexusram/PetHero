<?php

    namespace DAO;
    use DAO\PetDAO;
    use DAO\DayDAO;
use Models\Booking;
use Models\Keeper;
    use Models\Pet;
    

    class KeeperDAO implements IKeeperDAO {
        private $fileName = ROOT . "/Data/keepers.json";
        private $keeperList = array();

        public function Add(Keeper $keeper) {
            $this->RetrieveData();

            $keeper->setId($this->GetNextId());
            $keeper->setScore = null;

            array_push($this->keeperList, $keeper);

            $this->SaveData();
        }

        public function GetAll() {
            $this->RetrieveData();

            return $this->keeperList;
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

        public function CheckForSize($size){
            $this->RetrieveData();

            $arrayKeeperSize = array_filter($this->keeperList, function($keeper) use($size){
                return $keeper->getPetSize() == $size;
            });
           return (count($arrayKeeperSize)>0) ? true : false;
        }

        public function GetAllFiltered($pet, $startDate, $endDate){
            $arrayKeeper = array();

            if($this->CheckForSize($pet->getPetSize()) == true)//si el primer filtro devuelve true es para filtrar
            {
                $dayDAO = new DayDAO();
                $days = $dayDAO->GetAll();

                $arrayDay = array_filter($days, function($day) use($startDate, $endDate){
                    return ($day->getIsAvailable() == true && $day->getDate() >= $startDate && $day->getDate() <=   $endDate);
                });
               
                foreach($arrayDay as $day){
                    array_push($arrayKeepes, $day->getKeeper());
                }/// Recorro la lista de dias disponibles y agrego los keepers al arrayKeeper, me falta el ultimo filtro
               
                $bookingDAO = new BookingDAO();
                $bookingsAccepted = $bookingDAO->GetAllAcceptedByDate($startDate, $endDate);

                if(!is_null($bookingsAccepted)){
                     foreach($bookingsAccepted as $booking){
                         if($booking->getBreed() == $pet->getBreed() && 
                         $booking->getBreed()->getPetType() == $pet->getType()){
                             array_push($arrayKeeper, $booking->getKeeper());
                         }///tercer filtro si hay reservas y el tipo de mascota de la reserva es igual al de la mascota recibida por parametro añado el cuidador a la lista.
                     }
                }
               //ultimo filtro, filtrado por tamaño
                $arrayKeeper = array_filter($arrayKeeper, function($keeper) use($pet){
                return $keeper->getPetSize() == $pet->getPetSize();
                });
            } 
           return $arrayKeeper; 
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
                $value["score"] = $keeper->getScore();
                $value["active"] = $keeper->getActive();


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
                    $keeper->setScore($value["score"]);
                    $keeper->setActive($value["active"]);

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