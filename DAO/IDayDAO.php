<?php

    namespace DAO;

    use Models\Day as Day;

    interface IDayDAO {
        function Add(Day $day);
        function Remove($id);
        function GetAll();
    }
?>