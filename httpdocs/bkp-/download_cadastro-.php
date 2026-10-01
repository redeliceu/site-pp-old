<?php
require("config.php");
require("../../expositores/paginas/connect.php");
require("../../expositores/paginas/funcoes.php");
$acao = isset($_REQUEST["acao"]) ? $_REQUEST["acao"] : "";
$cd_empresa = $_REQUEST["cd_empresa"];
$chave = $_REQUEST["chave"];
$verifica_query = $mysqli->query("select cd_empresa, bloqueado from empresas where cd_empresa=$cd_empresa and chave=$chave");
$verifica = $verifica_query->fetch_array();
if ($verifica[0] <= 0) {
	header("location:index.php?acao=erro");
} else if ($verifica[1] == 1) {
	header("location:index.php?acao=bloqueado");
}
if (isset($_REQUEST["acao"])) {
	$acao = $_REQUEST["acao"];
} else {
	$acao = "";
}
function validaCPF($cpf) {
    $cpf = str_pad(preg_replace('/[^0-9]/', '', $cpf), 11, '0', STR_PAD_LEFT);

    if (strlen($cpf) !== 11 || preg_match('/^(\d)\1+$/', $cpf)) {
        return false;
    } else {
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }

            $d = ((10 * $d) % 11) % 10;

            if ($cpf[$c] != $d) {
                return false;
            }
        }

        return true;
    }
}

