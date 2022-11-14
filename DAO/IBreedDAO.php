<?php
    namespace DAO;

    use Models\Breed;

    interface IBreedDAO{
         function Add(Breed $breed);
         function Modify(Breed $breed);
         function GetAll();
         function GetById($id);
         function GetListByPetType($petTypeId);
    }
?>