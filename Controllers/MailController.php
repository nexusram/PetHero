<?php

namespace Controllers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class MailController
{

//check if the session is started, if it is started you will see the Show Pet view if not the login to start
    public function Index($message = "")
    {
        if (isset($_SESSION["loggedUser"])) {
            require_once(VIEWS_PATH . "welcome.php");
        } else if (!isset($_SESSION["loggedUser"])) {
            require_once(VIEWS_PATH . "login.php");
        }
    }
//send mail,parameters the user,s mail,tittle,message,message2
    public function sendMail($mailUser,$titulo,$mensaje,$mensaje2)
    {
        require_once(ROOT . 'PHPMailer/PHPMailer.php');
        require_once(ROOT . 'PHPMailer/SMTP.php');
        require_once(ROOT . 'PHPMailer/Exception.php');

        $mail = new PHPMailer(true);

        try {
            $mail->SMTPDebug = 0;                    
            $mail->isSMTP();                                          
            $mail->Host       = 'smtp.gmail.com;smtp.live.com';                  
            $mail->SMTPAuth   = true;                                  
            $mail->Username   = '';                    
            $mail->Password   = '';                             
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            
            $mail->Port       = 465;                                   

            $mail->setFrom('','Pet');
            $mail->addAddress($mailUser);
          
            $mail->isHTML(true);                                 
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
