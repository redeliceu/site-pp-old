<?
session_start();
if (isset($_SESSION["pppp_ar_cd_usuario"])) { $pppp_ar_cd_usuario = $_SESSION["pppp_ar_cd_usuario"]; } else { $pppp_ar_cd_usuario = ""; }
if (isset($_SESSION["pppp_ar_usuario"])) { $pppp_ar_usuario = $_SESSION["pppp_ar_usuario"]; } else { $pppp_ar_usuario = ""; }
if (($pppp_ar_cd_usuario <= 0) || (strlen($pppp_ar_usuario) <= 0)) {
	header("location:area-restrita.php?mensagem=falha");
}
$pasta = "../images/img_galerias/";
require_once("../admin/connect.php");
require_once("../admin/funcoes.php");
require("cabecalho.php");
require("subcabecalho.php");
$cdgal = isset($_REQUEST["cdgal"]) ? $_REQUEST["cdgal"] : 0;
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
			<td width="740" style="background:url('../images/barra-ar-galerias.jpg') no-repeat center center;">
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
				if ($cdgal <= 0) {
					$q1_query = mysql_query("select * from galerias where area_restrita=1 order by data desc, cd_galeria asc");
					while ($q1 = mysql_fetch_array($q1_query)) {
						$q2_query = mysql_query("select count(*) from fotos where cd_galeria=" . $q1["cd_galeria"]);
						$q2 = mysql_fetch_array($q2_query);
						?>
						<p style="font-size:14px;line-height:16px;font-weight:bold;color:#0d4885;">
							<a href="ar-galerias.php?cdgal=<? echo $q1["cd_galeria"]; ?>" style="color:#0d4885;"><? echo inverterData($q1["data"]); ?> - <? echo $q1["titulo"]; ?> (<? echo $q2[0]; ?> fotos)</a>
						</p>
						<p style="font-size:12px;line-height:14px;color:#54585c;">
							<? echo $q1["texto"]; ?>
						</p>
						<div style="height:19px;background:url('../images/separador-h.jpg') repeat-x center center;"></div>
						<?
					}
				} else {
					$q1_query = mysql_query("select * from galerias where area_restrita=1 and cd_galeria=$cdgal");
					$q1 = mysql_fetch_array($q1_query);
					?>
					<p style="font-size:14px;line-height:16px;font-weight:bold;color:#0d4885;">
						<? echo inverterData($q1["data"]); ?> - <? echo $q1["titulo"]; ?>
					</p>
					<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td height="10" width="20%"></td>
						<td width="20%"></td>
						<td width="20%"></td>
						<td width="20%"></td>
						<td width="20%"></td>
					</tr>
					<?
					$q2_query = mysql_query("select * from fotos where cd_galeria=$cdgal order by ordenacao asc, cd_foto asc");
					while ($q2 = mysql_fetch_array($q2_query)) {
						if ($i == 0) {
							echo "<tr>";
						}
						?>
						<td style="text-align:center;" valign="top">
							<p style="font-size:12px;font-weight:bold;color:#4fbcee;margin-bottom:3px;"><? echo $q2["legenda"]; ?></p>
							<a href="thumbma.php?img=<? echo $pasta . $q2["imagem_1"]; ?>&w=640&h=480" rel="prettyPhoto[<? echo $q1["cd_galeria"]; ?>]" title="<? echo $q2["legenda"]; ?>"><img src="timthumb.php?src=<? echo $pasta . $q2["imagem_1"]; ?>&w=120&h=120" border="0"></a>
						</td>
						<?
						if ($i == 4) {
							echo "</tr><tr><td colspan=\"4\" height=\"15\"></td></tr>";
							$i = -1;
						}
						$i++;
					}
					?>
					</table>
					<p style="font-size:12px;line-height:14px;color:#54585c;">
						<br><br><a href="ar-galerias.php">< Voltar</a>
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