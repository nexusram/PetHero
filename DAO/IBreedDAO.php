<?php
    namespace DAO;

    use Models\Breed;

    interface IBreedDAO{
         function Add(Breed $breed);
         function GetAll();
         function Remove($id);
         function GetById($id);
    }
?>