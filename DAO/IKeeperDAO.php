<?php

    namespace DAO;

    use Models\Keeper;

    interface IKeeperDAO {
        function Add(Keeper $keeper);
        function Modify(Keeper $keeper);
        function GetById($id);
        function GetAll();
        function GetListByKeeper($keeperId);
        function GetActiveListByKeeper($keeperId);
        function GetByUserId($userId);
        function CheckForSize($size);
        function GetAllFiltered($pet, $startDate, $endDate);
        function Exist($dayList, $i);
    }
?>