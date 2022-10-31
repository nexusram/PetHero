<?php
    namespace DAO;

    use Models\Breed;

    interface IBreedDAO{
        public function Add(Breed $breed);
        public function GetAll();
        public function Remove();
        public function GetById();
    }
?>