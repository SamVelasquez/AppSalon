<?php 


namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Correo{

    public $correo;
    public $nombre;
    public $token; 

    
    public function __construct($correo, $nombre , $token)
    {
        $this -> correo = $correo;
        $this -> nombre = $nombre;
        $this -> token = $token;
    }

    public function enviarConfirmacion(){

        //crear el objeto email
        $mail = new PHPMailer();
        $mail -> isSMTP();
        $mail-> Host = $_ENV['EMAIL_HOST'];
        $mail-> SMTPAuth = true;
        $mail-> Port = $_ENV['EMAIL_PORT'];
        $mail-> Username = $_ENV['EMAIL_USER'];
        $mail-> Password = $_ENV['EMAIL_PASS'];

        $mail -> setFrom('cuentas@appsalon.com');//dominio
        $mail -> addAddress('cuentas@appsalon.com', 'AppSalon.com');
        $mail -> Subject = 'confirma tu cuenta';
        //set html
        $mail ->isHTML(TRUE);
        $mail -> CharSet = 'UTF-8';

        //contenido del correo

        $contenido = "<html>";
        $contenido.="<p><strong> Hola " . $this->correo . "</strong> Has Creado tu cuenta en AppSalon , solo debes
                    confirmarla presionando el siguiente enlace</p>";
        $contenido .="<p>Presioa aqui: <a href='". $_ENV['DOMINIO_URL']."/confirmar-cuenta?token="
        . $this -> token . "'>Confirmar cuenta</a> </p>";
        $contenido .= "<p>Si tu no solicitaste esta cuenta puedes ignorar el mensaje</p>";
        $contenido .="</html>";


        $mail -> Body = $contenido;

        //ENVIAR EMAIL

        $mail -> send();
    }

    public function enviarInstrucciones(){

        //crear el objeto email
        $mail = new PHPMailer();
        $mail -> isSMTP();
        $mail-> Host = $_ENV['EMAIL_HOST'];
        $mail-> SMTPAuth = true;
        $mail-> Port = $_ENV['EMAIL_PORT'];
        $mail-> Username = $_ENV['EMAIL_USER'];
        $mail-> Password = $_ENV['EMAIL_PASS'];

        $mail -> setFrom('cuentas@appsalon.com');//dominio
        $mail -> addAddress('cuentas@appsalon.com', 'AppSalon.com');
        $mail -> Subject = 'Reestablece tu Contraseña';
        //set html
        $mail ->isHTML(TRUE);
        $mail -> CharSet = 'UTF-8';

        //contenido del correo

        $contenido = "<html>";
        $contenido.="<p><strong> Hola " . $this->nombre . "</strong>Has Solicitado restablecer tu password, sigue el siguiente enlace</p>";
        $contenido .="<p>Presioa aqui: <a href='". $_ENV['DOMINIO_URL']."/cambiar-password?token="
        . $this -> token . "'>Reestablecer Cuenta</a> </p>";
        $contenido .= "<p>Si tu no solicitaste esta cuenta puedes ignorar el mensaje</p>";
        $contenido .="</html>";


        $mail -> Body = $contenido;

        //ENVIAR EMAIL

        $mail -> send();
    }
}