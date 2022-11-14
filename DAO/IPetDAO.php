<?php

    namespace DAO;

    use Models\Pet as Pet;

    interface IPetDAO {
        function Add(Pet $pet);
        function Modify(Pet $pet);
        function Exist($userId, $name);
        function GetActivePetsOfUser($userId);
        function GetPetById($id);
        function GetAll();
    }
?>