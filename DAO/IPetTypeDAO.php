<?php
    
    namespace DAO;

    use Models\PetType;

    interface IPetTypeDAO {
        function Add(PetType $petType);
        function GetAll();
        function GetById($id);
    }
?>