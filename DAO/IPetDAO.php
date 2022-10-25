<?php

    namespace DAO;

    use Models\Pet as Pet;

    interface IPetDAO {
        function Add(Pet $pet);
        function Remove($id);
        function Modify(Pet $pet);
        function GetAll();
        function Exist($userId, $name);
        function GetPetById($id);
    }
?>