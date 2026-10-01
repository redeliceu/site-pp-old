<?
session_start();
if (isset($_SESSION["pppp_ar_cd_usuario"])) { $pppp_ar_cd_usuario = $_SESSION["pppp_ar_cd_usuario"]; } else { $pppp_ar_cd_usuario = ""; }
if (isset($_SESSION["pppp_ar_usuario"])) { $pppp_ar_usuario = $_SESSION["pppp_ar_usuario"]; } else { $pppp_ar_usuario = ""; }
if (($pppp_ar_cd_usuario <= 0) || (strlen($pppp_ar_usuario) <= 0)) {
	header("location:area-restrita.php?mensagem=falha");
}
require_once("../admin/connect.php");
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
		<table width="923" border="0" cellpadding="0" cellspacing="0" style="margin-left:auto;margin-right:auto;">
		<tr>
			<td height="35" width="183" style="background:url('../images/barra-menu-ar.jpg') no-repeat center center;"></td>
			<td width="740" style="background:url('../images/barra-ar-mensagem.jpg') no-repeat center center;">
				<div style="position:relative;width:100%;height:35px;overflow:hidden;text-align:right;"><a href="area-restrita.php?acao=logoff"><img src="../images/bt-sair.jpg" border="0"></a></div>
			</td>
		</tr>
		</table>
		<table width="923" border="0" cellpadding="0" cellspacing="0" style="margin-left:auto;margin-right:auto;">
		<tr>
			<td height="7" colspan="3"></td>
		</tr>
		<tr>
			<td valign="top" width="180">
				<?
				require("ar-menu.php");
				?>
			</td>
			<td width="3" style="background:url('../images/separador-v.jpg') no-repeat center top;"></td>
			<td valign="top" width="740" style="padding: 0px 10px 0px 10px;">
				<?
				$q1_query = mysql_query("select * from pensamentos order by 1 desc limit 1");
				$q1 = mysql_fetch_array($q1_query);
				echo $q1["texto"];
				?>
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