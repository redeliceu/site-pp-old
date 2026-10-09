<?
session_start();
require("connect.php");
require("funcoes.php");
if (isset($_REQUEST["acao"])) {
	$acao = $_REQUEST["acao"];
} else {
	$acao = "";
}
if (isset($_REQUEST["usuario"])) {
	$usuario = $_REQUEST["usuario"];
} else {
	$usuario = "";
}
if (isset($_REQUEST["mensagem"])) {
	$mensagem = $_REQUEST["mensagem"];
} else {
	$mensagem = "informacao";
}
if ($acao == "logar") {
	function anti_sql_injection($string)
	{
		$string = get_magic_quotes_gpc() ? stripslashes($string) : $string;
		$string = function_exists("mysql_real_escape_string") ?
			mysql_real_escape_string($string) : mysql_escape_string($string);
		return $string;
	}
	$usuario = anti_sql_injection($_REQUEST["usuario"]);
	$senha = anti_sql_injection($_REQUEST["senha"]);
	//$q1_query = mysql_query("select cd_usuario, nome, nivel from usuarios where usuario like '" . $_REQUEST["usuario"] . "' and senha = '" . encrypt($_REQUEST["senha"]) . "'");
	$q1_query = mysql_query("select cd_usuario, nome, nivel from usuarios where usuario like '" . $usuario . "' and senha = '" . $senha . "'");
	$q1 = mysql_fetch_array($q1_query);
	if ($q1[0] > 0) {
		$_SESSION["pppp_cd_usuario"] = $q1[0];
		$_SESSION["pppp_nome"] = $q1[1];
		$_SESSION["pppp_nivel"] = $q1[2];
		header("location:galerias.php");
	} else {
		$mensagem = "falha";
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link href="admin.css" rel="stylesheet" type="text/css" />
	<title>PAINEL DE CONTROLE - Colégio Pequeno Príncipe</title>
</head>

<body>
	<div id="admin_wrapper">
		<h1>Login</h1>
		<p>Bem vindo a &aacute;rea de administra&ccedil;&atilde;o do Colégio Pequeno Príncipe.</p>
		<?
		if ($mensagem == "falha") {
			?>
			<div class="<? echo $mensagem; ?> large png_bg">Usuário e/ou senha inválidos, tente novamente</div>
			<?
		} else if ($mensagem == "informacao") {
			?>
				<div class="<? echo $mensagem; ?> large png_bg">Digite seu usu&aacute;rio e senha para entrar no sistema</div>
			<?
		} else if ($mensagem == "sucesso") {
			?>
					<div class="<? echo $mensagem; ?> large png_bg">Você foi desconectado com sucesso</div>
			<?
		}
		?>
		<form action="login.php" method="post">
			<input type="hidden" name="acao" value="logar">
			<p><label>Usu&aacute;rio</label>
				<input type="text" class="input large" name="usuario" value="<? echo $usuario; ?>" />
			</p>
			<p><label>Senha</label>
				<input type="password" class="input large" value="" name="senha" />
			</p>
			<p><input type="submit" name="Submit" id="button" value="Login" class="button" />
			</p>
		</form>
	</div>
</body>

</html>