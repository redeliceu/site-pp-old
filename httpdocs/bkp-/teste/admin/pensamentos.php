<?
session_start();
ini_set('post_max_size', '50M');
ini_set('upload_max_filesize', '50M');
ini_set('memory_limit', '50M');
set_time_limit(0);
if (isset($_SESSION["pppp_cd_usuario"])) { $pppp_cd_usuario = $_SESSION["pppp_cd_usuario"]; } else { $pppp_cd_usuario = ""; }
if (isset($_SESSION["pppp_titulo"])) { $pppp_titulo = $_SESSION["pppp_titulo"]; } else { $pppp_titulo = ""; }
if (isset($_SESSION["pppp_nivel"])) { $pppp_nivel = $_SESSION["pppp_nivel"]; } else { $pppp_nivel = ""; }
if (($pppp_cd_usuario <= 0) || (strlen($pppp_nome) <= 0)) {
	header("location:login.php?mensagem=falha");
}
require("connect.php");
require("funcoes.php");

$tabela = "pensamentos";
$pasta = "../images/img_pensamentos/";
$imagens = 1;
$titulo_cadastro = "Cadastro de pensamentos";
$titulo_consulta = "Consulta de pensamentos";
$mensagem_alterado_inserido = "O registro foi adicionado/alterado com sucesso";
$mensagem_excluido = "O registro foi excluído com sucesso";
$mensagem_imagem_excluido = "A imagem foi excluída com sucesso";
$pergunta_exclusao = "Tem certeza de que deseja excluir este registro?";
$mensagem_erro_sem_cadastrados = "NÃO HÁ PENSAMENTOS CADASTRADAS";

//parametros padrao
if (isset($_REQUEST["acao"])) { $acao = $_REQUEST["acao"]; } else { $acao = ""; }
if (isset($_REQUEST["cd_pensamento"])) { $cd_pensamento = $_REQUEST["cd_pensamento"]; } else { $cd_pensamento = 0; }
if (isset($_REQUEST["tipo_mensagem"])) { $tipo_mensagem = $_REQUEST["tipo_mensagem"]; } else { $tipo_mensagem = ""; }
if (isset($_REQUEST["mensagem"])) { $mensagem = $_REQUEST["mensagem"]; } else { $mensagem = ""; }

//parametros para gravacao
if (isset($_REQUEST["titulo"])) { $titulo = $_REQUEST["titulo"]; } else { $titulo = ""; }
if (isset($_REQUEST["data"])) { $data = $_REQUEST["data"]; } else { $data = ""; }
if (isset($_REQUEST["texto"])) { $texto = $_REQUEST["texto"]; } else { $texto = ""; }

if ($acao == "gravar") {
	$campos = array();
	$valores = array();
	$campos[] = "data";
	$campos[] = "titulo";
	$campos[] = "texto";
	$valores[] = formatarData($data);
	$valores[] = $titulo;
	$valores[] = $texto;
	if (strlen($titulo) <= 0) {
		$mensagem .= "Digite o título<br>";
	}
	if (strlen($mensagem) <= 0) {
		if ($cd_pensamento <= 0) {
			$cd_pensamento = inserir($tabela, $campos, $valores);
		} else {
			alterar($tabela, $campos, $valores, " where cd_pensamento=$cd_pensamento");
		}

		//grava imagens
		chmod($pasta, 0777);
		for ($i = 1; $i <= $imagens; $i++) {
			if (move_uploaded_file($_FILES["imagem_1"]["tmp_name"], $pasta . $tabela . "_" . $cd_pensamento . "_" . $i . ".jpg")) {
				apagaThumbs($pasta, $tabela, $cd_pensamento);
				$imagem = $tabela . "_" . $cd_pensamento . "_" . $i . ".jpg";
				//$imagem = redimensionaImagem($pasta, $imagem, 1024, 768);
				chmod($pasta . $imagem, 0755);
				mysql_query("update $tabela set imagem_" . $i . "='$imagem' where cd_pensamento=$cd_pensamento") or die(mysql_error());
			}
		}
		chmod($pasta, 0755);
		//header("location:$PHP_SELF?tipo_mensagem=sucesso&mensagem=$mensagem_alterado_inserido");
	} else {
		$tipo_mensagem = "falha";
		$acao = "cadastrar";
	}
} else if ($acao == "excluir") {
	$q1_query = mysql_query("select * from as_empresas where cd_pensamento=$cd_pensamento");
	$q1 = mysql_fetch_array($q1_query);
	if ((file_exists($pasta . $q1["imagem_1"])) && (!is_dir($pasta . $q1["imagem_1"]))) {
		unlink($pasta . $q1["imagem_1"]);
	}
	apagaThumbs($pasta, $tabela, $cd_pensamento . "_1");
	excluir($tabela, " where cd_pensamento=$cd_pensamento");
	header("location:$PHP_SELF?tipo_mensagem=sucesso&mensagem=$mensagem_excluido");
} else if ($acao == "excluir_imagem_1") {
	$q1_query = mysql_query("select * from as_empresas where cd_pensamento=$cd_pensamento");
	$q1 = mysql_fetch_array($q1_query);
	if ((file_exists($pasta . $q1["imagem_1"])) && (!is_dir($pasta . $q1["imagem_1"]))) {
		unlink($pasta . $q1["imagem_1"]);
	}
	apagaThumbs($pasta, $tabela, $cd_pensamento . "_1");
	$campos = array();
	$valores = array();
	$campos[] = "imagem_1";
	$valores[] = "";
	alterar($tabela, $campos, $valores, " where cd_pensamento=$cd_pensamento");
	header("location:$PHP_SELF?acao=cadastrar&cd_pensamento=$cd_pensamento&tipo_mensagem=sucesso&mensagem=$mensagem_imagem_excluido");
}
require("cabecalho.php");

