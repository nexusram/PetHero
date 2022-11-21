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
    }
?>