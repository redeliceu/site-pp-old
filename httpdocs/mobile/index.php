<!DOCTYPE html> 
<?
if (isset($_REQUEST["ac"])) { $ac = $_REQUEST["ac"]; } else { $ac = ""; }
if (isset($_REQUEST["cdc"])) { $cdc = $_REQUEST["cdc"]; } else { $cdc = ""; }
?>
<html> 
	<head> 
	<title>Yasoft - Teste</title> 
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.0a3/jquery.mobile-1.0a3.min.css" />
<script src="http://code.jquery.com/jquery-1.5.min.js"></script>
<script src="http://code.jquery.com/mobile/1.0a3/jquery.mobile-1.0a3.min.js"></script>
</head> 
<body> 

<?
if ($ac == "") {
	?>
	<div data-role="page" id="foo">

		<div data-role="header">
			<h1>Yasoft</h1>
		</div>
		<!-- content -->
		<div data-role="content">	
			<div><center><img src="images/logo.png" border="0"></center></div>
			<div class="ui-grid-a">
				<div class="ui-block-a"><center><h2>Cadastrar</h2></center></div>
				<div class="ui-block-b"><center><h2>Consultar</h2></center></div>
			</div><!-- /grid-a -->
			<fieldset class="ui-grid-a">
				<div class="ui-block-a"><a href="index.php?ac=cad_clientes" data-role="button">Clientes</a></div>
				<div class="ui-block-b"><a href="index.php?ac=con_clientes" data-role="button">Clientes</a> </div>	   
			</fieldset>
			<!--<fieldset class="ui-grid-a">
				<div class="ui-block-a"><a href="#cad-produtos" data-role="button">Produtos</a></div>
				<div class="ui-block-b"><a href="#con-produtos" data-role="button">Produtos</a> </div>	   
			</fieldset>
			<!-- /grid-b -->
		</div>
		<!-- /content -->
		<div data-role="footer">
			<h4>Inotech Informática</h4>
		</div>
	</div>
	<?
} else if ($ac == "cad_clientes") {
	?>
	<div data-role="page" id="cad-clientes">
		<div data-role="header">
			<h1>Cadastro clientes</h1>
		</div>
		<div data-role="content">	
			<!-- content -->
			<div data-role="fieldcontain">
				<label for="name">Nome:</label>
				<input type="text" name="nome" id="nome" value=""  />
			</div>
			<div data-role="fieldcontain">
				<label for="name">Endereço:</label>
				<input type="text" name="endereco" id="endereco" value=""  />
			</div>
			<div data-role="fieldcontain">			
				<label for="textarea">Observações:</label>
				<textarea cols="40" rows="8" name="observacoes" id="observacoes"></textarea>
			</div>
			<fieldset class="ui-grid-a">
				<div class="ui-block-a"><button type="reset">Cancelar</button></div>
				<div class="ui-block-b"><button type="submit">Gravar</button></div>	   
			</fieldset>
			<!-- content -->
		</div>
		<div data-role="footer" class="ui-bar">
			<a href="index.php" data-role="button" data-icon="arrow-l">Voltar</a>
		</div>
	</div>
	<?
} else if ($ac == "con_clientes") {
	if ($cdc > 0) {
		?>
		<div data-role="page" id="con-clientes">
			<div data-role="header">
				<h1>Consulta clientes</h1>
			</div>
			<!-- content -->
			<?
			if ($cdc == 1) {
				?>
				<div data-role="content">	
					<p>Cliente: Jones</p>
					<p>Endereço: Av. São Paulo, 410 - sala -5</p>
					<p>Observações: Teste... gravação não funciona ainda</p>
				</div>
				<?
			} else if ($cdc == 2) {
				?>
				<div data-role="content">	
					<p>Cliente: Alexandre</p>
					<p>Endereço: Av. São Paulo, 410 - sala -5</p>
					<p>Observações: Teste... gravação não funciona ainda</p>
				</div>
				<?
			} else if ($cdc == 3) {
				?>
				<div data-role="content">	
					<p>Cliente: Alberto</p>
					<p>Endereço: R. Francisco Martins, 373</p>
					<p>Observações: Teste... gravação não funciona ainda</p>
				</div>
				<?
			}
			?>
			<!-- /content -->
			<div data-role="footer" class="ui-bar">
				<a href="index.php?ac=con_clientes" data-role="button" data-icon="arrow-l" data-theme="a">Voltar</a>
			</div>
		</div>
		<?
	} else {
		?>
		<div data-role="page" id="con-clientes">
			<div data-role="header">
				<h1>Consulta clientes</h1>
			</div>
			<!-- content -->
			<div data-role="content">	
				<ul data-role="listview" data-inset="true">
				  <li><a href="index.php?ac=con_clientes&cdc=1">Jones</a></li>
				  <li><a href="index.php?ac=con_clientes&cdc=2">Alexandre</a></li>
				  <li><a href="index.php?ac=con_clientes&cdc=3">Alberto</a></li>
				</ul>
			
			</div>
			<!-- /content -->
			<div data-role="footer" class="ui-bar">
				<a href="index.php" data-role="button" data-icon="arrow-l">Voltar</a>
			</div>
		</div>
		<?
	}
}
?>
</body>

</body>
</html>
