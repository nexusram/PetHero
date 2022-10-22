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

        public function UploadImage($file, $fileName, $inputName) {
            $msg = "";
            $file = $_FILES[$inputName]["name"];

            //Si el archivo contiene algo y es diferente de vacio
            if(isset($file) && $file != "") {
                //Obtenemos algunos datos necesarios sobre el archivo
                $type = $_FILES[$inputName]["type"];
                $size = $_FILES[$inputName]["size"];
                $temp = $_FILES[$inputName]["tmp_name"];

                $explode = explode("/", $type);
                $file = $fileName . "-" . time() . "." . $explode[1];

                //Se comprueba si el archivo a cargar es correcto observando su extensión y tamaño
                if(!((strpos($type, "gif") || strpos($type, "jpeg") || strpos($type, "png")) && ($size < 2000000000))) {
                    $msg = "Error. La extensión o el tamaño de los archivos no es correcta";
                } else {
                    if(move_uploaded_file($temp, IMG_PATH . $fileName . "/" . $file)) {
                        chmod(IMG_PATH . $fileName . "/" . $file, 0777);
                    }
                }
            }
            return $msg;
        }
    }
?>