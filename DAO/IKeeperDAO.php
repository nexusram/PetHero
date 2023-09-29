<?php

    namespace DAO;

    use Models\Keeper;

    interface IKeeperDAO {
        function Add(Keeper $keeper);
        function Modify(Keeper $keeper);
        function GetById($id);
        function GetAll();
        function GetByUserId($userId);
        function GetAllFiltered($pet, $startDate, $endDate);
    }
?>