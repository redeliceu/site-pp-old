<?
require("cabecalho.php");
?>
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
<tr>
	<td height="161">
		<img src="../images/cabecalho.jpg" border="0"></td>
</tr>
<tr>
	<td height="37" background="../images/fundo-menu.jpg">
		<?
		require("menu.php");
		?>
	</td>
</tr>
<tr>
	<td height="232">
		<script language="javascript">
		if (AC_FL_RunContent == 0) {
			alert("This page requires AC_RunActiveContent.js.");
		} else {
			AC_FL_RunContent( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0','width','879','height','232','id','logo','align','bottom','src','menu','quality','high','salign','b','wmode','transparent','bgcolor','#ffffff','name','logo','allowscriptaccess','sameDomain','allowfullscreen','false','pluginspage','http://www.macromedia.com/go/getflashplayer','movie','banner', 'FlashVars', 'xmlPath=data.xml');
		}
		</script>
	</td>
</tr>
<tr>
	<td height="3" background="../images/separador.jpg"></td>
</tr>
<tr>
	<td class="fundo-conteudo" height="240">
		<table width="857" height="203" align="center" border="0" cellpadding="0" cellspacing="0" style="margin-left:auto;margin-right:auto;">
		<tr>
			<td class="fundo-conteudo-cima" height="60" colspan="3">
				<img src="../images/barra-newsletter.png" border="0" style="margin-top:22px;margin-bottom:3px;margin-left:39px;">
			</td>
		</tr>
		<tr>
			<td width="39" class="fundo-conteudo-meio-canto-esquerdo"></td>
			<td width="779" valign="top" class="fundo-conteudo-meio">
				<?
				if (strlen($_REQUEST["nome"]) <= 0) {
					$erro .= " - Digite seu nome<br>";
				}
				if (strlen($_REQUEST["email"]) <= 5) {
					$erro .= " - Digite seu e-mail<br>";
				}
				if (strpos($_REQUEST["email"], "@") <= 0) {
					$erro .= " - O e-mail está incorreto<br>";
				}
				$q1_query = mysql_query("select cd_newsletter from newsletter where email like '%" . $_REQUEST["email"] . "%'");
				$q1 = mysql_fetch_array($q1_query);
				if ($q1[0] > 0) {
					$erro .= " - O seu e-mail já está cadastrado<br>";
				}
				if (strlen($erro) > 0) {
					?>
					<table width="100%" align="center" border="0" cellpadding="5" cellspacing="0" style="margin-left:auto;margin-right:auto;">
					<tr>
						<td>
							<div class="fail x-large">Erro(s) econtrado(s):<br><? echo $erro; ?></div>
						</td>
					</tr>
					</table>
					<?
					$acao = "";
				} else {
					mysql_query("insert into newsletter(nome, email) values('" . $_REQUEST["nome"] . "', '" . $_REQUEST["email"] . "')");
					require("phpmailer.php");
					$texto_mensagem = "";
					$texto_mensagem .= "Um visitante se cadastrou na newsletter<br><br>";
					$texto_mensagem .= "Nome: " . $_REQUEST["nome"] . "<br>";
					$texto_mensagem .= "E-mail: " . $_REQUEST["email"] . "<br>";
					mailp($nome, "contato@maplebearsorocaba.com.br", "MapleBearSorocaba: Newsletter", $texto_mensagem, $email, "");
					?>
					<table width="100%" align="center" border="0" cellpadding="5" cellspacing="0" style="margin-left:auto;margin-right:auto;">
					<tr>
						<td>
							<div class="success x-large">Você foi cadastrado com sucesso em nossa Newsletter. Obrigado.</div>
						</td>
					</tr>
					</table>
					<?
				}
				?>
				<p align="justify" style="margin-top:5px;text-align:center;"><a href="index.php">Voltar</a></p>
			</td>
			<td width="39" class="fundo-conteudo-meio-canto-direito"></td>
		</tr>
		<tr>
			<td class="fundo-conteudo-baixo" height="43" colspan="3"></td>
		</tr>
		</table>
	</td>
</tr>
<tr>
	<td>
		<img src="../images/rodape.jpg" border="0"></td>
</tr>
</table>
<?
require("rodape.php");
?>