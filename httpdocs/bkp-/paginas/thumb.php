<?php
$lmaximo = $_GET["w"];
$amaximo = $_GET["h"];
$img = @imagecreatefromjpeg($_GET["img"]);
$largura = imagesx($img);
$altura = imagesy($img);
$largura_r = imagesx($img);
if ($largura_r <= 2500) {
	$altura_r = imagesy($img);
	if ($lmaximo <= 0) {
		$lmaximo = $largura_r;
	}
	if ($amaximo <= 0) {
		$amaximo = $altura_r;
	}
	if ($largura >= $lmaximo) {
		$altura = (int)($altura * ($lmaximo/$largura));
		$largura = $lmaximo;
	}
	if ($altura >= $amaximo) {
		$largura = (int)($largura * ($amaximo/$altura));
		$altura = $amaximo;
	}
	header('Content-type: image/jpeg');
	$filename = $_GET['img'] .'.thumb_'.$lmaximo.'x'.$amaximo.'.jpg';
	if (file_exists($filename)) {
		$src = imagecreatefromjpeg($filename);
		imagejpeg($src, null, 80);
	} else {
		$filename = $_GET['img'];
		if (file_exists($filename)) {
			$tmp_img = imagecreatetruecolor($largura,$altura);
			$th_bg_color = imagecolorallocate($tmp_img, 255, 255, 255);
			imagefill($tmp_img, 0, 0, $th_bg_color);
			imagecolortransparent($tmp_img, $th_bg_color);
			$src = imagecreatefromjpeg($_GET['img']);
			imagecopyresampled($tmp_img, $src, 0, 0, 0, 0, $largura, $altura, $largura_r, $altura_r);
			imagejpeg($tmp_img, null, 80);
			imagejpeg($tmp_img,$_GET['img'].'.thumb_'.$lmaximo.'x'.$amaximo.'.jpg', 80);
			imagedestroy($src);
			imagedestroy($tmp_img);
		} else {
			$tmp_img = imagecreatetruecolor($largura,$altura);
			$th_bg_color = imagecolorallocate($tmp_img, 255, 255, 255);
			imagefill($tmp_img, 0, 0, $th_bg_color);
			imagecolortransparent($tmp_img, $th_bg_color);
			imagejpeg($tmp_img, null, 90);
			imagedestroy($tmp_img);
		}
	}
}
?>