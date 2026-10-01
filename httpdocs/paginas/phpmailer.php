<?
function mailp($destino, $assunto, $mensagem) {
	require 'PHPMailerAutoload.php';
	$mail = new PHPMailer(true);
	$mail->CharSet = 'UTF-8';
	$mail->SMTPDebug = false;
	$mail->From = "contato@pequenoprincipeeprincesa.com.br";
	$mail->FromName = "Pequeno Principe e Princesa";
	$mail->IsSMTP();
	$mail->Host = "email-smtp.us-west-2.amazonaws.com";
	$mail->Port = 465;
	$mail->Hostname = "pequenoprincipeeprincesa.com.br";
	$mail->Username = "AKIAIQLLK26Z2BMHWEYA";
	$mail->Password = "ArdEwFMoFnCod4EvEEweTIkquqnpXN4aLGHIm10Ntx/H";
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = "ssl";
	$mail->Sender = "contato@pequenoprincipeeprincesa.com.br";

	$mail->AddReplyTo("contato@pequenoprincipeeprincesa.com.br");
	$mail->IsHtml(true);
	$text_body  = $mensagem;
	$text_body .= "\nData e hora: " . date("d/m/Y H:i");
	$mail->Body = $text_body;
	$mail->Subject = $assunto;
	$mail->AddAddress($destino);
	$mail->AddBcc("sandra@pequenoprincipeeprincesa.com.br");
	if(!$mail->Send())
		echo "Houve um erro ao tentar enviar o e-mail: " . $mail->ErrorInfo;
}
?>