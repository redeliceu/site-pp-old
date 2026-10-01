<?
session_start();
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
				<img src="../images/barra-contato.png" border="0" style="margin-top:22px;margin-bottom:3px;margin-left:39px;">
			</td>
		</tr>
		<tr>
			<td width="39" class="fundo-conteudo-meio-canto-esquerdo"></td>
			<td width="779" valign="top" class="fundo-conteudo-meio">
				<?
				if ($acao == "enviar") {
					include("securimage.php");
					$img = new Securimage();
					$valid = $img->check($_POST['code']);
					$erro = "";
					if ($valid == true) {
						$erro = "";
					} else {
						$erro .= " - O código da imagem digitado está incorreto<br>";
					}
					if (strlen($_REQUEST["nome"]) <= 0) {
						$erro .= " - Digite seu nome<br>";
					}
					if (strlen($_REQUEST["email"]) <= 0) {
						$erro .= " - Digite seu e-mail<br>";
					}
					if (strpos($_REQUEST["email"], "@") <= 0) {
						$erro .= " - O e-mail está incorreto<br>";
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
						require("phpmailer.php");
						$texto_mensagem = "";
						$texto_mensagem .= "Um visitante enviou uma mensagem de contato pelo site<br><br>";
						$texto_mensagem .= "Nome: " . $_REQUEST["nome"] . "<br>";
						$texto_mensagem .= "E-mail: " . $_REQUEST["email"] . "<br>";
						$texto_mensagem .= "Telefone: " . $_REQUEST["telefone"] . "<br>";
						$texto_mensagem .= "Endereço: " . $_REQUEST["endereco"] . "<br>";
						$texto_mensagem .= "Bairro: " . $_REQUEST["bairro"] . "<br>";
						$texto_mensagem .= "Cidade: " . $_REQUEST["cidade"] . "<br>";
						$texto_mensagem .= "Idade dos filhos: " . $_REQUEST["idade"] . "<br>";
						$texto_mensagem .= "Como ficou sabendo da Maple Bear? " . $_REQUEST["como"] . "<br><br>";
						mailp($nome, "contato@maplebearsorocaba.com.br", "Contato pelo site MapleBearSorocaba.com.br", $texto_mensagem, $email, "");
						$acao = "sucesso";
					}
				}
				if ($acao == "") {
					?>
					<table width="100%" align="center" border="0" cellpadding="0" cellspacing="3" style="margin-left:auto;margin-right:auto;">
					<form method="post" action="contato.php" name="form_contato">
					<input type="hidden" name="acao" value="enviar">
					<tr>
						<td>
							<b>Por favor, preencha os campos abaixo para receber informações do Programa Maple Bear de Educação Bilíngue e para que a coordenação da escola entre em contato para melhor atendê-lo.</b>
						</td>
					</tr>
					<tr>
						<td height="5"></td>
					</tr>
					<tr>
						<td>
							Nome: <font color="red">*</font>
						</td>
					</tr>
					<tr>
						<td>
							<input type="text" name="nome" style="width:70%" class="input" value="<? echo $_REQUEST["nome"]; ?>">
						</td>
					</tr>
					<tr>
						<td>
							E-mail: <font color="red">*</font>
						</td>
					</tr>
					<tr>
						<td>
							<input type="text" name="email" style="width:70%" class="input" value="<? echo $_REQUEST["email"]; ?>">
						</td>
					</tr>
					<tr>
						<td>
							Telefone:
						</td>
					</tr>
					<tr>
						<td>
							<input type="text" name="telefone" style="width:30%" class="input" value="<? echo $_REQUEST["telefone"]; ?>">
						</td>
					</tr>
					<tr>
						<td>
							Endereço:
						</td>
					</tr>
					<tr>
						<td>
							<input type="text" name="endereco" style="width:80%" class="input" value="<? echo $_REQUEST["endereco"]; ?>">
						</td>
					</tr>
					<tr>
						<td>
							Bairro:
						</td>
					</tr>
					<tr>
						<td>
							<input type="text" name="bairro" style="width:60%" class="input" value="<? echo $_REQUEST["bairro"]; ?>">
						</td>
					</tr>
					<tr>
						<td>
							Cidade:
						</td>
					</tr>
					<tr>
						<td>
							<input type="text" name="cidade" style="width:60%" class="input" value="<? echo $_REQUEST["cidade"]; ?>">
						</td>
					</tr>
					<tr>
						<td>
							Idade dos filhos:
						</td>
					</tr>
					<tr>
						<td>
							<input type="text" name="idade" style="width:40%" class="input" value="<? echo $_REQUEST["idade"]; ?>">
						</td>
					</tr>
					<tr>
						<td>
							Como ficou sabendo da Maple Bear?
						</td>
					</tr>
					<tr>
						<td>
							<textarea name="como" style="width:80%;height:50px;" class="input"><? echo $_REQUEST["como"]; ?></textarea>
						</td>
					</tr>
					<tr>
						<td>
							Digite o que você vê na imagem abaixo: <font color="red">*</font>
						</td>
					</tr>
					<tr>
						<td>
							<img src="securimage_show.php?sid=<?php echo md5(uniqid(time())); ?>">
						</td>
					</tr>
					<tr>
						<td>
							<input type="text" name="code" style="width:30%;" class="input">
						</td>
					</tr>
					<tr>
						<td>
							<div style="float:left;width:50%;"><input type="submit" value=" ENVIAR " class="button"></div><div style="float:left;width:50%;"><a href="arquivos/reserva-2011.pdf" target="_blank"><img src="../images/bt-formulario-reserva.png" border="0"></a></div>
						</td>
					</tr>
					</form>
					</table>
					<?
				} else if ($acao == "sucesso") {
					?>
					<table width="100%" align="center" border="0" cellpadding="5" cellspacing="0" style="margin-left:auto;margin-right:auto;">
					<tr>
						<td>
							<div class="success x-large">Sua mensagem foi enviada com sucesso.<br><br>Obrigado.</div>
						</td>
					</tr>
					<tr>
						<td>
							<input type="button" value=" VOLTAR " class="button" onclick="document.location='contato.php';">
						</td>
					</tr>
					</table>
					<?
				}
				?>
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