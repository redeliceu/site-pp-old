<?
session_start();
ini_set('post_max_size', '50M');
ini_set('upload_max_filesize', '50M');
ini_set('memory_limit', '50M');
set_time_limit(0);
if (isset($_SESSION["pppp_cd_usuario"])) { $pppp_cd_usuario = $_SESSION["pppp_cd_usuario"]; } else { $pppp_cd_usuario = ""; }
if (isset($_SESSION["pppp_nome"])) { $pppp_nome = $_SESSION["pppp_nome"]; } else { $pppp_nome = ""; }
if (isset($_SESSION["pppp_nivel"])) { $pppp_nivel = $_SESSION["pppp_nivel"]; } else { $pppp_nivel = ""; }
if (($pppp_cd_usuario <= 0) || (strlen($pppp_nome) <= 0)) {
	header("location:login.php?mensagem=falha");
}
require("connect.php");
require("funcoes.php");

$tabela = "fotos";
$pasta = "../images/img_galerias/";
if (isset($_REQUEST["imagens"])) { $imagens = $_REQUEST["imagens"]; } else { $imagens = 1; }
$legenda_cadastro = "Cadastro de fotos";
$legenda_consulta = "Consulta de fotos";
$mensagem_alterado_inserido = "O registro foi adicionado/alterado com sucesso";
$mensagem_excluido = "O registro foi excluído com sucesso";
$mensagem_imagem_excluido = "A imagem foi excluída com sucesso";
$pergunta_exclusao = "Tem certeza de que deseja excluir este registro?";
$mensagem_erro_sem_cadastrados = "NÃO HÁ FOTOS CADASTRADAS";

//parametros padrao
if (isset($_REQUEST["acao"])) { $acao = $_REQUEST["acao"]; } else { $acao = ""; }
if (isset($_REQUEST["cd_foto"])) { $cd_foto = $_REQUEST["cd_foto"]; } else { $cd_foto = 0; }
if (isset($_REQUEST["tipo_mensagem"])) { $tipo_mensagem = $_REQUEST["tipo_mensagem"]; } else { $tipo_mensagem = ""; }
if (isset($_REQUEST["mensagem"])) { $mensagem = $_REQUEST["mensagem"]; } else { $mensagem = ""; }

//parametros para gravacao
if (isset($_REQUEST["cd_galeria"])) { $cd_galeria = $_REQUEST["cd_galeria"]; } else { $cd_galeria = ""; }
if (isset($_REQUEST["ordenacao"])) { $ordenacao = $_REQUEST["ordenacao"]; } else { $ordenacao = 0; }

if ($acao == "gravar") {

	if (strlen($mensagem) <= 0) {
		//grava imagens
		$q2_query = mysql_query("select max(cd_foto) from fotos");
		$q2 = mysql_fetch_array($q2_query);
		$cd_foto = $q2[0];
		for ($i = 1; $i <= $imagens; $i++) {
			if (move_uploaded_file($_FILES["imagem_" . $i]["tmp_name"], $pasta . $tabela . "_" . ($cd_foto + $i) . ".jpg")) {
				apagaThumbs($pasta, $tabela, ($cd_foto + $i));
				$imagem = $tabela . "_" . ($cd_foto + $i) . ".jpg";
				$campos = array();
				$valores = array();
				$campos[] = "cd_galeria";
				$campos[] = "legenda";
				$campos[] = "ordenacao";
				$campos[] = "imagem_1";
				$valores[] = $cd_galeria;
				$valores[] = $_REQUEST["legenda_" . $i];
				$valores[] = $_REQUEST["ordenacao_" . $i];
				$valores[] = $imagem;
				inserir($tabela, $campos, $valores);
			}
		}
		header("location:" . $_SERVER["PHP_SELF"] . "?acao=cadastrar&cd_galeria=$cd_galeria&tipo_mensagem=sucesso&mensagem=$mensagem_alterado_inserido&imagens=$imagens");
	} else {
		$tipo_mensagem = "falha";
		$acao = "cadastrar";
	}
} else if ($acao == "excluir_imagem") {
	$q1_query = mysql_query("select * from fotos where cd_foto=$cd_foto");
	$q1 = mysql_fetch_array($q1_query);
	if ((file_exists($pasta . $q1["imagem_1"])) && (!is_dir($pasta . $q1["imagem_1"]))) {
		unlink($pasta . $q1["imagem_1"]);
		apagaThumbs($pasta, $tabela, $cd_foto . "_1");
	}
	mysql_query("delete from fotos where cd_foto=$cd_foto");
	header("location:" . $_SERVER["PHP_SELF"] . "?acao=cadastrar&cd_galeria=$cd_galeria&tipo_mensagem=sucesso&mensagem=$mensagem_imagem_excluido&imagens=$imagens");
}
require("cabecalho.php");

