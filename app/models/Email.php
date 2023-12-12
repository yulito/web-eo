<?php

namespace App\Models;

use App\Helpers\PHPMailer\PHPMailer;
use App\Helpers\Phpmailer\Exception;

class Email
{
    public function sendMail($email, $token)
    {
        $mail = new PHPMailer(true);

        $mail-> isSMTP();

        $mail-> SMTPDebug   = 0;
        $mail-> Host        ="smtp.gmail.com";
        $mail-> Port        ="587";
        $mail->SMTPSecure    ="tls";
        $mail->SMTPAuth     ="true";

        $mail->Username     ="example@gmail.com"; 
        $mail->Password     ="password";

        $mail->setFrom("example@gmail.com", "web-eo");
        $mail->addAddress($email, "usuario");

        $mail->isHTML(true);
        $mail->CharSet = "utf-8";
        $mail->Subject="Recuperación de contraseña - web-eo"; //mejor utilizar un correo corporativo creado en un host
        $mail->Body = ' <h1 style="padding:40px; background-color:yellow;color:red;text-align: center;">
                            WEB-EO, correo para cambio de contraseña
                        </h1>
                        <p>Hola, has solicitado una recuperación de la contraseña para el ingreso a </p>
                        <p>tu cuenta en WEB-EO. Para poder restablecer y cambiar la contraseña has click en</p>
                        <br>
                        <a href="http://mvc.test/nuevo-pass/'.$token.'"> ---->este enlace.
                        <img style="height: 140px; width: 260px; " 
                             src="#"></img>
                        </a>'
                        ;
        
        if($mail->send()){
            return true;
        }else{
            return false;
        }
        
    }
}