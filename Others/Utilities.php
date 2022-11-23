<?php

    namespace Others;

use DateTime;

    class Utilities {
        
        public function getYearForDate($birthDate) {
            $dateOfBirth = new DateTime($birthDate);
            $now = new DateTime();

            $diference = $now->diff($dateOfBirth);

            return $diference->format("%y");
        }

        public function getDiference($dateOne, $dateTwo) {
            return $diff = (new DateTime($dateOne))->diff(new DateTime($dateTwo))->format("%d")+1;
        }
    }
?>