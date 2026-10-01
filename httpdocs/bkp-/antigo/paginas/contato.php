<?
require("cabecalho.php");
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
				<img src="../images/barra-contato.jpg" border="0"></td>
		</tr>
		<tr>
			<td height="4"></td>
		</tr>
		<tr>
			<td>
				<b>Entre em contato conosco através do telefone ou e-mail abaixo</b>
			</td>
		</tr>
		<tr>
			<td height="4"></td>
		</tr>
		<tr>
			<td>
				Tel.: (11) 4743-2214<br>
				E-mail: <a href="mailto:contato@pequenoprincipeeprincesa.com.br">contato@pequenoprincipeeprincesa.com.br</a>
			</td>
		</tr>
		<tr>
			<td height="4"></td>
		</tr>
		<tr>
			<td style="padding: 0px 10px 0px 10px;">
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
						$texto_mensagem .= "Como teve conhecimento da escola? " . $_REQUEST["como"] . "<br>";
						$texto_mensagem .= "Dúvidas, sugestões ou críticas " . $_REQUEST["duvidas"] . "<br><br>";
						mailp($nome, "contato@pequenoprincipeeprincesa.com.br", "Contato pelo site PequenoPrincipeePrincesa.com.br", $texto_mensagem, $email, "sandra@pequenoprincipeeprincesa.com.br");
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
							<b>Ou preencha o formulário abaixo</b>
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
							Como teve conhecimento da escola?
						</td>
					</tr>
					<tr>
						<td>
							<textarea name="como" style="width:80%;height:50px;" class="input"><? echo $_REQUEST["como"]; ?></textarea>
						</td>
					</tr>
					<tr>
						<td>
							Digite aqui suas dúvidas, sugestões ou críticas
						</td>
					</tr>
					<tr>
						<td>
							<textarea name="duvidas" style="width:80%;height:50px;" class="input"><? echo $_REQUEST["duvidas"]; ?></textarea>
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
							<input type="submit" value=" ENVIAR " class="button">
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