if ($acao == "cadastrar") {
	$q1_query = mysql_query("select * from $tabela where cd_pensamento=$cd_pensamento") or die(mysql_error());
	$q1 = mysql_fetch_array($q1_query);
	if ($q1[0] <= 0) {
		$q1["data"] = "";
		$q1["titulo"] = "";
		$q1["texto"] = "";
		$q1["imagem_1"] = "";
	}
	?>
	<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
	<form method="post" action="<? echo $PHP_SELF; ?>" name="form" enctype="multipart/form-data">
	<input type="hidden" name="acao" value="gravar">
	<input type="hidden" name="cd_pensamento" value="<? echo $cd_pensamento; ?>">
	<tr>
		<td class="titulo" colspan="2" valign="top" class="pad-4">
			<? echo $titulo_cadastro; ?>
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
	?>
	<tr>
		<td class="pad-4">
			<label>Data</label>
		</td>
		<td class="pad-4">
			<input type="text" name="data" style="width:15%;" class="input" value="<? 
			if ($q1["data"] > 0) {
				echo inverterData($q1["data"]);
			} else {
				echo date("d/m/Y");
			}
			?>"> <input class="button" type="button" value="..." onclick="displayCalendar(document.form.data,'dd/mm/yyyy',this)">
		</td>
	</tr>
	<tr>
		<td class="pad-4" width="20%">
			<label>Título</label>
		</td>
		<td class="pad-4" width="80%">
			<input type="text" id="titulo" name="titulo" class="input x-large campo_obrigatorio" value="<? echo $q1["titulo"]; ?>">
		</td>
	</tr>
	<tr>
		<td class="pad-4">
			<label>Texto</label>
		</td>
		<td class="pad-4">
			<textarea name="texto" style="width:95%;height:200px;" class="input"><? echo $q1["texto"]; ?></textarea>
		</td>
	</tr>
	<?
	for ($i = 1; $i <= $imagens; $i++) {
		?>
		<tr>
			<td class="pad-4">
				<label>Imagem <? echo $i; ?></label>
			</td>
			<td class="pad-4">
				<?
				if ((file_exists($pasta . $q1["imagem_" . $i])) && (!is_dir($pasta . $q1["imagem_" . $i]))) {
					?>
					<img src="thumb.php?img=<? echo $pasta . $q1["imagem_" . $i]; ?>&w=100&h=60">&nbsp;<input type="button" value="Apagar esta foto" class="button" onclick="if (confirm('Deseja excluir esta imagem?')) { document.location='<? echo $PHP_SELF; ?>?cd_pensamento=<? echo $q1["cd_pensamento"]; ?>&acao=excluir_imagem_<? echo $i; ?>'; }">
					<?
				} else {	
					?>
					<input type="file" name="imagem_<? echo $i; ?>" class="input large" class="button">
					<?
				}
				?>
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
	<tr>
		<td class="pad-4" colspan="2">
			<input type="button" value=" < Voltar " class="button" onclick="document.location='<? echo $PHP_SELF; ?>';">
		</td>
	</tr>
	</form>
	</table>
	<?
} else {
	$colunas = 5;
	$count_query = mysql_query("select count(*) from $tabela");
	$count = mysql_fetch_array($count_query);
	?>
	<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
	<input type="hidden" name="acao" value="gravar">
	<tr>
		<td class="titulo" valign="top" colspan="<? echo $colunas; ?>" class="pad-4">
			<? echo $titulo_consulta; ?>
		</td>
	</tr>
	<tr>
		<td height="2" bgcolor="#cccccc" colspan="<? echo $colunas; ?>"></td>
	</tr>
	<tr>
		<td height="4" colspan="<? echo $colunas; ?>"></td>
	</tr>
	<?
	if (strlen($mensagem) > 0) {
		?>
		<tr>
			<td colspan="<? echo $colunas; ?>">
				<div class="<? echo $tipo_mensagem; ?> x-large png_bg"><? echo $mensagem; ?></div>
			</td>
		</tr>
		<?
	}
	if ($count[0] > 0) {
		?>
		<tr>
			<td width="20%" class="pad-4">
				<b>Data</b>
			</td>
			<td width="30%" class="pad-4">
				<b>Título</b>
			</td>
			<td width="10%" class="pad-4">
				<b>Texto</b>
			</td>
			<td width="20%" class="pad-4">
				<b>Imagem</b>
			</td>
			<td width="20%" class="pad-4">
				<b>Opções</b>
			</td>
		</tr>
		<?
		$cor = "#eeeeee";
		$q1_query = mysql_query("select * from $tabela order by data") or die(mysql_error());
		while ($q1 = mysql_fetch_array($q1_query)) {
			if ($cor == "#eeeeee") {
				$cor = "#ffffff";
			} else {
				$cor = "#eeeeee";
			}
			?>
			<tr onmouseover="this.style.backgroundColor='#d1ffdc';" onmouseout="this.style.backgroundColor='<? echo $cor; ?>';" bgcolor="<? echo $cor; ?>">
				<td class="pad-4" style="line-height:14px;">
					<? echo inverterData($q1["data"]); ?>
				</td>
				<td class="pad-4" style="line-height:14px;">
					<? echo $q1["titulo"]; ?>
				</td>
				<td class="pad-4" style="line-height:14px;">
					<?
					echo substr(strip_tags($q1["texto"], "<strong><b>"), 0, strrpos(substr(strip_tags($q1["texto"], "<strong><b>"), 0, 50), " ") + 1);
					?>
				</td>
				<td class="pad-4">
					<img src="thumb.php?img=<? echo $pasta . $q1["imagem_1"]; ?>&w=100&h=40" border="0">
				</td>
				<td class="pad-4">
					<?
					if ($pppp_nivel > 0) {
						?>
						<input type="button" value=" Editar " class="button" onclick="document.location='<? echo $PHP_SELF; ?>?acao=cadastrar&cd_pensamento=<? echo $q1["cd_pensamento"]; ?>';"><input type="button" value=" Excluir " class="button" onclick="if (confirm('<? echo $pergunta_exclusao; ?>')) { document.location='<? echo $PHP_SELF; ?>?acao=excluir&cd_pensamento=<? echo $q1["cd_pensamento"]; ?>'; }" style="margin-left:5px;">
						<?
					} else {
						?>
						<input type="button" value=" Visualizar " class="button" onclick="document.location='<? echo $PHP_SELF; ?>?acao=cadastrar&cd_pensamento=<? echo $q1["cd_pensamento"]; ?>';">
						<?
					}
					?>
				</td>
			</tr>
			<tr>
				<td height="1" bgcolor="#cccccc" colspan="<? echo $colunas; ?>"></td>
			</tr>
			<?
		}
	} else {
		?>
		<tr>
			<td>
				<div class="falha x-large png_bg"><? echo $mensagem_erro_sem_cadastrados; ?></div>
			</td>
		</tr>
		<?
	}
	?>
	</table>
	<?
}
require("rodape.php");
?>