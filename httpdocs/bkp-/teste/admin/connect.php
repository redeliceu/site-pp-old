<?
	$servidor = "localhost";
	$usuario = "pequenoprincipee";
	$senha = "i1n1o7u8";
	$bd = "pequenoprincipeeprincesa";
	mysql_connect($servidor, $usuario, $senha) or die(mysql_error());
	mysql_select_db($bd);
?>