<?php

    namespace DAO;

    use Models\PetSize;

    interface IPetSizeDAO {
        function Add(PetSize $petSize);
        function Remove($id);
        function GetAll();
        function GetById($id);
    }
?>