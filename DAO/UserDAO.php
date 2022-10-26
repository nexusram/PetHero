<?php

namespace DAO;

use Models\User as User;

class UserDAO implements IUserDAO
{
    private $fileName = ROOT . "/Data/users.json";
    private $users = array();

    public function Add(User $user)
    {
        $this->RetrieveData();

        $user->setId($this->GetNextId());

        array_push($this->users, $user);

        $this->SaveData();
    }

    public function Remove($id)
    {
        $this->RetrieveData();

        $this->users = array_filter($this->users, function ($user) use ($id) {
            return $user->getId() != $id;
        });

        $this->SaveData();
    }

    public function Modify(User $user)
    {
        $this->RetrieveData();

        $this->Remove($user->getId());

        array_push($this->users, $user);

        $this->SaveData();
    }

    public function GetAll()
    {
        $this->RetrieveData();

        return $this->users;
    }

    public function GetByUserName($userName)
    {
        $this->RetrieveData();

        $array = array_filter($this->users, function($user) use($userName) {
            return $user->getUserName() == $userName;
        });

        $array = array_values($array);
        
        return (count($array) > 0) ? $array[0] : null;
    }
    public function CheckHotmail($userName)
    {
        $this->RetrieveData();

        $array = array_filter($this->users, function($user) use($userName) {
            return $user->getEmail() == $userName;
        });

        $array = array_values($array);
        
        return (count($array) > 0) ? $array[0] : null;
    }

    private function SaveData()
    {
        sort($this->users);
        $arrayEncode = array();

        foreach ($this->users as $user) {
            $value["id"] = $user->getId();
            $value["userType"] = $user->getUserType();
            $value["name"] = $user->getName();
            $value["surname"] = $user->getSurname();
            $value["userName"] = $user->getUserName();
            $value["password"] = $user->getPassword();
            $value["email"] = $user->getEmail();
            $value["birthDay"] = $user->getBirthDay();
            $value["cellphone"] = $user->getCellphone();
            $value["address"] = $user->getAddress();

            array_push($arrayEncode, $value);
        }
        $jsonContent = json_encode($arrayEncode, JSON_PRETTY_PRINT);
        file_put_contents($this->fileName, $jsonContent);
    }

    private function RetrieveData()
    {
        $this->users = array();

        if (file_exists($this->fileName)) {
            $jsonContent = file_get_contents($this->fileName);
            $arrayDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

            foreach ($arrayDecode as $value) {
                $user = new User();
                $user->setId($value["id"]);
                $user->setUserType($value["userType"]);
                $user->setName($value["name"]);
                $user->setSurname($value["surname"]);
                $user->setUserName($value["userName"]);
                $user->setPassword($value["password"]);
                $user->setEmail($value["email"]);
                $user->setBirthDay($value["birthDay"]);
                $user->setCellphone($value["cellphone"]);
                $user->setAddress($value["address"]);

                array_push($this->users, $user);
            }
        }
    }

    private function GetNextId()
    {
        $id = 0;

        foreach ($this->users as $user) {
            $id = ($user->getId() > $id) ? $user->getId() : $id;
        }

        return $id + 1;
    }
    public function CountUser()
    {
        $this->RetrieveData();
        return count($this->users);
    }
}
