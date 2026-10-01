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

$tabela = "galerias_usuarios";
$titulo_cadastro = "Cadastro de usuários";
$titulo_consulta = "Consulta de usuários";
$mensagem_alterado_inserido = "O registro foi adicionado/alterado com sucesso";
$mensagem_excluido = "O registro foi excluído com sucesso";
$mensagem_imagem_excluido = "A imagem foi excluída com sucesso";
$pergunta_exclusao = "Tem certeza de que deseja excluir este registro?";
$mensagem_erro_sem_cadastrados = "NÃO HÁ USUÁRIOS CADASTRADAS";

//parametros padrao
if (isset($_REQUEST["acao"])) { $acao = $_REQUEST["acao"]; } else { $acao = ""; }
if (isset($_REQUEST["cd_usuario"])) { $cd_usuario = $_REQUEST["cd_usuario"]; } else { $cd_usuario = 0; }
if (isset($_REQUEST["tipo_mensagem"])) { $tipo_mensagem = $_REQUEST["tipo_mensagem"]; } else { $tipo_mensagem = ""; }
if (isset($_REQUEST["mensagem"])) { $mensagem = $_REQUEST["mensagem"]; } else { $mensagem = ""; }

//parametros para gravacao
if (isset($_REQUEST["usuario"])) { $usuario = $_REQUEST["usuario"]; } else { $usuario = ""; }
if (isset($_REQUEST["senha"])) { $senha = $_REQUEST["senha"]; } else { $senha = ""; }

if ($acao == "gravar") {
	$campos = array();
	$valores = array();
	$campos[] = "usuario";
	$campos[] = "senha";
	$valores[] = $usuario;
	$valores[] = $senha;
	if (strlen($usuario) <= 0) {
		$mensagem .= "Digite o usuário<br>";
	}
	if (strlen($mensagem) <= 0) {
		if ($cd_usuario <= 0) {
			$cd_usuario = inserir($tabela, $campos, $valores);
		} else {
			alterar($tabela, $campos, $valores, " where cd_usuario=$cd_usuario");
		}
		//header("location:$PHP_SELF?tipo_mensagem=sucesso&mensagem=$mensagem_alterado_inserido");
	} else {
		$tipo_mensagem = "falha";
		$acao = "cadastrar";
	}
} else if ($acao == "excluir") {
	excluir($tabela, " where cd_usuario=$cd_usuario");
	header("location:$PHP_SELF?tipo_mensagem=sucesso&mensagem=$mensagem_excluido");
}
require("cabecalho.php");

if ($acao == "cadastrar") {
	$q1_query = mysql_query("select * from $tabela where cd_usuario=$cd_usuario") or die(mysql_error());
	$q1 = mysql_fetch_array($q1_query);
	if ($q1[0] <= 0) {
		$q1["usuario"] = "";
		$q1["senha"] = "";
	}
	?>
	<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
	<form method="post" action="<? echo $PHP_SELF; ?>" name="form" enctype="multipart/form-data">
	<input type="hidden" name="acao" value="gravar">
	<input type="hidden" name="cd_usuario" value="<? echo $cd_usuario; ?>">
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
		<td class="pad-4" width="20%">
			<label>Usuário</label>
		</td>
		<td class="pad-4" width="80%">
			<input type="text" name="usuario" class="input medium campo_obrigatorio" value="<? echo $q1["usuario"]; ?>">
		</td>
	</tr>
	<tr>
		<td class="pad-4" width="20%">
			<label>Senha</label>
		</td>
		<td class="pad-4" width="80%">
			<input type="text" name="senha" class="input small" value="<? echo $q1["senha"]; ?>">
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
	$colunas = 3;
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
			<td width="40%" class="pad-4">
				<b>Usuário</b>
			</td>
			<td width="40%" class="pad-4">
				<b>Senha</b>
			</td>
			<td width="20%" class="pad-4">
				<b>Opções</b>
			</td>
		</tr>
		<?
		$cor = "#eeeeee";
		$q1_query = mysql_query("select * from $tabela order by usuario") or die(mysql_error());
		while ($q1 = mysql_fetch_array($q1_query)) {
			if ($cor == "#eeeeee") {
				$cor = "#ffffff";
			} else {
				$cor = "#eeeeee";
			}
			?>
			<tr onmouseover="this.style.backgroundColor='#d1ffdc';" onmouseout="this.style.backgroundColor='<? echo $cor; ?>';" bgcolor="<? echo $cor; ?>">
				<td class="pad-4" style="line-height:14px;">
					<? echo $q1["usuario"]; ?>
				</td>
				<td class="pad-4" style="line-height:14px;">
					<? echo $q1["senha"]; ?>
				</td>
				<td class="pad-4">
					<?
					if ($pppp_nivel > 0) {
						?>
						<input type="button" value=" Editar " class="button" onclick="document.location='<? echo $PHP_SELF; ?>?acao=cadastrar&cd_usuario=<? echo $q1["cd_usuario"]; ?>';"><input type="button" value=" Excluir " class="button" onclick="if (confirm('<? echo $pergunta_exclusao; ?>')) { document.location='<? echo $PHP_SELF; ?>?acao=excluir&cd_usuario=<? echo $q1["cd_usuario"]; ?>'; }" style="margin-left:5px;">
						<?
					} else {
						?>
						<input type="button" value=" Visualizar " class="button" onclick="document.location='<? echo $PHP_SELF; ?>?acao=cadastrar&cd_usuario=<? echo $q1["cd_usuario"]; ?>';">
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