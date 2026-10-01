<?
session_start();
require_once("../admin/connect.php");
if (isset($_REQUEST["acao"])) { $acao = $_REQUEST["acao"]; } else { $acao = ""; }
if ($acao == "logoff") {
	$_SESSION["pppp_ar_cd_usuario"] = -1;
	$_SESSION["pppp_ar_usuario"] = -1;
	$pppp_ar_cd_usuario = -1;
	$pppp_ar_usuario = "";
	$mensagem = "sucesso";
}
if (($pppp_ar_cd_usuario > 0) || (strlen($pppp_ar_usuario) > 0)) {
	header("location:ar-mensagem");
}
if ($acao == "entrar") {
	$q1_query = mysql_query("select * from galerias_usuarios where usuario like '" . $_REQUEST["login"] . "' and senha = '" . $_REQUEST["senha"] . "'");
	$q1 = mysql_fetch_array($q1_query);
	if ($q1[0] > 0) {
		$_SESSION["pppp_ar_cd_usuario"] = $q1[0];
		$_SESSION["pppp_ar_usuario"] = $q1[1];
		header("location:ar-mensagem");
	} else {
		$mensagem = "falha";
	}
}
require("cabecalho.php");
require("subcabecalho.php");
?>
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
<tr>
	<td height="7"></td>
</tr>
<tr>
	<td background="../images/fundo-conteudo-cima.jpg" style="background-repeat:no-repeat;" height="23">
		
	</td>
</tr>
<tr>
	<td background="../images/fundo-conteudo-meio.jpg" style="background-repeat:repeat-y;">
		<table width="930" border="0" cellpadding="0" cellspacing="0" style="margin-left:auto;margin-right:auto;">
		<tr>
			<td>
				<img src="../images/barra-area-restrita.jpg" border="0"></td>
		</tr>
		<tr>
			<td>
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
				<div style="position:relative;width:317px;height:157px;margin-left:auto;margin-right:auto;margin-top:11px; margin-bottom:5px;background:url('../images/fundo-login.jpg') no-repeat center center;">
					<form method="post" action="https://pequenoprincipeeprincesa.com.br/area-restrita" name="form_login">
					<input type="hidden" name="acao" value="entrar">
					<input type="text" name="login" class="input-sb" style="position:absolute;width:171px;margin-top:51px;margin-left:83px;">
					<input type="password" name="senha" class="input-sb" style="position:absolute;width:171px;margin-top:83px;margin-left:83px;">
					<input type="image" src="../images/bt-entrar.png" style="position:absolute;width:68px;height:30px;margin-top:113px;margin-left:191px;">
					</form>
				</div>
			</td>
		</tr>
		</table>
	</td>
</tr>
<tr>
	<td background="../images/fundo-conteudo-baixo.jpg" style="background-repeat:no-repeat;" height="20">
		
	</td>
</tr>
<tr>
	<td height="5"></td>
</tr>
</table>
<?
require("rodape.php");
?>