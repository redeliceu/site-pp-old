<?
require("cabecalho.php");
require("subcabecalho.php");
require("../admin/connect.php");
require("../admin/funcoes.php");
$pasta = "../images/img_galerias/";
if (isset($_REQUEST["pa"])) { $pa = $_REQUEST["pa"]; } else { $pa = 1; }
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
				<img src="../images/barra-fotos.jpg" border="0"></td>
		</tr>
		<tr>
			<td height="4"></td>
		</tr>
		<tr>
			<td>
				<?
				if ($cd_galeria <= 0) {
					$q1_query = mysql_query("select cd_galeria, titulo, texto from galerias where area_restrita <= 0 order by titulo");
					while ($q1 = mysql_fetch_array($q1_query)) {
						?>
						<br>
						<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td height="27" colspan="5" style="background:url('../images/fotos-titulo-restante.png');">
								<div style="height:27px;overflow:hidden;">
									<div style="float:left;"><img src="../images/fotos-titulo-canto-esq.png" border="0"></div><div style="float:left;padding:auto 10px;background:url('../images/fotos-titulo-meio.png') repeat-x;font-size:14px;font-weight:bold;color:#ffffff;line-height:27px;"><? echo $q1["titulo"]; ?></div><div style="float:left;"><img src="../images/fotos-titulo-canto-dir.png" border="0"></div>
								</div>
							</td>
						</tr>
						<tr>
							<td height="10" width="20%"></td>
							<td width="20%"></td>
							<td width="20%"></td>
							<td width="20%"></td>
							<td width="20%"></td>
						</tr>
						<tr>
							<td colspan="5">
								<? echo $q1["texto"]; ?>
							</td>
						</tr>
						<tr>
							<td height="10" colspan="5"></td>
						</tr>
						<?
						$q2_query = mysql_query("select * from fotos where cd_galeria=" . $q1["cd_galeria"] . " order by ordenacao");
						$i = 0;
						while ($q2 = mysql_fetch_array($q2_query)) {
							if ($i == 0) {
								echo "<tr>";
							}
							?>
							<td style="text-align:left;" valign="top">
								<p style="font-size:12px;font-weight:bold;color:#4fbcee;margin-bottom:3px;"><? echo $q2["legenda"]; ?></p>
								<a href="thumbma.php?img=../images/img_galerias/<? echo $q2["imagem_1"]; ?>&w=640&h=480" rel="prettyPhoto[<? echo $q1["cd_galeria"]; ?>]" title="<? echo $q2["legenda"]; ?>"><img src="timthumb.php?src=../images/img_galerias/<? echo $q2["imagem_1"]; ?>&w=150&h=150" border="0"></a>
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
						<?
					}
				} else {
					$q1_query = mysql_query("select * from galerias where cd_galeria=$cd_galeria");
					$q1 = mysql_fetch_array($q1_query);
					?>
					<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" style="margin-left:auto;margin-right:auto;padding-top:10px;padding-bottom:10px;">
					<tr>
						<td>
							<font style="font-size:16px;font-weight:bold;"><? echo $q1["titulo"]; ?></font><br>
							<p style="font-size:12px;color:#8a8b8b;align:justify;"><? echo substr($q1["texto"], 0, 250); ?></p>
						</td>
					</tr>
					<tr>
						<td height="12"></td>
					</tr>
					<tr>
						<td>
							<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td height="1" width="25%"></td>
								<td height="1" width="25%"></td>
								<td height="1" width="25%"></td>
								<td height="1" width="25%"></td>
							</tr>
							<?
							$i = 0;
							$q3_query = mysql_query("select * from fotos where cd_galeria=" . $q1["cd_galeria"] . " order by legenda");
							while ($q3 = mysql_fetch_array($q3_query)) {
								if ($i == 0) {
									echo "<tr>";
								}
								?>
								<td style="text-align:center;">
									<a href="thumbma.php?img=../images/img_galerias/<? echo $q3["imagem_1"]; ?>&w=640&h=480" rel="prettyPhoto[galeria]" title="<? echo $q3["legenda"]; ?>"><img src="timthumb.php?src=../images/img_galerias/<? echo $q3["imagem_1"]; ?>&w=150&h=150" border="0"></a>
									<p style="text-align:center;margin-top:4px;margin-bottom:4px;"><? echo $q3["legenda"]; ?></p>
								</td>
								<?
								if ($i == 3) {
									echo "</tr><tr><td height=\"12\"></td></tr>";
									$i = -1;
								}
								$i++;
							}
							?>
							</table>
						</td>
					</tr>
					<tr>
						<td height="12"></td>
					</tr>
					<tr>
						<td>
							<a href="<? echo $PHP_SELF; ?>?pa=<? echo $pa; ?>"><img src="../images/bt-voltar.jpg" border="0"></a>
						</td>
					</tr>
					</table>
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