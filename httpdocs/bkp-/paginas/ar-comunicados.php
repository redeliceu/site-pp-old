<?
session_start();
if (isset($_SESSION["pppp_ar_cd_usuario"])) { $pppp_ar_cd_usuario = $_SESSION["pppp_ar_cd_usuario"]; } else { $pppp_ar_cd_usuario = ""; }
if (isset($_SESSION["pppp_ar_usuario"])) { $pppp_ar_usuario = $_SESSION["pppp_ar_usuario"]; } else { $pppp_ar_usuario = ""; }
if (($pppp_ar_cd_usuario <= 0) || (strlen($pppp_ar_usuario) <= 0)) {
	header("location:area-restrita.php?mensagem=falha");
}
require_once("../admin/connect.php");
require_once("../admin/funcoes.php");
if (isset($_REQUEST["cd_comunicado"])) { $cd_comunicado = $_REQUEST["cd_comunicado"]; } else { $cd_comunicado = 0; }
require("cabecalho.php");
require("subcabecalho.php");

$pasta = "../paginas/arquivos/";
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
			<td width="740" style="background:url('../images/barra-ar-comunicados.jpg') no-repeat center center;">
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
				if ($cd_comunicado <= 0) {
					$q1_query = mysql_query("select * from comunicados order by data desc limit 100");
					while ($q1 = mysql_fetch_array($q1_query)) {
						?>
						<p style="font-size:14px;line-height:16px;font-weight:bold;color:#0d4885;">
							<? echo inverterData($q1["data"]); ?> - <a href="ar-comunicados.php?cd_comunicado=<? echo $q1["cd_comunicado"]; ?>" style="color:#0d4885;"><? echo $q1["titulo"]; ?></a>
						</p>
						<p style="font-size:12px;line-height:14px;color:#54585c;">
							<a href="ar-comunicados.php?cd_comunicado=<? echo $q1["cd_comunicado"]; ?>" style="color:#54585c;"><? echo trim(substr(strip_tags($q1["texto"], "<strong><b>"), 0, strrpos(substr(strip_tags($q1["texto"], "<strong><b>"), 0, 250), " ") + 1)); ?></a>
						</p>
						<div style="height:19px;background:url('../images/separador-h.jpg') repeat-x center center;"></div>
						<?
					}
				} else {
					$q1_query = mysql_query("select * from comunicados where cd_comunicado=" . $cd_comunicado);
					$q1 = mysql_fetch_array($q1_query);
					?>
					<p style="font-size:14px;line-height:16px;font-weight:bold;color:#0d4885;margin-bottom:20px;">
						<?
						if ((file_exists($pasta . $q1["imagem_1"])) && (!is_dir($pasta . $q1["imagem_1"]))) {
							?>
							<center>
							<a href="arquivos/<?=$q1["imagem_1"];?>" target="_blank"><img src="../images/icone-pdf.png" border="0" style="margin:0 auto 10px auto;"><br>Clique aqui para baixar o arquivo anexado neste comunicado</a><br><br><br>
							</center>
							<?
						}
						?>
						<b><? echo inverterData($q1["data"]); ?> - <? echo $q1["titulo"]; ?></b>
					</p>
					<p style="font-size:12px;line-height:14px;color:#54585c;margin-top:10px;">
						<? echo $q1["texto"]; ?>
					</p>
					<p style="font-size:12px;line-height:14px;color:#54585c;">
						<br><br><a href="ar-comunicados.php">< Voltar</a>
					</p>
					<?
				}
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