if ($acao == "cadastrar") {
	$q1_query = mysql_query("select * from $tabela where cd_foto=$cd_foto") or die(mysql_error());
	$q1 = mysql_fetch_array($q1_query);
	$q2_query = mysql_query("select * from galerias where cd_galeria=$cd_galeria") or die(mysql_error());
	$q2 = mysql_fetch_array($q2_query);
	if ($q1[0] <= 0) {
		$q1["legenda"] = "";
		$q1["imagem_1"] = "";
	}
	?>
	<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
	<form method="post" action="<? echo $_SERVER["PHP_SELF"]; ?>" name="form" enctype="multipart/form-data">
	<input type="hidden" name="acao" value="gravar">
	<input type="hidden" name="cd_foto" value="<? echo $cd_foto; ?>">
	<input type="hidden" name="cd_galeria" value="<? echo $cd_galeria; ?>">
	<input type="hidden" name="imagens" value="<? echo $imagens; ?>">
	<tr>
		<td class="titulo" colspan="2" valign="top" class="pad-4">
			<? echo $legenda_cadastro; ?> - <? echo $q2["titulo"]; ?>
		</td>
	</tr>
	<tr>
		<td height="2" bgcolor="#cccccc" colspan="2"></td>
	</tr>
	<?
	if (strlen($mensagem) > 0) {
		?>
		<tr>
			<td colspan="2">
				<div class="<? echo $tipo_mensagem; ?> x-large png_bg"><? echo $mensagem; ?></div>
			</td>
		</tr>
		<?
	}
	for ($i = 1; $i <= $imagens; $i++) {
		?>
		<tr>
			<td class="pad-4">
				<label>Imagem</label>
			</td>
			<td class="pad-4">
				<?
				if ((file_exists($pasta . $q1["imagem_" . $i])) && (!is_dir($pasta . $q1["imagem_" . $i]))) {
					?>
					<img src="timthumb.php?src=<? echo $pasta . $q1["imagem_" . $i]; ?>&w=100&h=60">&nbsp;<input type="button" value="Apagar esta foto" class="button" onclick="if (confirm('Deseja excluir esta imagem?')) { document.location='<? echo $_SERVER["PHP_SELF"]; ?>?cd_foto=<? echo $q1["cd_foto"]; ?>&acao=excluir_imagem_<? echo $i; ?>'; }">
					<?
				} else {	
					?>
					<input type="file" name="imagem_<? echo $i; ?>" class="input large" class="button">
					<?
				}
				?>
			</td>
		</tr>
		<tr>
			<td class="pad-4" width="20%">
				<label>Legenda</label>
			</td>
			<td class="pad-4" width="80%">
				<input type="text" name="legenda_<? echo $i; ?>" class="input x-large" value="<? echo $q1["legenda"]; ?>">
			</td>
		</tr>
		<tr>
			<td class="pad-4" width="20%">
				<label>Ordenação</label>
			</td>
			<td class="pad-4" width="80%">
				<input type="text" name="ordenacao_<? echo $i; ?>" class="input x-small" value="<? echo $q1["ordenacao"]; ?>">
			</td>
		</tr>
		<?
	}
	?>
	<tr>
		<td class="pad-4">
			
		</td>
		<td class="pad-4">
			<?
			if ($pppp_nivel > 0) {
				?>
				<input type="submit" value=" Gravar " class="button">
				<?
			}
			?>
		</td>
	</tr>
	</form>
	<tr>
		<td colspan="2" height="15"></td>
	</tr>
	<tr>
		<td colspan="2">
			<b>Fotos já gravadas</b>
		</td>
	</tr>
	<tr>
		<td colspan="2" height="5"></td>
	</tr>
	<tr>
		<td colspan="2">
			<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td height="1" width="25%"></td>
				<td height="1" width="25%"></td>
				<td height="1" width="25%"></td>
				<td height="1" width="25%"></td>
			</tr>
			<?
			$i = 0;
			$q3_query = mysql_query("select * from fotos where cd_galeria=$cd_galeria order by ordenacao asc, cd_foto desc");
			while ($q3 = mysql_fetch_array($q3_query)) {
				if ($i == 0) {
					echo "<tr>";
				}
				?>
				<td style="text-align:center;">
					<img src="timthumb.php?src=../images/img_galerias/<? echo $q3["imagem_1"]; ?>&w=150&h=150" border="0">
					<p style="text-align:center;margin-top:4px;margin-bottom:4px;"><? echo $q3["legenda"]; ?></p>
					<p style="text-align:center;margin-top:4px;margin-bottom:4px;">Ord.: <? echo $q3["ordenacao"]; ?></p>
					<input type="button" value=" Excluir " class="button" onclick="if (confirm('Tem certeza de que deseja excluir esta foto?')) { document.location='<? echo $_SERVER["PHP_SELF"]; ?>?acao=excluir_imagem&cd_galeria=<? echo $cd_galeria; ?>&cd_foto=<? echo $q3["cd_foto"]; ?>&imagens=<? echo $imagens; ?>'; }">
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
		<td class="pad-4" colspan="2">
			<input type="button" value=" < Voltar " class="button" onclick="document.location='galerias.php';">
		</td>
	</tr>
	</table>
	<?
}
require("rodape.php");
?>