<?php if (!defined('BASEPATH')) exit('No permitir el acceso directo al script');

require_once dirname(__FILE__) . '/PHPMailer/PHPMailerAutoload.php';

class Class_mail extends PHPMailer{
    function __construct()
    {
        parent::__construct();
    }

    public function enviar_correo($correodestino,$asunto,$mensaje)
    {
		$this->isSMTP();                            // Establecer el correo electrónico para utilizar SMTP
		$this->Host = 'elementoh.com.mx';             // Especificar el servidor de correo a utilizar 
		$this->SMTPAuth = true;                     // Habilitar la autenticacion con SMTP
		$this->Username = 'noreply@elementoh.com.mx';          // Correo electronico saliente ejemplo: tucorreo@gmail.com
		$this->Password = 'I_B3WCa_G'; 		// Tu contraseña de gmail
		$this->SMTPSecure = 'tls';                  // Habilitar encriptacion, `ssl` es aceptada
		$this->Port = 587;                          // Puerto TCP  para conectarse 
		$this->setFrom('noreply@elementoh.com.mx', 'noreply');//Introduzca la dirección de la que debe aparecer el correo electrónico. Puede utilizar cualquier dirección que el servidor SMTP acepte cthisválida. El segundo parámetro opcional para esta función es el nombre que se mostrará como el remitente en lugar de la dirección de correo electrónico en sí.
		$this->addReplyTo('noreply@elementoh.com.mx', 'noreply');//Introduzca la dirección de la que debe responder. El segundo parámetro opcional para esta función es el nombre que se mostrará para responder
		$this->addAddress($correodestino);   // Agregar quien recibe el e-mail enviado
		
		$this->isHTML(true);  // Establecer el formato de correo electrónico en HTML
		
		$this->Subject = $asunto;
		$this->msgHTML($mensaje);

		if(!$this->send()) {
			return false;
			
		} else {
			return true;
			
		}
    }
}