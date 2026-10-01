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

$tabela = "galerias";
$titulo_cadastro = "Cadastro de galerias";
$titulo_consulta = "Consulta de galerias";
$mensagem_alterado_inserido = "O registro foi adicionado/alterado com sucesso";
$mensagem_excluido = "O registro foi excluído com sucesso";
$pergunta_exclusao = "Tem certeza de que deseja excluir este registro?";
$mensagem_erro_sem_cadastrados = "NÃO HÁ GALERIAS CADASTRADAS";

//parametros padrao
if (isset($_REQUEST["acao"])) { $acao = $_REQUEST["acao"]; } else { $acao = ""; }
if (isset($_REQUEST["cd_galeria"])) { $cd_galeria = $_REQUEST["cd_galeria"]; } else { $cd_galeria = 0; }
if (isset($_REQUEST["tipo_mensagem"])) { $tipo_mensagem = $_REQUEST["tipo_mensagem"]; } else { $tipo_mensagem = ""; }
if (isset($_REQUEST["mensagem"])) { $mensagem = $_REQUEST["mensagem"]; } else { $mensagem = ""; }

//parametros para gravacao
if (isset($_REQUEST["titulo"])) { $titulo = $_REQUEST["titulo"]; } else { $titulo = ""; }
if (isset($_REQUEST["data"])) { $data = $_REQUEST["data"]; } else { $data = ""; }
if (isset($_REQUEST["texto"])) { $texto = $_REQUEST["texto"]; } else { $texto = ""; }
if (isset($_REQUEST["area_restrita"])) { $area_restrita = $_REQUEST["area_restrita"]; } else { $area_restrita = 0; }

if ($acao == "gravar") {
	$campos = array();
	$valores = array();
	$campos[] = "data";
	$campos[] = "titulo";
	$campos[] = "texto";
	$campos[] = "area_restrita";
	$valores[] = formatarData($data);
	$valores[] = $titulo;
	$valores[] = $texto;
	$valores[] = $area_restrita;
	if (strlen($titulo) <= 0) {
		$mensagem .= "Digite o título<br>";
	}
	if (strlen($mensagem) <= 0) {
		if ($cd_galeria <= 0) {
			$cd_galeria = inserir($tabela, $campos, $valores);
		} else {
			alterar($tabela, $campos, $valores, " where cd_galeria=$cd_galeria");
		}
		header("location:$PHP_SELF?tipo_mensagem=sucesso&mensagem=$mensagem_alterado_inserido");
	} else {
		$tipo_mensagem = "falha";
		$acao = "cadastrar";
	}
} else if ($acao == "excluir") {
	$q1_query = mysql_query("select count(*) from fotos where cd_galeria=$cd_galeria");
	$q1 = mysql_fetch_array($q1_query);
	if ($q1[0] <= 0) {
		excluir($tabela, " where cd_galeria=$cd_galeria");
		header("location:$PHP_SELF?tipo_mensagem=sucesso&mensagem=$mensagem_excluido");
	} else {
		header("location:$PHP_SELF?tipo_mensagem=sucesso&mensagem=Não é possível excluir, apague todas as fotos primeiro");
	}
}
require("cabecalho.php");

if ($acao == "cadastrar") {
	$q1_query = mysql_query("select * from $tabela where cd_galeria=$cd_galeria") or die(mysql_error());
	$q1 = mysql_fetch_array($q1_query);
	if ($q1[0] <= 0) {
		$q1["data"] = "";
		$q1["titulo"] = "";
		$q1["texto"] = "";
	}
	?>
	<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
	<form method="post" action="<? echo $PHP_SELF; ?>" name="form" enctype="multipart/form-data">
	<input type="hidden" name="acao" value="gravar">
	<input type="hidden" name="cd_galeria" value="<? echo $cd_galeria; ?>">
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
		<td class="pad-4">
			<label style="line-height:14px;">Somente para Área Restrita?</label>
		</td>
		<td class="pad-4">
			<select name="area_restrita" class="select">
			<?
			$aux = array("Sim", "Não");
			foreach ($aux as $aux2) {
				if ($q1["area_restrita"] == 0) {
					$aux3 = "Não";
				} else {
					$aux3 = "Sim";
				}
				if ($aux2 == $aux3) {
					if ($aux2 == "Não") { $aux4 = "0"; } else { $aux4 = "1"; }
					?>
					<option value="<? echo $aux4; ?>" selected><? echo $aux2; ?></option>
					<?
				} else {
					if ($aux2 == "Não") { $aux4 = "0"; } else { $aux4 = "1"; }
					?>
					<option value="<? echo $aux4; ?>"><? echo $aux2; ?></option>
					<?
				}
			}
			?>
			</select>
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
	$colunas = 6;
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
			<td width="10%" class="pad-4">
				<b>Área Restrita?</b>
			</td>
			<td width="10%" class="pad-4">
				<b>Data</b>
			</td>
			<td width="20%" class="pad-4">
				<b>Título</b>
			</td>
			<td width="20%" class="pad-4">
				<b>Texto</b>
			</td>
			<td width="5%" class="pad-4">
				<b>Fotos</b>
			</td>
			<td width="35%" class="pad-4">
				<b>Opções</b>
			</td>
		</tr>
		<?
		$cor = "#eeeeee";
		$q1_query = mysql_query("select * from galerias order by data") or die(mysql_error());
		while ($q1 = mysql_fetch_array($q1_query)) {
			if ($cor == "#eeeeee") {
				$cor = "#ffffff";
			} else {
				$cor = "#eeeeee";
			}
			?>
			<tr onmouseover="this.style.backgroundColor='#d1ffdc';" onmouseout="this.style.backgroundColor='<? echo $cor; ?>';" bgcolor="<? echo $cor; ?>">
				<td class="pad-4" style="line-height:14px;">
					<?
					if ($q1["area_restrita"] == 0) {
						?>
						Não
						<?
					} else {
						?>
						Sim
						<?
					}
					?>
				</td>
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
				<td class="pad-4" style="line-height:14px;text-align:center;">
					<? 
					$q2_query = mysql_query("select count(*) from fotos where cd_galeria=" . $q1["cd_galeria"]);
					$q2 = mysql_fetch_array($q2_query);
					echo $q2[0];
					?>
				</td>
				<td class="pad-4">
					<?
					if ($pppp_nivel > 0) {
						?>
						<input type="button" value=" Add fotos " class="button" onclick="document.location='fotos.php?acao=cadastrar&cd_galeria=<? echo $q1["cd_galeria"]; ?>';">
						<input type="button" value=" Editar " class="button" onclick="document.location='<? echo $PHP_SELF; ?>?acao=cadastrar&cd_galeria=<? echo $q1["cd_galeria"]; ?>';" style="margin-left:5px;">
						<input type="button" value=" Excluir " class="button" onclick="if (confirm('<? echo $pergunta_exclusao; ?>')) { document.location='<? echo $PHP_SELF; ?>?acao=excluir&cd_galeria=<? echo $q1["cd_galeria"]; ?>'; }" style="margin-left:5px;">
						<?
					} else {
						?>
						<input type="button" value=" Visualizar " class="button" onclick="document.location='<? echo $PHP_SELF; ?>?acao=cadastrar&cd_galeria=<? echo $q1["cd_galeria"]; ?>';">
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