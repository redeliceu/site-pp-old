<?
function inserir($tabela, $campos, $valores) {
	$i = "0";
	foreach($campos as $campo) {
		$campo = str_replace("'", "", $campo);
		if ($i == "0") {
			$i = "1";
			$texto_campo = $campo;
		} else {
			$texto_campo = $texto_campo . ", " . $campo;
		}
	}
	$i = "0";
	foreach($valores as $valor) {
		$valor = str_replace("'", "", $valor);
		if ($i == "0") {
			$i = "1";
			$texto_valor = "'" . $valor . "'";
		} else {
			$texto_valor = $texto_valor . ", '" . $valor . "'";
		}
	}
	if ($tabela == "mostrar") {
		echo "insert into $tabela($texto_campo) values($texto_valor)";
	} else {
		mysql_query("insert into $tabela($texto_campo) values($texto_valor)") or die(mysql_error());
		$ultimo_cd_query = mysql_query("select last_insert_id() from $tabela");
		$ultimo_cd = mysql_fetch_array($ultimo_cd_query);
		return $ultimo_cd[0];
	}
}

function alterar($tabela, $campos, $valores, $condicao) {
	$i = "0";
	$k = 0;
	foreach($campos as $campo) {
		$campo = str_replace("'", "", $campo);
		$valor = str_replace("'", "", $valores[$k]);
		if ($i == "0") {
			$i = "1";
			$texto_campo = $campo . "='" . $valor . "'";
		} else {
			$texto_campo = $texto_campo . ", " . $campo . "='" . $valor . "'";
		}
		$k++;
	}
	if ($tabela == "mostrar") {
		echo "update $tabela set $texto_campo $condicao";
	} else {
		mysql_query("update $tabela set $texto_campo $condicao") or die(mysql_error());
	}
}

function consultar($query) {
	$query = mysql_query($query) or die(mysql_error());
	return $query;
}

function excluir($tabela, $condicao) {
	mysql_query("delete from $tabela $condicao") or die(mysql_error());
}

function verificaImagem($arquivo, $pasta, $imagem, $largura, $altura) {
	$thumb = $imagem .'.thumb_'.$largura.'x'.$altura.'.jpg';
	if (file_exists($pasta . $thumb) && !is_dir($pasta . $thumb)) {
		return $pasta . $thumb;
	} else {
		return $arquivo . "?img=" . $pasta . $imagem . "&w=" . $largura . "&h=" . $altura;
	}
}

function redimensionaImagem($pasta, $imagem, $width, $height) {
	$file = eregi_replace( '\.([a-z]{3,4})$', "-{$width}x{$height}.\\1", $pasta . $imagem );
	if(file_exists($pasta . $imagem) && !is_dir($pasta . $imagem)) {
		$img = @imagecreatefromjpeg($pasta . $imagem);
		$largura = imagesx($img);
		$altura = imagesy($img);
		if (($largura > $width) || ($altura > $height)) {
			$src = $pasta . $imagem; // original picture to be resized
			$dst = $pasta . str_replace($pasta, "", $file); // name of the resamplee (ie. path\image-78x88.jpg )
			$i = getimagesize($src); // need to know type
			switch ($i[2]) {
			case 2: // JPG
				$cmd = "djpeg '$src'|pnmscale -xysize $width $height|cjpeg -quality 80 > '$dst'";
				break;
			}
			$res = exec($cmd); // Do the actual operation
			unlink($pasta . $imagem);
			chmod($file, 0777);
			return str_replace($pasta, "", $file); // Use the resampled image
		} else {
			chmod($pasta . $imagem, 0777);
			return $imagem;
		}		
	}
	$width = $height = ""; // and it's own properties
}

function apagaThumbs($pasta, $tabela, $codigo) {
	$dir = opendir($pasta);
	while (($file = readdir($dir)) !== false) {
		if ((strpos($file, substr($tabela . "_" . $codigo, 1, strlen($tabela))) > 0) && ((strpos($file, "_$codigo.jpg.thumb_") > 0)) || ((strpos($file, "_$codigo-1024x768.jpg.thumb_") > 0))) {
			unlink($pasta . $file);
		}
	}
	closedir($dir);
}

function apagaTodosThumbs($pasta, $codigo, $numero) {
	$dir = opendir($pasta);
	while (($file = readdir($dir)) !== false) {
		if (strpos($file, ".thumb_") > 0) {
			unlink($pasta . $file);
		}
	}
	closedir($dir);
}

function inverterData($data) {
	return substr($data, 6, 2) . "/" . substr($data, 4, 2) . "/" . substr($data, 0, 4);
}

function inverterHora($hora) {
	return substr($hora, 0, 2) . ":" . substr($hora, 2, 2);
}

function formatarData($data) {
	return substr($data, 6, 4) . substr($data, 3, 2) . substr($data, 0, 2);
}

function retiraAcentos($var) {
	$var = ereg_replace("[áàâãª]","a",$var);
	$var = ereg_replace("[ÁÀÂÃª]","A",$var);
	$var = ereg_replace("[éèê]","e",$var);
	$var = ereg_replace("[ÉÈÊ]","E",$var);
	$var = ereg_replace("[óòôõº]","o",$var);	
	$var = ereg_replace("[ÓÒÔÕº]","O",$var);
	$var = ereg_replace("[úùû]","u",$var);	
	$var = ereg_replace("[ÚÙÛ]","U",$var);
	$var = ereg_replace("[í]","i",$var);	
	$var = ereg_replace("[Í]","I",$var);
	$var = str_replace("ç","c",$var);
	$var = str_replace("Ç","C",$var);
	$var = strtolower($var);
	
	return $var;
}



function retiraEspacos($caracter, $texto) {
	return str_replace(" ", $caracter, str_replace("  ", " ", str_replace(" - ", " ", retiraAcentos($texto))));
}

function montarLink ($texto)
{
       if (!is_string ($texto))
           return $texto;

    $er = "/(http:\/\/(www\.|.*?\/)?|www\.)([a-zA-Z0-9]+|_|-)+(\.(([0-9a-zA-Z]|-|_|\/|\?|=|&)+))+/i";
    preg_match_all ($er, $texto, $match);

    foreach ($match[0] as $link)
    {
        //coloca o 'http://' caso o link não o possua
        $link_completo = (stristr($link, "http://") === false) ? "http://" . $link : $link;

        $link_len = strlen ($link);


        //troca "&" por "&", tornando o link válido pela W3C
       $web_link = str_replace ("&", "&amp;", $link_completo);
       $texto = str_ireplace ($link, "<a href=\"" . strtolower($web_link) . "\" target=\"_blank\"><b><u>". (($link_len > 60) ? substr ($web_link, 0, 25). "...". substr ($web_link, -15) : $web_link) ."</b></u></a>", $texto);

    }

    return $texto;

}


function encrypt($string, $key="123456789012345678901234567890123456789012345678901234567890") {
    $encrypted = mcrypt_cbc(MCRYPT_RIJNDAEL_128,substr($key,0,32) ,$string,MCRYPT_ENCRYPT,substr($key,32,16));
	return $encrypted;
}
?>