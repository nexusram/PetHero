<?php

    namespace DAO;

    use Models\User as User;

    interface IUserDAO {
        function Add(User $user);
        function Remove($id);
        function Modify(User $user);
        function GetAll();
    }
?>