if ($acao == "gravar") {
	if (!validaCPF($_REQUEST["cpf"])) {
		$acao = "erro";
		$erro = "O CPF digitado está incorreto";
	} else {
		$tabela = "responsaveis";
		$campos = array();
		$valores = array();
		$cd_empresa = $_REQUEST["cd_empresa"];
		$responsavel_nome = $_REQUEST["nome"];
		$responsavel_telefone = $_REQUEST["telefone"];
		$responsavel_e_mail = $_REQUEST["email"];
		$responsavel_e_mail = $_REQUEST["cpf"];
		$campos[] = "cd_empresa";
		$campos[] = "nome";
		$campos[] = "telefone";
		$campos[] = "email";
		$campos[] = "cpf";
		$campos[] = "data";
		$campos[] = "hora";
		$valores[] = $cd_empresa;
		$valores[] = $nome;
		$valores[] = $telefone;
		$valores[] = $email;
		$valores[] = $cpf;
		$valores[] = date("Ymd");
		$valores[] = date("Hi");
		if ($cd_empresa > 0) {
			inserir($tabela, $campos, $valores);
		}
		header("location:download_cadastro.php?cd_empresa=$cd_empresa&chave=$chave&acao=baixar");
	}
}
require("cabecalho.php");
if (($acao == "") || ($acao == "erro")) {
	if ($acao == "") {
		$q2_query = $mysqli->query("select acessos from empresas where cd_empresa=" . $_REQUEST["cd_empresa"]);
		$q2 = $q2_query->fetch_array();
		$tabela = "empresas";
		$campos = array();
		$valores = array();
		$campos[] = "acessos";
		$valores[] = $q2["acessos"] + 1;
		alterar($tabela, $campos, $valores, " where cd_empresa=" . $_REQUEST["cd_empresa"]);
	}
	$empresa_query = $mysqli->query("select * from empresas where cd_empresa=$cd_empresa and chave=$chave") or die(mysqli_error($mysqli));
	$empresa = $empresa_query->fetch_array();
	if ($empresa[0] > 0) {
		if (($empresa["primeiro_acesso"] == "") || ($empresa["primeiro_acesso"] == 0)) {
			//é o primeiro acesso --------------------------------------------------------
			?>
			<script language="">
				function verificaCampos(form) {
					if (form.nome.value.length < 3) {
						alert('Digite o nome do responsável pelo cadastro de funcionários. (Mínimo de 3 caracteres)');
						form.nome.focus();
					} else if (form.telefone.value.length < 10) {
						alert('Digite o número de telefone do responsável.');
						form.telefone.focus();
					} else if (form.email.value.length < 7) {
						alert('Digite o e-mail do responsável. (Mínimo de 7 caracteres)');
						form.email.focus();
					} else {
						form.submit();
					}
				}
			</script>
			<table width="770" align="center" border="0" cellspacing="1" cellpadding="1">
			<tr>
				<td colspan="2">
				<?php
					require("prazo.php");
					?>
				</td>
			</tr>
			<tr>
				<td height="10"></td>
			</tr>
			<tr>
				<td width="50%" valign="top">
					<table width="96%" align="center" border="0" cellpadding="1" cellspacing="1">
					<tr>
						<td colspan="2">
							<u><big><b><font color="darkgreen">DOWNLOAD DO ARQUIVO DE VISITANTES ENFLOR GARDEN FAIR <?=$ano?></font></b></big></u>
						</td>
					</tr>
					<tr>
						<td align="center">
							<p>&nbsp;
						</td>
					</tr>
					<tr>
						<td align="center" colspan="2">
							<font color="darkgreen"><big><b>Empresa:&nbsp;&nbsp;
							<?php
							$empresa_query = $mysqli->query("select razao_social, nome_empresa from empresas where cd_empresa=" . $cd_empresa) or die(mysqli_error($mysqli));
							$empresa = $empresa_query->fetch_array();
							echo $empresa["nome_empresa"]; 
							?>
							</b></big></font>
						</td>
					</tr>
					<tr>
						<td align="center">
							<p>&nbsp;
						</td>
					</tr>
					<tr>
						<td colspan="2" align="center" >
							<font color="red">* Atenção: É necessário o preenchimento do cadastro abaixo para realizar o download do arquivo.</font>
						</td>
						<td height="25"><td>
					</tr>
					<form method="post" action="download_cadastro.php?acao=gravar" name="form">
					<input type="hidden" value="<?php echo $cd_empresa; ?>" name="cd_empresa">
					<input type="hidden" value="<?php echo $chave; ?>" name="chave">
					<tr>
						<td colspan="2" align="center">
							<font color="red">* = campo obrigatório</font>
						</td>
					</tr>
					<tr>
						<td align="right" width="25%">
							Seu nome:&nbsp;&nbsp;
						</td>
						<td width="75%">
							<input type="text" name="nome" size="50" value="<?php echo $_REQUEST["nome"]; ?>" maxlength="150">&nbsp;<font color="red">*</font>
						</td>
					</tr>
					<tr>
						<td align="right">
							Telefone:&nbsp;&nbsp;
						</td>
						<td>
							<input type="text" name="telefone" size="50" value="<?php echo $_REQUEST["telefone"]; ?>"  maxlength="70" placeholder="(xx) 00000-0000">&nbsp;<font color="red">*</font>&nbsp;
						</td>
					</tr>
					<tr>
						<td align="right">
							E-mail:&nbsp;&nbsp;
						</td>
						<td>
							<input type="text" name="email" size="50" value="<?php echo $_REQUEST["email"]; ?>" maxlength="150">&nbsp;<font color="red">*</font>
						</td>
					</tr>
					<?php
					if ($acao == "erro") {
						?>
						<tr>
							<td colspan="2">
								<center><b style="color:red;"><?php echo $erro; ?></b></center>
							</td>
						</tr>
						<?php
					}
					?>
					<tr>
						<td align="right">
							CPF:&nbsp;&nbsp;
						</td>
						<td>
							<input type="text" name="cpf" size="50" value="<?php echo $_REQUEST["cpf"]; ?>" maxlength="70" placeholder="000.000.000-00">&nbsp;<font color="red">*</font>
						</td>
					</tr>
					<tr>
						<td></td>
						<td>
							<img src="../images/bt_entrar.jpg" border="0" onclick="verificaCampos(document.form);" onmouseover="style.cursor='hand'">
						</td>
					</tr>
					</form>
					</table>
					<script>
						$(document).ready(function(){
							var SPMaskBehavior = function (val) {
								return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
							}, spOptions = {
								onKeyPress: function(val, e, field, options) {
									field.mask(SPMaskBehavior.apply({}, arguments), options);
								}
							};
							$('[name=telefone]').mask(SPMaskBehavior, spOptions);
						});
						$('[name=cpf]').mask('000.000.000-00');
					</script>
				</td>
			</tr>
			<tr>
				<td height="13">
			</tr>
			<tr>
				<td colspan="2">
					<hr size="1" align="center" border="0" bgcolor="#000000" width="98%">
				</td>
			</tr>
			</table>
			<?php
			require("rodape.php");
		}else{
			header("location:download_cadastro.php?cd_empresa=$cd_empresa&chave=$chave&acao=baixar");	
		}
	}
} else if ($acao == "baixar") {
	$verifica_query = $mysqli->query("select cd_empresa, download_visitantes from empresas where cd_empresa=" . $_REQUEST["cd_empresa"] . " and chave=" . $_REQUEST["chave"]);
	$verifica = $verifica_query->fetch_array();
	if($_REQUEST['download']==1){
		$mysqli->query("update empresas set download_visitantes=download_visitantes+1 where cd_empresa=" . $_REQUEST["cd_empresa"]);
		$arq = "relat-geral-visita/" . $_REQUEST["arq"];
		if($arq!=""){
			if ($verifica[1] <= 20) {
				if( is_file( $arq ) ){
					header("Content-Description: File Transfer");
			        header("Content-Disposition: attachment; filename=$arq");
			        header ('Content-type: application/x-msexcel');


				

					// The PDF source is in original.pdf
					readfile("$arq");
				   
				}else{
					echo "";
				}
			}
		}
	}else if($_REQUEST['download']==2){
		$mysqli->query("update empresas set download_visitantes=download_visitantes+1 where cd_empresa=" . $_REQUEST["cd_empresa"]);
		$arq = "relat-geral-visita/" . $_REQUEST["arq"];
		if($arq!=""){
			if ($verifica[1] <= 20) {
				?>
				<script>
				$(document).ready(function(){
				$("#baixar").click();
				});
				</script>
				<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
				<a id="baixar" href="<?=$arq;?>" onclick="this.click()" download="enflor<?=$ano;?>-visitantes-geral.xls"></a>
				<?php
			}
			/*if ($verifica[1] <= 1) {
				if( is_file( $arq ) ){
					header("Content-Description: File Transfer");
			        header("Content-Disposition: attachment; filename=$arq");
			        header ('Content-type: application/x-msexcel');


				

					// The PDF source is in original.pdf
					readfile("$arq");
				   
				}else{
					echo "";
				}
			}*/
		}
	}
	
	if ($verifica[0] > 0) {
		//$mysqli->query("update empresas set download_visitantes=download_visitantes+1 where cd_empresa=" . $_REQUEST["cd_empresa"]);
		?>
		<table width="770" align="center" border="0" cellspacing="1" cellpadding="1">
		<tr>
			<td colspan="2">
			<?php
				require("prazo.php");
				?>
			</td>
		</tr>
		<tr>
			<td height="10"></td>
		</tr>
		<tr>
			<td valign="top">
				<div class="container">
					<div class="row">
						<u><big><b><font color="darkgreen">DOWNLOAD DO ARQUIVO DE VISITANTES ENFLOR GARDEN FAIR <?=$ano;?></font></b></big></u>
					</div>
				</div>
				<div style="height:20px;"></div>
				<?php
				if ($verifica[1] <= 20) {
					?>
					<div class="container">
						<div class="row" style="overflow:scroll; height:200px;font-size: 16px;">

						Não é permitido ceder, vender ou alugar, sem a autorização da empresa organizadora do evento, os dados dos visitantes.
						<br><br>
						Os dados dos visitantes devem ser utilizados exclusivamente para a comunicação, envio de material promocional e montagem de relatórios.
						<br><br>
						É de responsabilidade da empresa expositora a correta utilização e proteção dos dados fornecidos.
						<br><br>
						A empresa organizadora do evento não poderá ser responsabilizada por qualquer prejuízo que eventualmente ocorra em decorrência da utilização inadequada dos dados dos visitantes.
						<br><br>
						</div>
						<div style="height:20px;"></div>
						<div class="row">
							<input id="aceito" type="checkbox" name="aceito" value="Aceito"> <b style="font-size:14px;">Eu li e concordo com os termos de uso dos dados</b>
						</div>
						
						<div style="height:20px;"></div>

						<div class="row" id="box-download" style="display:none;">	
							
							<div class="col-sm-6">
								<center><h2><a href="https://hortitec.inotech.com.br/enflor<?=$ano;?>/download/paginas/download_cadastro.php?cd_empresa=<?=$cd_empresa;?>&chave=<?=$chave;?>&acao=baixar&download=2&arq=enflor<?=$ano;?>-visitantes-geral.xls" target="_blank">Baixar arquivo em Excel</a></h2></center>
							</div>
							
							<div class="col-sm-12 text-center">
								<center><h2><a href="https://hortitec.inotech.com.br/enflor<?=$ano;?>/download/paginas/download_cadastro.php?cd_empresa=<?=$cd_empresa;?>&chave=<?=$chave;?>&acao=baixar&download=1&arq=enflor<?=$ano;?>-visitantes-geral.zip" target="_blank">Baixar arquivo</a></h2></center>
							</div>
						</div>
					</div>
					<script type="text/javascript">
					$("#aceito").click(function(){	
					 	if ($('#aceito').is(":checked"))
						{
							jQuery("#box-download").show();
						}else{
							jQuery("#box-download").hide();
						}
					});
					</script>
					<?php
				} else {
					?>
					<tr>
						<td align="center" colspan="2">
							<h1>Sua empresa já efetuou o download do arquivo muitas vezes</h1>
						</td>
					</tr>
					<?php
				}
				?>
			</td>
		</tr>
		<tr>
			<td height="13">
		</tr>
		<tr>
			<td >
				<hr size="1" align="center" border="0" bgcolor="#000000" width="98%">
			</td>
		</tr>
		</table>
		<?php
		require("rodape.php");
	}
}
?>