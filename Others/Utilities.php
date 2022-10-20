<?php

    namespace Others;

    class Utilities {
        
        public function getYearForDates($birtDate) {
            $currentDate = date("Y-m-d");
            $currentDate = date("Y", $currentDate);
            $birtDate = date("Y", $birtDate);
            return $currentDate - $birtDate;
        }
    }

?>