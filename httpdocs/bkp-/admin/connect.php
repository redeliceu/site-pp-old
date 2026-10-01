<?
	$servidor = "robb0376.publiccloud.com.br";
	$usuario = "inote_ppp";
	$senha = "zkRw386*";
	$bd = "inotech_ppp";
	mysql_connect($servidor, $usuario, $senha) or die(mysql_error());
	mysql_select_db($bd);
?>