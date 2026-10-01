<div style="position:relative;width:100%;height:59px;">
	<a href="index.php"><div style="float:left;cursor:pointer;" onmouseover="document.getElementById('item-01').src='../images/item-01-over.jpg';" onmouseout="document.getElementById('item-01').src='../images/item-01.jpg';"><img src="../images/item-01.jpg" id="item-01"></div></a>
	<a href="nossa-escola.php"><div style="float:left;cursor:pointer" onmouseover="document.getElementById('item-02').src='../images/item-02-over.jpg';" onmouseout="document.getElementById('item-02').src='../images/item-02.jpg';" onclick="document.location='';"  class="menu-1"><img src="../images/item-02.jpg" id="item-02"></div></a>
	<a href="visita-virtual.php"><div style="float:left;cursor:pointer" onmouseover="document.getElementById('item-03').src='../images/item-03-over.jpg';" onmouseout="document.getElementById('item-03').src='../images/item-03.jpg';"><img src="../images/item-03.jpg" id="item-03"></div></a>
	<a href="depoimentos.php"><div style="float:left;cursor:pointer" onmouseover="document.getElementById('item-04').src='../images/item-04-over.jpg';" onmouseout="document.getElementById('item-04').src='../images/item-04.jpg';"><img src="../images/item-04.jpg" id="item-04"></div></a>
	<a href="area-restrita.php"><div style="float:left;cursor:pointer" onmouseover="document.getElementById('item-05').src='../images/item-05-over.jpg';" onmouseout="document.getElementById('item-05').src='../images/item-05.jpg';"><img src="../images/item-05.jpg" id="item-05"></div></a>
	<a href="localizacao.php"><div style="float:left;cursor:pointer" onmouseover="document.getElementById('item-06').src='../images/item-06-over.jpg';" onmouseout="document.getElementById('item-06').src='../images/item-06.jpg';"><img src="../images/item-06.jpg" id="item-06"></div></a>
	<a href="contato.php"><div style="float:left;cursor:pointer" onmouseover="document.getElementById('item-07').src='../images/item-07-over.jpg';" onmouseout="document.getElementById('item-07').src='../images/item-07.jpg';"><img src="../images/item-07.jpg" id="item-07"></div></a>
	<div style="clear:left;"></div>

	<div class="submenu-1">
		<div style="height:7px;"><!-- --></div>
		<a href="educacao-infantil.php" >Educa&ccedil;&atilde;o Infantil</a><br>
		<a href="ensino-fundamental.php" >Ensino Fundamental</a><br>
		<a href="nossos-diferenciais.php" >Nossos Diferenciais</a><br>
		<a href="educacao-por-principios.php" >Educa&ccedil;&atilde;o por Princ&iacute;pios</a>
		<div style="height:7px;"><!-- --></div>
	</div>

	<script type="text/javascript">
		var tempoSumir = 0;
		var timerSubmenu1=0;
		$('.submenu-1').hide();
		$('.menu-1').mouseover(function(){
			$('.submenu-1').fadeIn(150);
			clearTimeout(timerSubmenu1);
		});
		$('.menu-1').mouseout(function(){
			timerSubmenu1 = setTimeout("$('.submenu-1').fadeOut(150)", tempoSumir);
		});
		$('.submenu-1').mouseenter(function(){
			$('.submenu-1').fadeIn(150);
			clearTimeout(timerSubmenu1);
		});
		$('.submenu-1').mouseleave(function(){
			timerSubmenu1 = setTimeout("$('.submenu-1').fadeOut(150)", tempoSumir);
		});
	</script>
</div>