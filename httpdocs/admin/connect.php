<?
	$servidor = "robb0376.publiccloud.com.br:3306";
	$usuario = "inote_pequeno";
	$senha = "G8%2ag2y";
	$bd = "inotech_pequeno";
	mysql_connect($servidor, $usuario, $senha) or die(mysql_error());
	mysql_select_db($bd);
?>