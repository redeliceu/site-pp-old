<?
function mailp($nome, $destino, $assunto, $mensagem, $responder_para, $copia_para='', $copia2_para='') {
	require("class.phpmailer.php");
	$mail = new PHPMailer();
	$mail->SetLanguage("br");
	$mail->SMTPDebug = false;
	$mail->From = $responder_para;
	$mail->FromName = $nome;
	$mail->Host = "mail.inotechdc.com.br";
	$mail->Mailer = "smtp";
	$mail->Hostname = "maplebearsorocaba.com.br";
	$mail->Username = "sistema@inotechdc.com.br";
	$mail->Password = "senha1234";
	$mail->SMTPAuth = true;
	$mail->Sender = $responder_para;
	$mail->AddReplyTo($responder_para);
	$mail->IsHtml(true);
	$text_body  = $mensagem;
	$text_body .= "\nData e hora: " . date("d/m/Y H:i");
	$mail->Body = $text_body;
	$mail->Subject = $assunto;
	$mail->AddAddress($destino);
	if ($copia_para != "") {
		$mail->AddCc($copia_para);
	}
	if ($copia2_para != "") {
		$mail->AddCc($copia2_para);
	}
	//$mail->AddBcc("jones@inotech.com.br");
	if(!$mail->Send())
		echo "Houve um erro ao tentar enviar o e-mail: " . $mail->ErrorInfo;
}
?>