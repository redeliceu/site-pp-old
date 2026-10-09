<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<?
	if (strpos($PHP_SELF, "login.php") > 0) {
		?>
		<link href="admin.css" rel="stylesheet" type="text/css" />
		<?
	} else {
		?>
		<link href="estilo.css" rel="stylesheet" type="text/css" />
		<?
	}
	?>
	<link type="text/css" rel="stylesheet" href="../mini_calendario/dhtmlgoodies_calendar.css" media="screen">
	</LINK>
	<SCRIPT type="text/javascript" src="../mini_calendario/dhtmlgoodies_calendar.js"></script>
	<link rel="stylesheet" href="windowfiles/dhtmlwindow.css" type="text/css" />
	<script type="text/javascript" src="windowfiles/dhtmlwindow.js"></script>
	<link rel="stylesheet" href="modalfiles/modal.css" type="text/css" />
	<script type="text/javascript" src="modalfiles/modal.js"></script>
	<link href="blue.css" rel="stylesheet" type="text/css" />
	<SCRIPT LANGUAGE="JavaScript">
		function MascaraMoeda(objTextBox, SeparadorMilesimo, SeparadorDecimal, e) {
			var sep = 0;
			var key = '';
			var i = j = 0;
			var len = len2 = 0;
			var strCheck = '0123456789';
			var aux = aux2 = '';
			var whichCode = (window.Event) ? e.which : e.keyCode;
			if (e.keyCode == 9) return true;
			var t = new String(objTextBox.value);
			if (whichCode == 8) {
				objTextBox.value = t.substring(0, t.length - 1);
			}
			key = String.fromCharCode(whichCode); // Valor para o código da Chave
			if (strCheck.indexOf(key) == -1) return false; // Chave inválida
			len = objTextBox.value.length;
			for (i = 0; i < len; i++)
				if ((objTextBox.value.charAt(i) != '0') && (objTextBox.value.charAt(i) != SeparadorDecimal)) break;
			aux = '';
			for (; i < len; i++)
				if (strCheck.indexOf(objTextBox.value.charAt(i)) != -1) aux += objTextBox.value.charAt(i);
			aux += key;
			len = aux.length;
			if (len == 0) objTextBox.value = '';
			if (len == 1) objTextBox.value = '0' + SeparadorDecimal + '0' + aux;
			if (len == 2) objTextBox.value = '0' + SeparadorDecimal + aux;
			if (len > 2) {
				aux2 = '';
				for (j = 0, i = len - 3; i >= 0; i--) {
					if (j == 3) {
						aux2 += SeparadorMilesimo;
						j = 0;
					}
					aux2 += aux.charAt(i);
					j++;
				}
				objTextBox.value = '';
				len2 = aux2.length;
				for (i = len2 - 1; i >= 0; i--)
					objTextBox.value += aux2.charAt(i);
				objTextBox.value += SeparadorDecimal + aux.substr(len - 2, len);
			}
			return false;
		}
	</script>
	<script language="javascript" type="text/javascript" src="../tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
	<script language="javascript" type="text/javascript" src="../tinymce/jscripts/general.js"></script>
	<script language="javascript" type="text/javascript">
		tinyMCE.init({
			// General options 
			mode: "exact",
			elements: "elm1",
			theme: "advanced",
			skin: "o2k7",
			skin_variant: "silver",
			plugins: "safari,pagebreak,style,layer,table,advlink",

			// Theme options 
			theme_advanced_buttons1: "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,fontselect,fontsizeselect,forecolor,link,unlink,|,code",
			theme_advanced_buttons2: "",
			theme_advanced_buttons3: "",
			theme_advanced_buttons4: "",
			theme_advanced_toolbar_location: "top",
			theme_advanced_toolbar_align: "left",
			//theme_advanced_statusbar_location : "bottom", 
			theme_advanced_resizing: true
		});
	</script>
	<title>PAINEL DE CONTROLE - Colégio Pequeno Príncipe</title>
</head>

<body>
	<div id="conteudo">
		<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td background="images/fundo-cabecalho.jpg" height="100">
					<p class="titulo" style="margin-left:40px;">
						<font color="#ffffff">PAINEL DE CONTROLE - Colégio Pequeno Príncipe</font>
					</p>
					<!--<img src="../images/logo.png" border="0" style="margin-left:40px;">-->
				</td>
			</tr>
			<tr>
				<td height="2" bgcolor="#cccccc"></td>
			</tr>
			<tr>
				<td height="15"></td>
			</tr>
			<tr>
				<td align="center" bgcolor="#ffffff">
					<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0"
						style="border:1px solid #cccccc;margin-left:auto;margin-right:auto;">
						<tr>
							<td align="center" valign="top" width="25%" bgcolor="#ffffff" style="padding:15px;">
								<?
								require("menu.php");
								?>
							</td>
							<td width="75%" valign="top">
								<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td style="padding:15px;" valign="top">