<?php
    namespace DAO;

    use Models\User as User;

    interface IUserDAO {
        function Add(User $user);
        function Modify(User $user);
        function GetAll();
        function CountUser();
        function GetById($id);
        function GetByUserName($userName);
        function GetByEmail($email);
    }
?>