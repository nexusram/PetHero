<?php

namespace DAO;

use DAO\IViews as IViews;
use DAO\Connection as Connection;
use \Exception as Exception;
use Models\Keeper;

class KeeperDAO implements IKeeperDAO
{
    private $keeperList = array();
    private $connection;
    private $tableName = "keeper";

    public function Add(Keeper $keeper)
    {
        $keeper->setScore(0);
        $this->Insert($keeper);
    }

    public function Modify(Keeper $keeper)
    {
        $this->Update($keeper);
    }

    public function GetById($id)
    {
        $this->RetrieveData();
        $array = array_filter($this->keeperList, function ($keeper) use ($id) {
            return $keeper->getId() == $id;
        });

        $array = array_values($array);
        return (count($array) > 0) ? $array[0] : null;
    }

    public function GetAll()
    {
        $this->RetrieveData();
        return $this->keeperList;
    }

    public function GetListByKeeper($keeperId)
    {
        $this->RetrieveData();

        $array = array_filter($this->keeperList, function ($keeper) use ($keeperId) {
            return $keeper->getKeeperId() == $keeperId;
        });
        return $array;
    }

    public function GetActiveListByKeeper($keeperId)
    {
        $this->RetrieveData();

        $array = array_filter($this->keeperList, function ($keeper) use ($keeperId) {
            return ($keeper->getKeeperId() == $keeperId) && ($keeper->getIsAvailable());
        });
        return $array;
    }

    public function GetByUserId($userId)
    {
        $this->RetrieveData();

        $array = array_filter($this->keeperList, function ($keeper) use ($userId) {
            return $keeper->getUser()->getId() == $userId;
        });

        $array = array_values($array);

        return (count($array) > 0) ? $array[0] : null;
    }

    public function CheckForSize($size)
    {
        $this->RetrieveData();

        $arrayKeeperSize = array_filter($this->keeperList, function ($keeper) use ($size) {
            return $keeper->getPetSize() == $size;
        });
        return (count($arrayKeeperSize) > 0) ? true : false;
    }

    public function GetAllFiltered($pet, $startDate, $endDate)
    {
        $arrayKeeper = array();
        if ($this->CheckForSize($pet->getPetSize())) //si el primer filtro devuelve true es para filtrar
        {
            $dayDAO = new DayDAO();
            $days = $dayDAO->GetAll();

            $startDate = strtotime($startDate);
            $endDate = strtotime($endDate);

            $rangeArray = array();
            for ($i = $startDate; $i <= $endDate; $i += 86400) {
                $date = date("Y-m-d", $i);
                array_push($rangeArray, $date);
            }

            $arrayDay = array();
            foreach ($days as $day) {
                if (in_array($day->getDate(), $rangeArray) && $day->getIsAvailable()) {
                    array_push($arrayDay, $day);
                }
            }

            foreach ($arrayDay as $day) {
                array_push($arrayKeeper, $day->getKeeper());
            } /// Recorro la lista de dias disponibles y agrego los keepers al arrayKeeper, me falta el ultimo filtro

            $bookingDAO = new BookingDAO();
            $bookingsAccepted = $bookingDAO->GetAllAcceptedByDate(date("d-m-Y", $startDate), date("d-m-Y", $endDate));

            if (!is_null($bookingsAccepted)) {
                foreach ($bookingsAccepted as $booking) {
                    if (
                        $booking->getBreed() == $pet->getBreed() &&
                        $booking->getBreed()->getPetType() == $pet->getType()
                    ) {
                        array_push($arrayKeeper, $booking->getKeeper());
                    } ///tercer filtro si hay reservas y el tipo de mascota de la reserva es igual al de la mascota recibida por parametro añado el cuidador a la lista.
                }
            }
            //ultimo filtro, filtrado por tamaño
            $arrayKeeper = array_filter($arrayKeeper, function ($keeper) use ($pet) {
                return $keeper->getPetSize() == $pet->getPetSize();
            });
        }
        return $arrayKeeper;
    }

    public function Exist($dayList, $i)
    {
        $rta = false;
        foreach ($dayList as $day) {
            if (strcmp($day->getDate(), $i) == 0 && $day->getIsActive()) {
                $rta = true;
            }
        }

        return $rta;
    }

    // Insert a keeper in the table
    private function Insert(Keeper $keeper) {
        try {
            $query = "INSERT INTO $this->tableName (id_user, id_petSize, remuneration, description, score, active) VALUES (:id_user, :id_petSize, :remuneration, :description, :score, :active);";
            
            $valuesArray["id_user"] = $keeper->getUser()->getId();
            $valuesArray["id_petSize"] = $keeper->getPetSize()->getId();
            $valuesArray["remuneration"] = $keeper->getRemuneration();
            $valuesArray["description"] = $keeper->getDescription();
            $valuesArray["score"] = $keeper->getScore();
            $valuesArray["active"] = $keeper->getActive();
            
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $valuesArray);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    // Update a keeper in the table
    private function Update(Keeper $keeper) {
        try {
            $query = "UPDATE $this->tableName SET id_user = :id_user, id_petSize = :id_petSize, remuneration = :remuneration, description = :description, score = :score, active = :active";

            $parameters["id_user"] = $keeper->getUser()->getId();
            $parameters["id_petSize"] = $keeper->getPetSize()->getId();
            $parameters["remuneration"] = $keeper->getRemuneration();
            $parameters["description"] = $keeper->getDescription();
            $parameters["score"] = $keeper->getScore();
            $parameters["active"] = $keeper->getActive();
            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    } 

    // Set list keeper with info of table
    private function RetrieveData()
    {
        try {

            $query = "SELECT * FROM $this->tableName";

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query);

            foreach ($resultSet as $valuesArray) {
                $keeper = new Keeper();
                $keeper->setId($valuesArray["id"]);

                $userDAO = new UserDAO();
                $user = $userDAO->GetById($valuesArray["id_user"]);
                
                $keeper->setUser($user);

                $petSizeDAO = new PetSizeDAO();
                $petSize = $petSizeDAO->GetById($valuesArray["id_petSize"]);
                $keeper->setPetSize($petSize);

                $keeper->setRemuneration($valuesArray["remuneration"]);
                $keeper->setDescription($valuesArray["description"]);
                $keeper->setScore($valuesArray["score"]);
                $keeper->setActive($valuesArray["active"]);
                array_push($this->keeperList, $keeper);
            }
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}
