<?php

namespace Controllers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class MailController
{

    public function sendMail($mailUser,$titulo,$mensaje,$mensaje2)
    {
        require_once(ROOT . 'PHPMailer/PHPMailer.php');
        require_once(ROOT . 'PHPMailer/SMTP.php');
        require_once(ROOT . 'PHPMailer/Exception.php');

        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = 0;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com;smtp.live.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'nahuelsuarez9797@gmail.com';                     //SMTP username
            $mail->Password   = 'ACA VA la CONTRASENIA';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('nahuelsuarez9797@gmail.com','Pet');
            $mail->addAddress($mailUser);
            //$mail->addAddress('lucreciadenisebazan@gmail.com');  //Add a recipient

            ///RECIBIR EL LISTADO DE MAILS
            /*
            $emails = $array;
            for($i = 0; $i < count($emails); $i++){
                $mail->AddAddress($emails[$i]);
            }
            /*
            //Attachments
            $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
            */
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $titulo;
            $mail->Body    = "
            <table style='border: 8px groove orange;width: 600px;height: 300px;margin: 15px auto 0px auto; background-color:silver'>
            <tr>
            <td style='font-size:20px;'>$mensaje</td> 
            <td style='font-size:20px;'>$mensaje2</td>                
            </tr>
            </table>
            ";
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
