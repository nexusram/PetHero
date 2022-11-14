<?php

    namespace DAO;

    use Models\Day as Day;

    interface IDayDAO {
        function Add(Day $day);
        function Modify(Day $day);
        function GetAll();
        function GetById($id);
        function GetListByKeeper($keeperId);
        function GetActiveListByKeeper($keeperId);
        function GetInactiveListByKeeper($keeperId);
    }
?>