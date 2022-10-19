<?php

    namespace DAO;

    use Models\Keeper;

    interface IKeeperDAO {
        function Add(Keeper $keeper);
        function Remove($id);
        function Modify(Keeper $keeper);
        function GetAll();
    }
?>